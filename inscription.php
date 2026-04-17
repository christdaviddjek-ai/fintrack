<?php 
ini_set('display_errors', 1);
error_reporting(E_ALL);
include 'config.php';

$error_message   = '';
$success_message = '';

if (isset($_POST['envoyer'])) {
    $nom              = htmlspecialchars($_POST['nom']);
    $email            = htmlspecialchars($_POST['email']);
    $password         = htmlspecialchars($_POST['mpd']);
    $confirm_password = htmlspecialchars($_POST['confirm_mpd']);
    $revenu           = isset($_POST['revenu']) ? floatval($_POST['revenu']) : 0;

    if ($password !== $confirm_password) {
        $error_message = 'Les mots de passe ne correspondent pas.';
    } elseif (strlen($password) < 6) {
        $error_message = 'Le mot de passe doit contenir au moins 6 caractères.';
    } else {
        try {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $cbd->prepare('INSERT INTO users (nom, email, mot_de_passe, revenu_mensuel) VALUES(?, ?, ?, ?)');
            $stmt->execute([$nom, $email, $hash, $revenu]);
            $success_message = 'Compte créé avec succès ! Redirection…';
            header('Refresh: 2; url=connexion.php');
        } catch (PDOException $e) {
            $error_message = 'Cet email est déjà utilisé.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription — fintrack</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a class="logo" href="index.html">💰 fin<span>track</span></a>
            <div class="hamburger">
                <span></span><span></span><span></span>
            </div>
            <ul class="nav-links">
                <li><a href="index.html">Accueil</a></li>
                <li><a href="connexion.php">Connexion</a></li>
                <li><a href="inscription.php" class="active">S'inscrire</a></li>
            </ul>
        </div>
    </nav>

    <div class="form-container" style="max-width:520px;">
        <div class="form-header">
            <div class="form-logo">💰 fin<span>track</span></div>
            <h1 class="form-title">Créer un compte</h1>
            <p class="form-subtitle">Gratuit, rapide et sans engagement</p>
        </div>

        <?php if ($error_message): ?>
            <div class="alert alert-error">⚠️ <?php echo $error_message; ?></div>
        <?php endif; ?>

        <?php if ($success_message): ?>
            <div class="alert alert-success">✅ <?php echo $success_message; ?></div>
        <?php endif; ?>

        <form action="#" method="POST">
            <div class="form-group">
                <label for="nom">Nom complet</label>
                <input type="text" id="nom" name="nom" placeholder="Jean Dupont" required autocomplete="name">
            </div>

            <div class="form-group">
                <label for="email">Adresse email</label>
                <input type="email" id="email" name="email" placeholder="vous@exemple.com" required autocomplete="email">
            </div>

            <div class="form-group">
                <label for="mpd">Mot de passe</label>
                <input type="password" id="mpd" name="mpd" placeholder="6 caractères minimum" required minlength="6" autocomplete="new-password">
            </div>

            <div class="form-group">
                <label for="confirm_mpd">Confirmer le mot de passe</label>
                <input type="password" id="confirm_mpd" name="confirm_mpd" placeholder="Retapez votre mot de passe" required minlength="6" autocomplete="new-password">
            </div>

            <div class="form-group">
                <label for="revenu">Revenu mensuel (Fr CFA)</label>
                <input type="number" id="revenu" name="revenu" placeholder="Ex: 500000 Fr" step="0.01" min="0" required>
            </div>

            <button type="submit" name="envoyer" class="btn btn-primary btn-block btn-lg">
                Créer mon compte →
            </button>

            <div class="form-divider">
                <span>OU</span>
            </div>

            <?php
            require_once 'google_config.php';
            
            // Construire l'URL OAuth Google
            $google_auth_url = 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query([
                'client_id' => GOOGLE_CLIENT_ID,
                'redirect_uri' => GOOGLE_REDIRECT_URI,
                'response_type' => 'code',
                'scope' => 'openid email profile',
                'access_type' => 'offline'
            ]);
            ?>

            <a href="<?php echo htmlspecialchars($google_auth_url); ?>" class="btn btn-secondary btn-block" style="background: white; color: #1f2937; border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; gap: 8px;">
                🔐 Continuer avec Google
            </a>
        </form>

        <div class="form-footer">
            <p>Déjà inscrit ? <a href="connexion.php">Se connecter</a></p>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p>© 2026 <strong>fintrack</strong>. Tous droits réservés.</p>
        </div>
    </footer>
    <script src="script.js"></script>
</body>
</html>
