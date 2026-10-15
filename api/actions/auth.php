<?php
declare(strict_types=1);

require_once __DIR__ . '/../helpers.php';

function traiterSession(PDO $pdo): void
{
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
}

function traiterConnectionUtilisateur(PDO $pdo, array $input): void
{
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
}

function traiterDeconnectionUtilisateur(): void
{
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
}

function traiterCreerUtilisateur(PDO $pdo, array $input): void
{
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
}

function traiterVerifMail(PDO $pdo): void
{
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
}

function traiterVerifCode(PDO $pdo, array $input): void
{
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
}
