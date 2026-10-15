<?php
declare(strict_types=1);

require_once __DIR__ . '/api.php';
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/actions/auth.php';
require_once __DIR__ . '/actions/releves.php';

initialiserRequeteApi();

session_set_cookie_params([
    'httponly' => true,
    'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
    'samesite' => 'Strict',
    'path' => '/',
]);
session_start();

$input = json_decode(file_get_contents('php://input'), true);
if (!is_array($input)) {
    repondre(["erreur" => "Corps JSON invalide"], 400);
}

$action = $input['action'] ?? '';

try {
    switch ($action) {
        case 'session':
            traiterSession($pdo);
            break;

        case 'connection_utilisateur':
            traiterConnectionUtilisateur($pdo, $input);
            break;

        case 'deconnection_utilisateur':
            traiterDeconnectionUtilisateur();
            break;

        case 'creer_utilisateur':
            traiterCreerUtilisateur($pdo, $input);
            break;

        case 'verif_mail':
            traiterVerifMail($pdo);
            break;

        case 'verif_code':
            traiterVerifCode($pdo, $input);
            break;

        case 'dernier_releves':
            traiterDernierReleves($pdo);
            break;

        case 'historique_releves':
            traiterHistoriqueReleves($pdo);
            break;

        case 'ajouter_releve':
            traiterAjouterReleve($pdo, $input);
            break;

        case 'modifier_releve':
            traiterModifierReleve($pdo, $input);
            break;

        case 'supprimer_releve':
            traiterSupprimerReleve($pdo, $input);
            break;

        case 'supprimer_utilisateur':
            traiterSupprimerUtilisateur($pdo);
            break;

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
