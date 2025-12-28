<?php
// Enable error reporting for debugging (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 0); // Set to 0 in production, 1 for debugging
ini_set('log_errors', 1);

// Database configuration
define('DB_HOST', 'sql100.infinityfree.com');
define('DB_USER', 'if0_40772114');
define('DB_PASS', 'pookiehainap08');
define('DB_NAME', 'if0_40772114_lifestyle_blogger');

// Site configuration
define('SITE_URL', 'https://blogbee.lovestoblog.com');
define('SITE_NAME', 'Lifestyle Blogger');
define('SITE_DESCRIPTION', 'Welcome to My Journey of Discovery and Growth');

// Create database connection
$conn = @mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if (!$conn) {
    // Log error instead of displaying sensitive info
    error_log("Database connection failed: " . mysqli_connect_error());
    // Show user-friendly error
    die("Database connection error. Please contact the administrator.");
}

// Set charset to UTF-8
if (!mysqli_set_charset($conn, "utf8mb4")) {
    error_log("Error setting charset: " . mysqli_error($conn));
}

// Start session with secure settings
if (session_status() === PHP_SESSION_NONE) {
    // Set secure session parameters
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        ini_set('session.cookie_secure', 1);
    }
    session_start();
}
?>