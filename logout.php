<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Clear user session variables
unset($_SESSION['user_id']);
unset($_SESSION['user_username']);
unset($_SESSION['user_fullname']);

// Clear admin session variables (if exists)
unset($_SESSION['admin_id']);
unset($_SESSION['admin_username']);

// Clear remember me cookie
if (isset($_COOKIE['user_login'])) {
    setcookie('user_login', '', time() - 3600, '/');
}

// Redirect to home
redirect(SITE_URL . '/index.php');
?>