<?php
/**
 * Configuration Centralisée - GestDépense
 * 
 * Ce fichier contient toutes les configurations de l'application
 */

// Configuration Base de Données
const DB_HOST = 'localhost';
const DB_NAME = 'gestion_depenses';
const DB_USER = 'root';
const DB_PASSWORD = '';
const DB_CHARSET = 'utf8mb4';

// Configuration Application
const APP_NAME = 'fintrack';
const APP_VERSION = '1.0.0';
const APP_TIMEZONE = 'Europe/Paris';

// Configuration Sécurité
const SESSION_TIMEOUT = 3600; // 1 heure en secondes
const PASSWORD_MIN_LENGTH = 6;
const MAX_FAILED_LOGINS = 5;

// Configuration Affichage
const ITEMS_PER_PAGE = 20;
const CURRENCY_SYMBOL = '€';
const DECIMAL_PLACES = 2;

// Messages
const MESSAGES = [
    'success' => [
        'login' => 'Connexion réussie!',
        'logout' => 'Déconnexion réussie!',
        'create' => 'Dépense créée avec succès!',
        'update' => 'Dépense mise à jour avec succès!',
        'delete' => 'Dépense supprimée avec succès!',
        'register' => 'Inscription réussie! Redirection vers la connexion...'
    ],
    'error' => [
        'invalid_credentials' => 'Identifiants invalides',
        'email_exists' => 'Cet email est déjà utilisé',
        'passwords_not_match' => 'Les mots de passe ne correspondent pas',
        'invalid_email' => 'Email invalide',
        'weak_password' => 'Le mot de passe doit contenir au moins 6 caractères',
        'unauthorized' => 'Vous n\'êtes pas autorisé à accéder à cette ressource',
        'not_found' => 'Ressource non trouvée',
        'database_error' => 'Erreur de base de données'
    ]
];

// Catégories par défaut
const DEFAULT_CATEGORIES = [
    ['nom' => 'Alimentation', 'icon' => '🍔', 'couleur' => '#4299e1'],
    ['nom' => 'Transport', 'icon' => '🚗', 'couleur' => '#38a169'],
    ['nom' => 'Logement', 'icon' => '🏠', 'couleur' => '#ed8936'],
    ['nom' => 'Loisirs', 'icon' => '🎮', 'couleur' => '#9f7aea'],
    ['nom' => 'Santé', 'icon' => '🏥', 'couleur' => '#e53e3e'],
    ['nom' => 'Éducation', 'icon' => '📚', 'couleur' => '#667eea'],
    ['nom' => 'Autres', 'icon' => '📌', 'couleur' => '#718096']
];

// Configuration Couleurs
const COLORS = [
    'primary' => '#667eea',
    'secondary' => '#764ba2',
    'success' => '#48bb78',
    'danger' => '#f56565',
    'warning' => '#ed8936',
    'info' => '#4299e1',
    'light' => '#f7fafc',
    'dark' => '#2d3748'
];

// Fonction d'initialisation
function initialize_session() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    date_default_timezone_set(APP_TIMEZONE);
}

// Fonction de connexion BD
function get_database_connection() {
    try {
        $dsn = sprintf(
            'mysql:host=%s;dbname=%s;charset=%s',
            DB_HOST,
            DB_NAME,
            DB_CHARSET
        );
        
        $connection = new PDO($dsn, DB_USER, DB_PASSWORD);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        return $connection;
    } catch (PDOException $e) {
        die('Erreur de connexion: ' . htmlspecialchars($e->getMessage()));
    }
}

// Fonction de formatage monétaire
function format_currency($amount) {
    return number_format($amount, DECIMAL_PLACES, ',', ' ') . ' ' . CURRENCY_SYMBOL;
}

// Fonction de formatage date
function format_date($date, $format = 'd/m/Y') {
    try {
        return date($format, strtotime($date));
    } catch (Exception $e) {
        return $date;
    }
}

// Fonction de vérification d'authentification
function is_authenticated() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

// Fonction de redirection de non-authentifiés
function require_login() {
    if (!is_authenticated()) {
        header('Location: connexion.php');
        exit();
    }
}

// Fonction de nettoyage input
function sanitize_input($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

// Fonction de validation email
function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

// Fonction de validation montant
function validate_amount($amount) {
    return is_numeric($amount) && $amount > 0;
}

// Affichage des erreurs d'environnement
if (!defined('APP_ENVIRONMENT') || APP_ENVIRONMENT !== 'production') {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}
?>
