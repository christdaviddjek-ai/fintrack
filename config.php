<?php
// Configuration pour InfinityFree (MySQL) - Variables d'environnement SÉCURISÉES
$host     = getenv('DB_HOST') ?: 'sql100.infinityfree.com';
$dbname   = getenv('DB_NAME') ?: 'if0_41685322_fintrack';
$user     = getenv('DB_USER') ?: 'if0_41685322';
$password = getenv('DB_PASSWORD') ?: ''; // JAMAIS en clair - utilise .env ou variables système
$port     = getenv('DB_PORT') ?: '3306';
$db_type  = getenv('DB_TYPE') ?: 'mysql';

// Construction DSN selon type BD
if ($db_type === 'mysql') {
    $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4";
} else {
    $dsn = "pgsql:host={$host};port={$port};dbname={$dbname}";
}

try {
    $cbd = new PDO($dsn, $user, $password);
    $cbd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $cbd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Erreur de connexion base de données: ' . $e->getMessage());
}

// Fonction helper MySQL (MONTH() et YEAR() fonctionnent nativement)
function convertSQL($query, $db_type = 'mysql') {
    return $query;
}
?>