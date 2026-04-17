<?php
/**
 * Sécurité - Protections centralisées fintrack
 */

// 1. DÉMARRER SESSION SÉCURISÉE
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    
    // Régénérer l'ID de session après login
    if (isset($_SESSION['user_id']) && !isset($_SESSION['session_regenerated'])) {
        session_regenerate_id(true);
        $_SESSION['session_regenerated'] = true;
    }
}

// 2. GÉNÉRER CSRF TOKEN
function generateCSRFToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// 3. VÉRIFIER CSRF TOKEN
function verifyCSRFToken($token) {
    if (empty($_SESSION['csrf_token']) || empty($token)) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
}

// 4. RATE LIMITING - LOGIN
function checkLoginAttempts($email, $max_attempts = 5, $window = 900) {
    // window = 15 minutes (900 secondes)
    $key = "login_attempt_{$email}";
    
    if (!isset($_SESSION[$key])) {
        $_SESSION[$key] = ['count' => 0, 'first_attempt' => time()];
    }
    
    $attempts = &$_SESSION[$key];
    $elapsed = time() - $attempts['first_attempt'];
    
    // Reset après la window
    if ($elapsed > $window) {
        $attempts = ['count' => 0, 'first_attempt' => time()];
    }
    
    // Bloquer après max attempts
    if ($attempts['count'] >= $max_attempts) {
        return false;
    }
    
    return true;
}

// 5. INCRÉMENTER TENTATIVES
function incrementLoginAttempts($email) {
    $key = "login_attempt_{$email}";
    if (!isset($_SESSION[$key])) {
        $_SESSION[$key] = ['count' => 0, 'first_attempt' => time()];
    }
    $_SESSION[$key]['count']++;
}

// 6. RESET TENTATIVES (après login réussi)
function resetLoginAttempts($email) {
    $key = "login_attempt_{$email}";
    unset($_SESSION[$key]);
}

// 7. SANITIZE INPUT
function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

// 8. VALIDER EMAIL
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// 9. VALIDER PASSWORD FORCE
function validatePassword($password) {
    // Au moins 8 caractères, 1 majuscule, 1 chiffre
    return strlen($password) >= 8 && 
           preg_match('/[A-Z]/', $password) && 
           preg_match('/[0-9]/', $password);
}

// 10. REDIRECT SÉCURISÉ (empêche open redirect)
function secureSafeRedirect($url, $default = 'index.html') {
    $parsed = parse_url($url);
    
    // Vérifier que c'est une URL locale
    if (empty($parsed['host']) || $parsed['host'] === $_SERVER['HTTP_HOST']) {
        header("Location: {$url}");
        exit();
    }
    
    // Fallback sécurisé
    header("Location: {$default}");
    exit();
}

// 11. PROTECTION CONTRA XSS - Output
function escapeOutput($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

// 12. LOG SÉCURITÉ (optionnel)
function logSecurityEvent($event, $details = '') {
    $log_file = __DIR__ . '/logs/security.log';
    if (!is_dir(__DIR__ . '/logs')) {
        mkdir(__DIR__ . '/logs', 0755, true);
    }
    
    $timestamp = date('Y-m-d H:i:s');
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $user_id = $_SESSION['user_id'] ?? 'anonymous';
    
    $message = "[{$timestamp}] IP:{$ip} User:{$user_id} Event:{$event} {$details}\n";
    
    error_log($message, 3, $log_file);
}

?>
