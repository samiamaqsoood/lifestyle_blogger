<?php
require_once 'includes/config.php';

// Clear user session
unset($_SESSION['user_id']);
unset($_SESSION['user_username']);
unset($_SESSION['user_fullname']);

// Clear remember me cookie
if (isset($_COOKIE['user_login'])) {
    setcookie('user_login', '', time() - 3600, '/');
}

// Redirect to home
redirect(SITE_URL . '/index.php');
?>