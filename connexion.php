<?php 
session_start();
include 'config.php';
include 'security.php';

$error_message = '';
$csrf_token = generateCSRFToken();

if (isset($_POST['submit'])) {
    if (!verifyCSRFToken($_POST['csrf_token'] ?? '')) {
        $error_message = 'Erreur de sécurité : token invalide.';
    } else if (!checkLoginAttempts($_POST['email'] ?? '')) {
        $error_message = 'Trop de tentatives. Réessayez dans 15 minutes.';
        logSecurityEvent('LOGIN_BLOCKED', $_POST['email'] ?? 'unknown');
    } else {
        $email    = sanitizeInput($_POST['email'] ?? '');
        $password = sanitizeInput($_POST['mdp'] ?? '');

        if (!validateEmail($email)) {
            $error_message = 'Adresse email invalide.';
            incrementLoginAttempts($email);
        } else {
            $stmt = $cbd->prepare("SELECT id, nom, email, mot_de_passe FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['mot_de_passe'])) {
                $_SESSION['user_id']  = $user['id'];
                $_SESSION['user_nom'] = $user['nom'];
                resetLoginAttempts($email);
                logSecurityEvent('LOGIN_SUCCESS', $email);
                secureSafeRedirect('dashbordd.php');
            } else {
                $error_message = 'Email ou mot de passe incorrect.';
                incrementLoginAttempts($email);
                logSecurityEvent('LOGIN_FAILED', $email);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — fintrack</title>
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
                <li><a href="connexion.php" class="active">Connexion</a></li>
                <li><a href="inscription.php">S'inscrire</a></li>
            </ul>
        </div>
    </nav>

    <div class="form-container">
        <div class="form-header">
            <div class="form-logo">💰 fin<span>track</span></div>
            <h1 class="form-title">Bon retour 👋</h1>
            <p class="form-subtitle">Connectez-vous à votre espace personnel</p>
        </div>

        <?php if ($error_message): ?>
            <div class="alert alert-error">⚠️ <?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>

        <form action="#" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">

            <div class="form-group">
                <label for="email">Adresse email</label>
                <input type="email" id="email" name="email" placeholder="vous@exemple.com" required autocomplete="email">
            </div>

            <div class="form-group">
                <label for="mdp">Mot de passe</label>
                <input type="password" id="mdp" name="mdp" placeholder="Votre mot de passe" required autocomplete="current-password">
            </div>

            <button type="submit" name="submit" class="btn btn-primary btn-block btn-lg">
                Se connecter →
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
            <p>Pas encore de compte ? <a href="inscription.php">Créer un compte</a></p>
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
