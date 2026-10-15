<?php
declare(strict_types=1);

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

function initialiserRequeteApi(): void
{
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
}
