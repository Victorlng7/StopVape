<?php
declare(strict_types=1);

require_once __DIR__ . '/../helpers.php';

function traiterDernierReleves(PDO $pdo): void
{
    $userId = utilisateurConnecte();
    $stmt = $pdo->prepare("
        SELECT * FROM suivi_quotidien
        WHERE user_id = :user_id ORDER BY id DESC LIMIT 1
    ");
    $stmt->execute(['user_id' => $userId]);
    repondre(["resultat" => $stmt->fetchAll()]);
}

function traiterHistoriqueReleves(PDO $pdo): void
{
    $userId = utilisateurConnecte();
    $stmt = $pdo->prepare("
        SELECT * FROM suivi_quotidien
        WHERE user_id = :user_id ORDER BY date_releve ASC
    ");
    $stmt->execute(['user_id' => $userId]);
    repondre(["resultat" => $stmt->fetchAll()]);
}

function traiterAjouterReleve(PDO $pdo, array $input): void
{
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
}

function traiterModifierReleve(PDO $pdo, array $input): void
{
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
}

function traiterSupprimerReleve(PDO $pdo, array $input): void
{
    $userId = utilisateurConnecte();
    $releveId = filter_var($input['id'] ?? null, FILTER_VALIDATE_INT);
    if (!$releveId) {
        repondre(["erreur" => "Relevé invalide"], 400);
    }
    $stmt = $pdo->prepare("DELETE FROM suivi_quotidien WHERE id = :id AND user_id = :user_id");
    $stmt->execute(['id' => $releveId, 'user_id' => $userId]);
    repondre(["success" => $stmt->rowCount() > 0]);
}

function traiterSupprimerUtilisateur(PDO $pdo): void
{
    $userId = utilisateurConnecte();
    $stmt = $pdo->prepare("DELETE FROM user WHERE id = :id");
    $stmt->execute(['id' => $userId]);
    $_SESSION = [];
    session_destroy();
    repondre(["success" => true]);
}
