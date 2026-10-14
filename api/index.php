<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once 'api.php';

$input = json_decode(file_get_contents('php://input'), true);
$input = json_decode(file_get_contents('php://input'), true);
$action = $input['action'] ?? '';

switch ($action) {
    case 'dernier_releves':
        $id = $input['id'] ?? 0;

        $stmt = $pdo->prepare("SELECT * FROM suivi_quotidien WHERE user_id = :id ORDER BY id DESC LIMIT 1;");

        $stmt->execute(['id' => $id]);
        $releves = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(["resultat" => $releves]);
        break;

    case 'modifier_releve':
        $puffBrute = $input['puffBrute'] ?? '';
        $relevePuff = $input['relevePuff'] ?? '';
        $volume_ml = $input['volume_ml'] ?? '';
        $tauxNico = $input['tauxNico'] ?? '';
        $clopesmoke = $input['clopesmoke'] ?? '';
        $manque = $input['manque'] ?? '';
        $depense = $input['depense'] ?? '';
        $id = $input['id'] ?? '';

        $stmt = $pdo->prepare("
            UPDATE suivi_quotidien 
            SET releve_puff_brut = :releve_puff_brut, 
                puffs = :puffs, 
                volume_ml = :volume_ml, 
                taux_nicotine = :taux_nicotine,
                cigarettes_fumees = :cigarettes_fumees,
                niveau_manque = :niveau_manque,
                depenses_euros = :depenses_euros
            WHERE id = :id
        ");

        $stmt->execute([
            'releve_puff_brut'  => $puffBrute,
            'puffs'             => $relevePuff,
            'volume_ml'         => $volume_ml,
            'taux_nicotine'     => $tauxNico,
            'cigarettes_fumees' => $clopesmoke,
            'niveau_manque'     => $manque,
            'depenses_euros'    => $depense,
            'id'                => $id
        ]);
        $releves = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(["resultat" => $releves]);
        break;

    case 'supprimer_releve':
        $id = $input['id'] ?? 0;

        try {
            $stmt = $pdo->prepare("DELETE FROM suivi_quotidien WHERE id = :id");
            $stmt->execute(['id' => $id]);

            echo json_encode(["resultat" => "Relevé supprimé avec succès"]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["erreur" => $e->getMessage()]);
        }
        break;

    case 'verifier_utilisateurs':
        $user_mail = $input['mail'] ?? 0;

        $stmt = $pdo->prepare("
            SELECT * 
            FROM user
            WHERE email = :email 
        ");

        $stmt->execute(['email' => $user_mail]);
        $releves = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(["resultat" => $releves]);
        break;

    case 'connection_utilisateur':
        $user_mail = $input['mail'] ?? "";
        $user_password = $input['password'] ?? "";

        $stmt = $pdo->prepare("SELECT * FROM user WHERE email = :email");
        $stmt->execute(['email' => $user_mail]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($user_password, $user['mot_de_passe'])) {

            if ($user['est_verifie'] == 1) {
                unset($user['mot_de_passe']);
                echo json_encode(["resultat" => $user]);
            } else {
                echo json_encode(["error" => "Veuillez vérifier votre adresse e-mail avant de vous connecter."]);
            }
        } else {
            echo json_encode(["error" => "Utilisateur ou mot de passe incorrect."]);
        }

        break;

    case 'creer_utilisateur':
        $nom = $input['nom'] ?? '';
        $prenom = $input['prenom'] ?? '';
        $email = $input['email'] ?? '';
        $mdp = $input['mot_de_passe'] ?? '';

        $mdpHache = password_hash($mdp, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO user (nom, prenom, email, mot_de_passe) VALUES (:nom, :prenom, :email, :mdp)");
        $stmt->execute([
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'mdp' => $mdpHache
        ]);

        echo json_encode(["resultat" => "Utilisateur ajouté avec succès"]);
        break;

    case 'recuperer_id':
        $mail = $input['email'] ?? '';

        $stmt = $pdo->prepare("SELECT id FROM user WHERE email = :email");
        $stmt->execute([
            ':email' => $mail
        ]);

        $idUser = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["resultat" => $idUser]);
        break;

    case 'verif_mail':
        $id = $input["id"] ?? 0;

        $code = random_int(100000, 999999);
        $sent_at = date('Y-m-d H:i:s');
        $expires_at = date('Y-m-d H:i:s', strtotime('+15 minutes'));

        $stmt = $pdo->prepare("
            INSERT INTO login_verification (user_id, code, sent_at, expires_at) 
            VALUES (:user_id, :code, :sent_at, :expires_at)
        ");

        $stmt->execute([
            'user_id' => $id,
            'code' => $code,
            'sent_at' => $sent_at,
            'expires_at' => $expires_at
        ]);

        echo json_encode(["resultat" => "Code créer avec succes"]);
        break;

    case 'verif_code':
        $id = $input["id"] ?? 0;
        $codeIn = $input["code"] ?? 0;

        $stmt = $pdo->prepare("SELECT id, code, expires_at FROM login_verification WHERE user_id = :id AND is_used = 0 ORDER BY id DESC LIMIT 1");
        $stmt->execute(['id' => $id]);
        $verification = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($verification) {
            $current_time = date('Y-m-d H:i:s');

            if ((string)$verification['code'] === (string)$codeIn) {

                if ($current_time <= $verification['expires_at']) {
                    $stmt = $pdo->prepare("UPDATE user SET est_verifie = 1 WHERE id = :id");
                    $stmt->execute(['id' => $id]);

                    $stmt2 = $pdo->prepare("UPDATE login_verification SET is_used = 1 WHERE id = :verif_id");
                    $stmt2->execute(['verif_id' => $verification['id']]);

                    echo json_encode(["success" => "Code valide !"]);
                } else {
                    echo json_encode(["error" => "Le code a expiré."]);
                }
            } else {
                echo json_encode(["error" => "Code incorrect."]);
            }
        } else {
            echo json_encode(["error" => "Aucune demande de code trouvée."]);
        }

        break;

    case 'supprimer_utilisateur':
        $id = $input['id'] ?? 0;

        $stmt = $pdo->prepare("DELETE FROM user WHERE id = :id");
        $stmt->execute(['id' => $id]);

        echo json_encode(["resultat" => "Utilisateur supprimé"]);
        break;

    case 'ajouter_releve':
        $user_id = $input['id'] ?? 0;
        $releve_puff_brut = $input['puffBrute'] ?? 0;
        $puffs = $input['relevePuff'] ?? 0;
        $volume_ml = $input['volume_ml'] ?? 0;
        $taux_nicotine = $input['tauxNico'] ?? 0;
        $cigarettes_fumees = $input['clopesmoke'] ?? 0;
        $niveau_manque = $input['manque'] ?? 1;
        $depenses = $input['depense'] ?? 0;

        $date_releve = date('Y-m-d');

        $stmt = $pdo->prepare("
            INSERT INTO suivi_quotidien 
            (user_id, date_releve, releve_puff_brut, puffs, volume_ml, taux_nicotine, cigarettes_fumees, niveau_manque, depenses_euros) 
            VALUES 
            (:user_id, :date_releve, :releve_puff_brut, :puffs, :volume_ml, :taux_nicotine, :cigarettes_fumees, :niveau_manque, :depenses_euros)
        ");

        try {
            $stmt->execute([
                'user_id' => $user_id,
                'date_releve' => $date_releve,
                'releve_puff_brut' => $releve_puff_brut,
                'puffs' => $puffs,
                'volume_ml' => $volume_ml,
                'taux_nicotine' => $taux_nicotine,
                'cigarettes_fumees' => $cigarettes_fumees,
                'niveau_manque' => $niveau_manque,
                'depenses_euros' => $depenses
            ]);

            echo json_encode(["resultat" => "Relevé ajouté avec succès"]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["erreur" => $e->getMessage()]);
        }
        break;

    case 'historique_releves':
        $user_id = $input['id'] ?? 0;

        $stmt = $pdo->prepare("
            SELECT * 
            FROM suivi_quotidien 
            WHERE user_id = :user_id 
            ORDER BY date_releve ASC
        ");

        $stmt->execute(['user_id' => $user_id]);
        $releves = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(["resultat" => $releves]);
        break;

    default:
        http_response_code(400);
        echo json_encode(["erreur" => "Action non reconnue par le serveur"]);
        break;
}
