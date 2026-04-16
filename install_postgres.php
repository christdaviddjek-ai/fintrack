<?php
/**
 * Script d'initialisation pour PostgreSQL
 * À utiliser sur Render avec PostgreSQL
 */

$host = getenv('DB_HOST') ?: 'localhost';
$dbname = getenv('DB_NAME') ?: 'postgres';
$user = getenv('DB_USER') ?: 'postgres';
$password = getenv('DB_PASSWORD') ?: '';
$port = getenv('DB_PORT') ?: '5432';

try {
    // Connexion à PostgreSQL
    $conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Créer la table users
    $conn->exec("
        CREATE TABLE IF NOT EXISTS users (
            id SERIAL PRIMARY KEY,
            nom VARCHAR(100) NOT NULL,
            email VARCHAR(100) UNIQUE NOT NULL,
            mot_de_passe VARCHAR(255) NOT NULL,
            revenu_mensuel DECIMAL(10, 2) DEFAULT 0,
            date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");
    
    // Créer la table categories
    $conn->exec("
        CREATE TABLE IF NOT EXISTS categories (
            id SERIAL PRIMARY KEY,
            nom VARCHAR(50) UNIQUE NOT NULL,
            description TEXT,
            icon VARCHAR(50),
            couleur VARCHAR(7) DEFAULT '#667eea'
        )
    ");
    
    // Créer la table depenses
    $conn->exec("
        CREATE TABLE IF NOT EXISTS depenses (
            id SERIAL PRIMARY KEY,
            user_id INT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
            montant DECIMAL(10, 2) NOT NULL,
            description TEXT,
            categorie_id INT NOT NULL REFERENCES categories(id) ON DELETE RESTRICT,
            date_depense DATE NOT NULL,
            date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");
    
    // Créer les index
    $conn->exec("CREATE INDEX IF NOT EXISTS idx_depenses_user_id ON depenses(user_id)");
    $conn->exec("CREATE INDEX IF NOT EXISTS idx_depenses_categorie_id ON depenses(categorie_id)");
    $conn->exec("CREATE INDEX IF NOT EXISTS idx_depenses_date ON depenses(date_depense)");
    
    // Insérer les catégories par défaut
    $categories = [
        ['nom' => 'Alimentation', 'icon' => '🍔', 'couleur' => '#4299e1'],
        ['nom' => 'Transport', 'icon' => '🚗', 'couleur' => '#38a169'],
        ['nom' => 'Logement', 'icon' => '🏠', 'couleur' => '#ed8936'],
        ['nom' => 'Loisirs', 'icon' => '🎮', 'couleur' => '#9f7aea'],
        ['nom' => 'Santé', 'icon' => '🏥', 'couleur' => '#e53e3e'],
        ['nom' => 'Éducation', 'icon' => '📚', 'couleur' => '#667eea'],
        ['nom' => 'Autres', 'icon' => '📌', 'couleur' => '#718096']
    ];
    
    $stmt = $conn->prepare("INSERT INTO categories (nom, icon, couleur) VALUES (?, ?, ?) ON CONFLICT DO NOTHING");
    
    foreach($categories as $cat) {
        $stmt->execute([$cat['nom'], $cat['icon'], $cat['couleur']]);
    }
    
    echo "<div style='background-color: #f0fff4; border-left: 4px solid #48bb78; padding: 15px; margin: 20px; border-radius: 5px;'>";
    echo "<h2 style='color: #22543d; margin: 0 0 10px 0;'>✅ Installation PostgreSQL réussie!</h2>";
    echo "<p style='color: #22543d; margin: 0;'>La base de données PostgreSQL a été initialisée avec succès.</p>";
    echo "<p style='color: #22543d; margin: 10px 0 0 0;'><a href='index.html' style='color: #22543d; font-weight: bold; text-decoration: none;'>→ Accéder à l'application</a></p>";
    echo "</div>";
    
} catch(PDOException $e) {
    echo "<div style='background-color: #fff5f5; border-left: 4px solid #f56565; padding: 15px; margin: 20px; border-radius: 5px;'>";
    echo "<h2 style='color: #742a2a; margin: 0 0 10px 0;'>❌ Erreur lors de l'installation</h2>";
    echo "<p style='color: #742a2a; margin: 0;'>" . htmlspecialchars($e->getMessage()) . "</p>";
    echo "</div>";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installation - fintrack</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body style="padding: 40px 20px;">
    <div style="max-width: 600px; margin: 0 auto;">
        <h1 style="text-align: center;">💰 fintrack - PostgreSQL Setup</h1>
    </div>
</body>
</html>
