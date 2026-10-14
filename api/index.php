<?php
declare(strict_types=1);

require_once 'api.php';

header("Content-Type: application/json; charset=UTF-8");
header("Cache-Control: no-store");
header("Vary: Origin");

$allowedOrigins = array_filter(array_map(
    'trim',
    explode(',', $_ENV['APP_ORIGINS'] ?? 'http://localhost:5173,http://127.0.0.1:5173')
));
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';

if ($origin !== '') {
    if (!in_array($origin, $allowedOrigins, true)) {
        http_response_code(403);
        echo json_encode(["erreur" => "Origine non autorisée"]);
        exit;
    }

    header("Access-Control-Allow-Origin: " . $origin);
    header("Access-Control-Allow-Credentials: true");
}

header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["erreur" => "Méthode non autorisée"]);
    exit;
}

if (stripos($_SERVER['CONTENT_TYPE'] ?? '', 'application/json') !== 0) {
    http_response_code(415);
    echo json_encode(["erreur" => "Content-Type application/json requis"]);
    exit;
}

session_set_cookie_params([
    'httponly' => true,
    'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
    'samesite' => 'Strict',
    'path' => '/',
]);
session_start();

function repondre(array $data, int $status = 200): never
{
    http_response_code($status);
    echo json_encode($data);
    exit;
}

function utilisateurConnecte(): int
{
    if (!isset($_SESSION['user_id'])) {
        repondre(["erreur" => "Authentification requise"], 401);
    }

    return (int) $_SESSION['user_id'];
}

function nombreValide(mixed $value, float $minimum = 0, ?float $maximum = null): bool
{
    return is_numeric($value)
        && (float) $value >= $minimum
        && ($maximum === null || (float) $value <= $maximum);
}

$input = json_decode(file_get_contents('php://input'), true);
if (!is_array($input)) {
    repondre(["erreur" => "Corps JSON invalide"], 400);
}

$action = $input['action'] ?? '';

try {
    switch ($action) {
        case 'session':
            if (!isset($_SESSION['user_id'])) {
                repondre(["utilisateur" => null]);
            }

            $stmt = $pdo->prepare("SELECT id, email, nom, prenom FROM user WHERE id = :id AND est_verifie = 1");
            $stmt->execute(['id' => $_SESSION['user_id']]);
            $user = $stmt->fetch();

            if (!$user) {
                $_SESSION = [];
                session_destroy();
                repondre(["utilisateur" => null]);
            }

            repondre(["utilisateur" => $user]);

        case 'connection_utilisateur':
            $email = strtolower(trim((string) ($input['mail'] ?? '')));
            $password = (string) ($input['password'] ?? '');

            $stmt = $pdo->prepare("SELECT id, email, nom, prenom, mot_de_passe, est_verifie FROM user WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();

            if (!$user || !password_verify($password, $user['mot_de_passe'])) {
                repondre(["erreur" => "Identifiants invalides"], 401);
            }
            if ((int) $user['est_verifie'] !== 1) {
                repondre(["erreur" => "Compte non vérifié"], 403);
            }

            session_regenerate_id(true);
            $_SESSION['user_id'] = (int) $user['id'];
            unset($user['mot_de_passe'], $user['est_verifie']);
            repondre(["utilisateur" => $user]);

        case 'deconnection_utilisateur':
            $_SESSION = [];
            if (ini_get('session.use_cookies')) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', [
                    'expires' => time() - 42000,
                    'path' => $params['path'],
                    'domain' => $params['domain'],
                    'secure' => $params['secure'],
                    'httponly' => $params['httponly'],
                    'samesite' => 'Strict',
                ]);
            }
            session_destroy();
            repondre(["success" => true]);

        case 'creer_utilisateur':
            $nom = trim((string) ($input['nom'] ?? ''));
            $prenom = trim((string) ($input['prenom'] ?? ''));
            $email = strtolower(trim((string) ($input['email'] ?? '')));
            $password = (string) ($input['mot_de_passe'] ?? '');

            if (
                $nom === '' || mb_strlen($nom) > 100
                || $prenom === '' || mb_strlen($prenom) > 100
                || !filter_var($email, FILTER_VALIDATE_EMAIL)
                || strlen($password) < 10
            ) {
                repondre(["erreur" => "Informations invalides (mot de passe : 10 caractères minimum)"], 400);
            }

            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO user (nom, prenom, email, mot_de_passe) VALUES (:nom, :prenom, :email, :password)");
            $stmt->execute([
                'nom' => $nom,
                'prenom' => $prenom,
                'email' => $email,
                'password' => $passwordHash,
            ]);

            $_SESSION['pending_verification_user_id'] = (int) $pdo->lastInsertId();
            repondre(["success" => true]);

        case 'verif_mail':
            $pendingUserId = (int) ($_SESSION['pending_verification_user_id'] ?? 0);
            if ($pendingUserId === 0) {
                repondre(["erreur" => "Inscription requise"], 401);
            }

            $code = random_int(100000, 999999);
            $stmt = $pdo->prepare("
                INSERT INTO login_verification (user_id, code, sent_at, expires_at)
                VALUES (:user_id, :code, NOW(), DATE_ADD(NOW(), INTERVAL 15 MINUTE))
            ");
            $stmt->execute(['user_id' => $pendingUserId, 'code' => (string) $code]);
            repondre(["success" => true]);

        case 'verif_code':
            $pendingUserId = (int) ($_SESSION['pending_verification_user_id'] ?? 0);
            $code = (string) ($input['code'] ?? '');
            if ($pendingUserId === 0 || !preg_match('/^\d{6}$/', $code)) {
                repondre(["erreur" => "Code invalide ou inscription requise"], 400);
            }

            $pdo->beginTransaction();
            $stmt = $pdo->prepare("
                SELECT id FROM login_verification
                WHERE user_id = :user_id AND code = :code AND is_used = 0 AND expires_at >= NOW()
                ORDER BY id DESC LIMIT 1 FOR UPDATE
            ");
            $stmt->execute(['user_id' => $pendingUserId, 'code' => $code]);
            $verification = $stmt->fetch();
            if (!$verification) {
                $pdo->rollBack();
                repondre(["erreur" => "Code invalide ou expiré"], 400);
            }

            $stmt = $pdo->prepare("UPDATE user SET est_verifie = 1 WHERE id = :id");
            $stmt->execute(['id' => $pendingUserId]);
            $stmt = $pdo->prepare("UPDATE login_verification SET is_used = 1 WHERE id = :id");
            $stmt->execute(['id' => $verification['id']]);
            $pdo->commit();
            unset($_SESSION['pending_verification_user_id']);
            repondre(["success" => true]);

        case 'dernier_releves':
            $userId = utilisateurConnecte();
            $stmt = $pdo->prepare("
                SELECT * FROM suivi_quotidien
                WHERE user_id = :user_id ORDER BY id DESC LIMIT 1
            ");
            $stmt->execute(['user_id' => $userId]);
            repondre(["resultat" => $stmt->fetchAll()]);

        case 'historique_releves':
            $userId = utilisateurConnecte();
            $stmt = $pdo->prepare("
                SELECT * FROM suivi_quotidien
                WHERE user_id = :user_id ORDER BY date_releve ASC
            ");
            $stmt->execute(['user_id' => $userId]);
            repondre(["resultat" => $stmt->fetchAll()]);

        case 'ajouter_releve':
            $userId = utilisateurConnecte();
            $fields = [
                'puffBrute' => [0, null],
                'relevePuff' => [0, null],
                'volume_ml' => [0, 999.99],
                'tauxNico' => [0, 999.99],
                'clopesmoke' => [0, null],
                'manque' => [0, 10],
                'depense' => [0, 9999.99],
            ];
            foreach ($fields as $field => [$minimum, $maximum]) {
                if (!nombreValide($input[$field] ?? null, $minimum, $maximum)) {
                    repondre(["erreur" => "Valeur invalide : " . $field], 400);
                }
            }

            $stmt = $pdo->prepare("
                INSERT INTO suivi_quotidien
                (user_id, date_releve, releve_puff_brut, puffs, volume_ml, taux_nicotine, cigarettes_fumees, niveau_manque, depenses_euros)
                VALUES (:user_id, CURDATE(), :puff_brut, :puffs, :volume, :nicotine, :cigarettes, :manque, :depenses)
            ");
            $stmt->execute([
                'user_id' => $userId,
                'puff_brut' => $input['puffBrute'],
                'puffs' => $input['relevePuff'],
                'volume' => $input['volume_ml'],
                'nicotine' => $input['tauxNico'],
                'cigarettes' => $input['clopesmoke'],
                'manque' => $input['manque'],
                'depenses' => $input['depense'],
            ]);
            repondre(["success" => true]);

        case 'modifier_releve':
            $userId = utilisateurConnecte();
            $releveId = filter_var($input['id'] ?? null, FILTER_VALIDATE_INT);
            if (!$releveId || !nombreValide($input['puffBrute'] ?? null) || !nombreValide($input['relevePuff'] ?? null)) {
                repondre(["erreur" => "Relevé invalide"], 400);
            }

            $stmt = $pdo->prepare("
                UPDATE suivi_quotidien
                SET releve_puff_brut = :puff_brut, puffs = :puffs, volume_ml = :volume,
                    taux_nicotine = :nicotine, cigarettes_fumees = :cigarettes,
                    niveau_manque = :manque, depenses_euros = :depenses
                WHERE id = :id AND user_id = :user_id
            ");
            $stmt->execute([
                'puff_brut' => $input['puffBrute'],
                'puffs' => $input['relevePuff'],
                'volume' => $input['volume_ml'] ?? 0,
                'nicotine' => $input['tauxNico'] ?? 0,
                'cigarettes' => $input['clopesmoke'] ?? 0,
                'manque' => $input['manque'] ?? 0,
                'depenses' => $input['depense'] ?? 0,
                'id' => $releveId,
                'user_id' => $userId,
            ]);
            repondre(["success" => $stmt->rowCount() > 0]);

        case 'supprimer_releve':
            $userId = utilisateurConnecte();
            $releveId = filter_var($input['id'] ?? null, FILTER_VALIDATE_INT);
            if (!$releveId) {
                repondre(["erreur" => "Relevé invalide"], 400);
            }
            $stmt = $pdo->prepare("DELETE FROM suivi_quotidien WHERE id = :id AND user_id = :user_id");
            $stmt->execute(['id' => $releveId, 'user_id' => $userId]);
            repondre(["success" => $stmt->rowCount() > 0]);

        case 'supprimer_utilisateur':
            $userId = utilisateurConnecte();
            $stmt = $pdo->prepare("DELETE FROM user WHERE id = :id");
            $stmt->execute(['id' => $userId]);
            $_SESSION = [];
            session_destroy();
            repondre(["success" => true]);

        default:
            repondre(["erreur" => "Action non reconnue"], 400);
    }
} catch (PDOException $exception) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    if ($exception->getCode() === '23000' && $action === 'creer_utilisateur') {
        repondre(["erreur" => "Impossible de créer le compte avec ces informations"], 409);
    }

    error_log("Erreur API : " . $exception->getMessage());
    repondre(["erreur" => "Erreur interne du serveur"], 500);
}
