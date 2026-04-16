<?php
/**
 * Script d'initialisation de la base de données
 * Ce script crée la base de données et les tables nécessaires
 */

$host = 'localhost';
$user = 'root';
$password = '';

// Connexion sans base de données pour créer la BD
try {
    $conn = new PDO("mysql:host=$host", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Créer la base de données
    $conn->exec("CREATE DATABASE IF NOT EXISTS gestion_depenses DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    
    // Sélectionner la base de données
    $conn->exec("USE gestion_depenses");
    
    // Créer la table users
    $conn->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INT PRIMARY KEY AUTO_INCREMENT,
            nom VARCHAR(100) NOT NULL,
            email VARCHAR(100) UNIQUE NOT NULL,
            mot_de_passe VARCHAR(255) NOT NULL,
            revenu_mensuel DECIMAL(10, 2) DEFAULT 0,
            date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    
    // Créer la table categories
    $conn->exec("
        CREATE TABLE IF NOT EXISTS categories (
            id INT PRIMARY KEY AUTO_INCREMENT,
            nom VARCHAR(50) NOT NULL UNIQUE,
            description TEXT,
            icon VARCHAR(50),
            couleur VARCHAR(7) DEFAULT '#667eea'
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    
    // Créer la table depenses
    $conn->exec("
        CREATE TABLE IF NOT EXISTS depenses (
            id INT PRIMARY KEY AUTO_INCREMENT,
            user_id INT NOT NULL,
            montant DECIMAL(10, 2) NOT NULL,
            description TEXT,
            categorie_id INT NOT NULL,
            date_depense DATE NOT NULL,
            date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (categorie_id) REFERENCES categories(id) ON DELETE RESTRICT,
            INDEX idx_user_id (user_id),
            INDEX idx_categorie_id (categorie_id),
            INDEX idx_date_depense (date_depense)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    
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
    
    $stmt = $conn->prepare("INSERT IGNORE INTO categories (nom, icon, couleur) VALUES (?, ?, ?)");
    
    foreach($categories as $cat) {
        $stmt->execute([$cat['nom'], $cat['icon'], $cat['couleur']]);
    }
    
    echo "<div style='background-color: #f0fff4; border-left: 4px solid #48bb78; padding: 15px; margin: 20px; border-radius: 5px;'>";
    echo "<h2 style='color: #22543d; margin: 0 0 10px 0;'>✅ Installation réussie!</h2>";
    echo "<p style='color: #22543d; margin: 0;'>La base de données 'gestion_depenses' a été créée avec succès.</p>";
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
<body>
    <nav class="navbar">
        <div class="container">
            <div class="logo">💰 fintrack</div>
        </div>
    </nav>

    <div class="container" style="padding: 40px 20px;">
        <h1 style="text-align: center; margin-bottom: 40px;">Installation de fintrack</h1>
        
        <div style="max-width: 800px; margin: 0 auto;">
            <div style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); margin-bottom: 20px;">
                <h2 style="color: #667eea; margin-bottom: 20px;">Configuration</h2>
                
                <div style="background-color: #f7fafc; padding: 15px; border-radius: 5px; margin-bottom: 20px; font-family: 'Courier New', monospace; font-size: 13px; overflow-x: auto;">
                    <p style="margin: 0;"><strong>Hôte:</strong> localhost</p>
                    <p style="margin: 5px 0;"><strong>Utilisateur:</strong> root</p>
                    <p style="margin: 5px 0;"><strong>Mot de passe:</strong> (vide)</p>
                    <p style="margin: 5px 0 0 0;"><strong>Base de données:</strong> gestion_depenses</p>
                </div>

                <div style="background-color: #fffaf0; border-left: 4px solid #ed8936; padding: 15px; border-radius: 5px;">
                    <p style="margin: 0; color: #7c2d12;"><strong>⚠️ Important:</strong> Si vous utilisez une configuration différente (mot de passe MySQL différent, hôte différent, etc.), modifiez le fichier <code style="background: #f7fafc; padding: 2px 6px; border-radius: 3px;">config.php</code> avant de continuer.</p>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2026 fintrack. Tous droits réservés.</p>
    </footer>
    <script src="script.js"></script>
</body>
</html>
