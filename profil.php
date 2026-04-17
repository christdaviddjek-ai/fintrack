<?php
require_once 'config.php';
require_once 'security.php';

session_start();

// Vérifier l'authentification
if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$message = '';
$message_type = '';

// Récupérer les infos utilisateur
$stmt = $cbd->prepare("SELECT nom, email, revenu_mensuel FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

// Traiter la soumission du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validation CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $message = 'Erreur de sécurité. Veuillez réessayer.';
        $message_type = 'error';
    } else {
        $revenu = isset($_POST['revenu']) ? floatval($_POST['revenu']) : 0;
        
        // Validation
        if ($revenu < 0) {
            $message = 'Le revenu ne peut pas être négatif.';
            $message_type = 'error';
        } else {
            try {
                $stmt = $cbd->prepare("UPDATE users SET revenu_mensuel = ? WHERE id = ?");
                $stmt->execute([$revenu, $user_id]);
                
                $message = 'Revenu mensuel mis à jour avec succès!';
                $message_type = 'success';
                
                // Rafraîchir les données
                $user['revenu_mensuel'] = $revenu;
            } catch (Exception $e) {
                $message = 'Erreur lors de la mise à jour: ' . $e->getMessage();
                $message_type = 'error';
            }
        }
    }
}

// Générer token CSRF
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil - fintrack</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="logo">💰 fintrack</div>
            <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <ul class="nav-links">
                <li><a href="dashbordd.php">Dashboard</a></li>
                <li><a href="crud_depense.php">Dépenses</a></li>
                <li><a href="profil.php" class="active">Mon Profil</a></li>
                <li><a href="logout.php">Déconnexion</a></li>
            </ul>
        </div>
    </nav>

    <div class="container" style="padding: 40px 0;">
        <div class="page-header">
            <h1>Mon Profil</h1>
            <p>Gérez vos informations personnelles</p>
        </div>

        <!-- Messages d'alerte -->
        <?php if ($message): ?>
            <div class="alert alert-<?php echo $message_type; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 32px; max-width: 900px;">
            
            <!-- Section Informations -->
            <div class="form-container" style="margin: 0; padding: 32px;">
                <h2 style="margin-bottom: 24px; color: var(--text-primary); font-family: var(--font-display); font-size: 20px; font-weight: 700;">Informations Personnelles</h2>
                
                <div class="form-group">
                    <label>Nom Complet</label>
                    <input type="text" value="<?php echo htmlspecialchars($user['nom']); ?>" disabled style="background: var(--surface-3); cursor: not-allowed;">
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" value="<?php echo htmlspecialchars($user['email']); ?>" disabled style="background: var(--surface-3); cursor: not-allowed;">
                </div>

                <p style="color: var(--text-muted); font-size: 13px; margin-top: 16px;">
                    💡 Pour modifier votre nom ou email, contactez l'administrateur.
                </p>
            </div>

            <!-- Section Revenu -->
            <div class="form-container" style="margin: 0; padding: 32px;">
                <h2 style="margin-bottom: 24px; color: var(--text-primary); font-family: var(--font-display); font-size: 20px; font-weight: 700;">Revenu Mensuel</h2>
                
                <form method="POST">
                    <div class="form-group">
                        <label for="revenu">Revenu Mensuel (Fr CFA)</label>
                        <input 
                            type="number" 
                            id="revenu" 
                            name="revenu" 
                            value="<?php echo number_format($user['revenu_mensuel'], 2, '.', ''); ?>"
                            step="0.01"
                            min="0"
                            required
                            placeholder="Ex: 500000 Fr"
                        >
                    </div>

                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        💾 Mettre à jour
                    </button>
                </form>

                <div style="margin-top: 20px; padding: 16px; background: var(--emerald-glow); border-radius: var(--radius-md); border-left: 3px solid var(--emerald);">
                    <p style="color: var(--text-secondary); font-size: 13px; margin: 0;">
                        <strong>💡 Revenu Actuel:</strong><br>
                        <?php echo number_format($user['revenu_mensuel'], 2); ?> Fr CFA
                    </p>
                </div>
            </div>

        </div>

        <!-- Section Statistiques Rapides -->
        <div style="margin-top: 48px; padding: 24px; background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-lg);">
            <h3 style="color: var(--text-primary); font-family: var(--font-display); font-size: 16px; font-weight: 700; margin-bottom: 16px;">
                📊 À Quoi Sert Votre Revenu?
            </h3>
            <ul style="color: var(--text-secondary); font-size: 14px; line-height: 1.8; list-style: none; padding: 0;">
                <li>✅ Calculer votre <strong>budget restant</strong> chaque mois</li>
                <li>✅ Voir le <strong>pourcentage de dépenses</strong> par rapport à votre revenu</li>
                <li>✅ Recevoir une <strong>alerte</strong> si vous dépensez plus que votre revenu</li>
                <li>✅ Analyser vos <strong>habitudes de dépenses</strong></li>
            </ul>
        </div>

    </div>

    <footer class="footer">
        <strong>fintrack</strong> © 2026 — Gestion simple de vos dépenses
    </footer>

    <script src="script.js"></script>
</body>
</html>
