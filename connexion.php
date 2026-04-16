<?php 
session_start();
include 'config.php';

$error_message = '';

if (isset($_POST['submit'])) {
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['mdp']);

    $stmt = $cbd->prepare("SELECT id, nom, email, mot_de_passe FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user) {
        if(password_verify($password, $user['mot_de_passe'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_nom'] = $user['nom'];
            header('Location: dashbordd.php');
            exit();
        } else {
            $error_message = 'Mot de passe incorrect';
        }
    } else {
        $error_message = 'Email introuvable';
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