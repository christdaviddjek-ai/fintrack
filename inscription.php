<?php 
ini_set('display_errors', 1);
error_reporting(E_ALL);
include 'config.php';

$error_message = '';
$success_message = '';

if(isset($_POST['envoyer'])){
    $nom = htmlspecialchars($_POST['nom']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['mpd']);
    $confirm_password = htmlspecialchars($_POST['confirm_mpd']);
    $revenu = isset($_POST['revenu']) ? floatval($_POST['revenu']) : 0;

    if($password !== $confirm_password) {
        $error_message = 'Les mots de passe ne correspondent pas';
    } elseif(strlen($password) < 6) {
        $error_message = 'Le mot de passe doit contenir au moins 6 caractères';
    } else {
        try {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $cbd->prepare('INSERT INTO users (nom, email, mot_de_passe, revenu_mensuel) VALUES(?, ?, ?, ?)');
            $stmt->execute([$nom, $email, $hash, $revenu]);
            $success_message = 'Inscription réussie! Redirection vers la connexion...';
            header('Refresh: 2; url=connexion.php');
        } catch(PDOException $e) {
            $error_message = 'Cet email est déjà utilisé';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - fintrack</title>
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
                <li><a href="connexion.php">Connexion</a></li>
                <li><a href="inscription.php" class="active">S'inscrire</a></li>
            </ul>
        </div>
    </nav>

    <div class="form-container">
        <h1 class="form-title">Créer un compte</h1>
        
        <?php if($error_message): ?>
            <div class="alert alert-error"><?php echo $error_message; ?></div>
        <?php endif; ?>
        
        <?php if($success_message): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <form action="#" method="POST">
            <div class="form-group">
                <label for="nom">Nom complet</label>
                <input type="text" id="nom" name="nom" placeholder="Entrez votre nom complet" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Entrez votre email" required>
            </div>

            <div class="form-group">
                <label for="mpd">Mot de passe</label>
                <input type="password" id="mpd" name="mpd" placeholder="Minimum 6 caractères" required minlength="6">
            </div>

            <div class="form-group">
                <label for="confirm_mpd">Confirmer le mot de passe</label>
                <input type="password" id="confirm_mpd" name="confirm_mpd" placeholder="Confirmez votre mot de passe" required minlength="6">
            </div>

            <div class="form-group">
                <label for="revenu">Revenu Mensuel (€)</label>
                <input type="number" id="revenu" name="revenu" placeholder="Ex: 2500" step="0.01" min="0" required>
            </div>

            <button type="submit" name="envoyer" class="btn btn-primary" style="width: 100%;">S'inscrire</button>
        </form>

        <div class="form-footer">
            <p>Déjà inscrit? <a href="connexion.php">Se connecter ici</a></p>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2026 fintrack. Tous droits réservés.</p>
    </footer>
    <script src="script.js"></script>
</body>
</html>