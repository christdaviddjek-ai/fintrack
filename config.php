<?php
// Configuration pour local ET Render (MySQL ou PostgreSQL)
$host = getenv('DB_HOST') ?: 'localhost';
$dbname = getenv('DB_NAME') ?: 'gestion_depenses';
$user = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASSWORD') ?: '';
$port = getenv('DB_PORT') ?: '5432'; // PostgreSQL par défaut sur Render
$db_type = getenv('DB_TYPE') ?: 'postgres'; // 'mysql' ou 'postgres'

// Construction du DSN selon le type de BD
if ($db_type === 'mysql') {
    $port = $port === '5432' ? '3306' : $port; // Correction port par défaut MySQL
    $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4";
} else {
    // PostgreSQL (défaut pour Render)
    $dsn = "pgsql:host={$host};port={$port};dbname={$dbname};";
}

try {
    $cbd = new PDO($dsn, $user, $password);
    $cbd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $cbd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Erreur de connexion base de données: ' . $e->getMessage());
}

// Fonction helper pour rendre les requêtes compatibles PostgreSQL/MySQL
function convertSQL($query, $db_type = 'postgres') {
    if ($db_type === 'mysql') {
        return $query; // MySQL utilise MONTH() et YEAR()
    }
    
    // PostgreSQL: convertir MONTH(date) -> EXTRACT(MONTH FROM date)
    //             convertir YEAR(date) -> EXTRACT(YEAR FROM date)
    $query = preg_replace_callback('/MONTH\((\w+(?:\.\w+)?)\)/i', function($m) {
        return 'EXTRACT(MONTH FROM ' . $m[1] . ')';
    }, $query);
    
    $query = preg_replace_callback('/YEAR\((\w+(?:\.\w+)?)\)/i', function($m) {
        return 'EXTRACT(YEAR FROM ' . $m[1] . ')';
    }, $query);
    
    return $query;
}
?>