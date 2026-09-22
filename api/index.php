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

    case 'lister_utilisateurs':
        $stmt = $pdo->query("SELECT id, nom, prenom, email FROM user");
        echo json_encode(["resultat" => $stmt->fetchAll(PDO::FETCH_ASSOC)]);
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

    case 'supprimer_utilisateur':
        $id = $input['id'] ?? 0;

        $stmt = $pdo->prepare("DELETE FROM user WHERE id = :id");
        $stmt->execute(['id' => $id]);

        echo json_encode(["resultat" => "Utilisateur supprimé"]);
        break;

    default:
        http_response_code(400);
        echo json_encode(["erreur" => "Action non reconnue par le serveur"]);
        break;
}
