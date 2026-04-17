<?php
require_once 'config.php';
require_once 'google_config.php';
require_once 'security.php';

session_start();

// Vérifier le code d'autorisation
if (!isset($_GET['code'])) {
    die('❌ Erreur: Pas de code d\'autorisation reçu. Veuillez réessayer.');
}

$code = $_GET['code'];

// Échanger le code pour un token
$token_url = 'https://oauth2.googleapis.com/token';
$post_data = [
    'code' => $code,
    'client_id' => GOOGLE_CLIENT_ID,
    'client_secret' => GOOGLE_CLIENT_SECRET,
    'redirect_uri' => GOOGLE_REDIRECT_URI,
    'grant_type' => 'authorization_code'
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $token_url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);
curl_close($ch);

$token_data = json_decode($response, true);

if (!isset($token_data['access_token'])) {
    die('❌ Erreur: Impossible d\'obtenir le token d\'accès.');
}

$access_token = $token_data['access_token'];

// Récupérer les infos utilisateur
$userinfo_url = 'https://www.googleapis.com/oauth2/v2/userinfo?access_token=' . $access_token;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $userinfo_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$user_response = curl_exec($ch);
curl_close($ch);

$google_user = json_decode($user_response, true);

if (!isset($google_user['email'])) {
    die('❌ Erreur: Impossible de récupérer les infos Google.');
}

// Extraire les infos
$email = $google_user['email'];
$nom = $google_user['name'] ?? 'Utilisateur';
$google_id = $google_user['id'];

// Vérifier/créer l'utilisateur
try {
    // Chercher si l'utilisateur existe
    $stmt = $cbd->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        // Utilisateur existe → login
        $_SESSION['user_id'] = $user['id'];
        header('Location: dashbordd.php');
        exit;
    } else {
        // Nouvel utilisateur → créer un compte
        // Générer un mot de passe aléatoire (non utilisé avec Google)
        $random_password = bin2hex(random_bytes(16));
        $hashed_password = password_hash($random_password, PASSWORD_BCRYPT);
        
        // Revenu par défaut = 0
        $default_revenu = 0;

        $stmt = $cbd->prepare(
            'INSERT INTO users (nom, email, mot_de_passe, revenu_mensuel) VALUES (?, ?, ?, ?)'
        );
        $stmt->execute([$nom, $email, $hashed_password, $default_revenu]);
        
        // Récupérer l'ID du nouvel utilisateur
        $stmt = $cbd->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $new_user = $stmt->fetch();

        // Login
        $_SESSION['user_id'] = $new_user['id'];
        
        // Rediriger vers profil pour compléter le revenu
        header('Location: profil.php?nouveau=1');
        exit;
    }
} catch (Exception $e) {
    die('❌ Erreur base de données: ' . $e->getMessage());
}
?>
