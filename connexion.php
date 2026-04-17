<?php 
session_start();
include 'config.php';
include 'security.php';

$error_message = '';
$csrf_token = generateCSRFToken();

if (isset($_POST['submit'])) {
    // 1. VÉRIFIER CSRF TOKEN
    if (!verifyCSRFToken($_POST['csrf_token'] ?? '')) {
        $error_message = '⚠️ Erreur de sécurité: Token CSRF invalide';
    }
    // 2. VÉRIFIER RATE LIMITING
    else if (!checkLoginAttempts($_POST['email'] ?? '')) {
        $error_message = '❌ Trop de tentatives. Réessaye dans 15 minutes.';
        logSecurityEvent('LOGIN_BLOCKED', $_POST['email'] ?? 'unknown');
    }
    else {
        $email = sanitizeInput($_POST['email'] ?? '');
        $password = sanitizeInput($_POST['mdp'] ?? '');
        
        // 3. VALIDER EMAIL
        if (!validateEmail($email)) {
            $error_message = '❌ Email invalide';
            incrementLoginAttempts($email);
        } else {
            // 4. CHERCHER USER
            $stmt = $cbd->prepare("SELECT id, nom, email, mot_de_passe FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if($user && password_verify($password, $user['mot_de_passe'])) {
                // LOGIN RÉUSSI
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_nom'] = $user['nom'];
                resetLoginAttempts($email);
                logSecurityEvent('LOGIN_SUCCESS', $email);
                secureSafeRedirect('dashbordd.php');
            } else {
                $error_message = '❌ Email ou mot de passe incorrect';
                incrementLoginAttempts($email);
                logSecurityEvent('LOGIN_FAILED', $email);
            }
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
    <title>Connexion - fintrack</title>
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
                <li><a href="index.html">Accueil</a></li>
                <li><a href="connexion.php" class="active">Connexion</a></li>
                <li><a href="inscription.php">S'inscrire</a></li>
            </ul>
        </div>
    </nav>

    <div class="form-container">
        <h1 class="form-title">Connexion</h1>
        
        <?php if(isset($error_message)): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>

        <form action="#" method="POST">
            <!-- CSRF Token -->
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Entrez votre email" required>
            </div>

            <div class="form-group">
                <label for="mdp">Mot de passe</label>
                <input type="password" id="mdp" name="mdp" placeholder="Entrez votre mot de passe" required>
            </div>

            <button type="submit" name="submit" class="btn btn-primary" style="width: 100%;">Se connecter</button>
        </form>

        <div class="form-footer">
            <p>Pas encore inscrit? <a href="inscription.php">S'inscrire ici</a></p>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2026 fintrack. Tous droits réservés.</p>
    </footer>
    <script src="script.js"></script>
</body>
</html>