<?php
/**
 * Vérifier la connexion à la base de données
 * Accès: /health.php
 */

include 'config.php';

$health = [
    'status' => 'ok',
    'app' => 'fintrack',
    'environment' => getenv('APP_ENV') ?: 'production',
    'database' => [
        'host' => getenv('DB_HOST') ?: 'localhost',
        'name' => getenv('DB_NAME') ?: 'gestion_depenses',
        'connected' => false,
        'error' => null
    ]
];

// Test connexion DB
try {
    $stmt = $cbd->prepare("SELECT 1");
    $stmt->execute();
    $health['database']['connected'] = true;
} catch (Exception $e) {
    $health['status'] = 'error';
    $health['database']['connected'] = false;
    $health['database']['error'] = $e->getMessage();
}

// Retourner JSON
header('Content-Type: application/json');
echo json_encode($health, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
?>
