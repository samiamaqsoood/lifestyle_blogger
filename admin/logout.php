<?php
require_once '../includes/config.php';

// Destroy session
session_destroy();

// Redirect to login page
header('Location: ' . SITE_URL . '/admin/index.php');
exit;
?>