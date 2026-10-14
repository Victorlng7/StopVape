<?php
function chargerEnv($chemin)
{
    if (!file_exists($chemin)) return false;

    $lignes = file($chemin, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lignes as $ligne) {
        if (strpos(trim($ligne), '#') === 0) continue;

        if (!str_contains($ligne, '=')) continue;
        list($nom, $valeur) = explode('=', $ligne, 2);
        $_ENV[trim($nom)] = trim($valeur);
    }
}
chargerEnv(__DIR__ . '/.env');

$host = $_ENV['DB_HOST'] ?? '127.0.0.1';
$db   = $_ENV['DB_NAME'] ?? '';
$user = $_ENV['DB_USER'] ?? 'root';
$pass = $_ENV['DB_PASS'] ?? '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $e) {
    error_log("Connexion base de données impossible : " . $e->getMessage());
    http_response_code(500);
    header("Content-Type: application/json; charset=UTF-8");
    die(json_encode(["erreur" => "Service temporairement indisponible"]));
}
