<?php
// Simple test script to diagnose 500 errors
// Access this file directly: https://blogbee.lovestoblog.com/test-connection.php

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Connection Test</h2>";

// Test 1: PHP Version
echo "<p><strong>PHP Version:</strong> " . phpversion() . "</p>";

// Test 2: Check if mysqli extension is loaded
if (extension_loaded('mysqli')) {
    echo "<p><strong>MySQLi Extension:</strong> ✓ Loaded</p>";
} else {
    echo "<p><strong>MySQLi Extension:</strong> ✗ NOT Loaded</p>";
}

// Test 3: Try database connection
echo "<h3>Database Connection Test</h3>";
define('DB_HOST', 'sql100.infinityfree.com');
define('DB_USER', 'if0_40772114');
define('DB_PASS', 'pookiehainap08');
define('DB_NAME', 'if0_40772114_lifestyle_blogger');

$conn = @mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn) {
    echo "<p><strong>Database Connection:</strong> ✓ Success</p>";
    echo "<p><strong>Database Name:</strong> " . DB_NAME . "</p>";
    
    // Test 4: Check if tables exist
    $tables = ['posts', 'categories', 'users', 'user_accounts', 'page_views', 'subscribers'];
    echo "<h3>Table Check</h3><ul>";
    foreach ($tables as $table) {
        $result = @mysqli_query($conn, "SHOW TABLES LIKE '$table'");
        if ($result && mysqli_num_rows($result) > 0) {
            echo "<li><strong>$table:</strong> ✓ Exists</li>";
        } else {
            echo "<li><strong>$table:</strong> ✗ Missing</li>";
        }
    }
    echo "</ul>";
    
    mysqli_close($conn);
} else {
    echo "<p><strong>Database Connection:</strong> ✗ Failed</p>";
    echo "<p><strong>Error:</strong> " . mysqli_connect_error() . "</p>";
}

// Test 5: Check file permissions
echo "<h3>File Permissions</h3>";
$files_to_check = [
    'includes/config.php',
    'includes/functions.php',
    'track-view.php',
    'index.php'
];

foreach ($files_to_check as $file) {
    if (file_exists($file)) {
        $perms = substr(sprintf('%o', fileperms($file)), -4);
        echo "<p><strong>$file:</strong> ✓ Exists (Permissions: $perms)</p>";
    } else {
        echo "<p><strong>$file:</strong> ✗ Missing</p>";
    }
}

// Test 6: Check if session works
echo "<h3>Session Test</h3>";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$_SESSION['test'] = 'working';
if (isset($_SESSION['test'])) {
    echo "<p><strong>Session:</strong> ✓ Working</p>";
} else {
    echo "<p><strong>Session:</strong> ✗ Not Working</p>";
}

echo "<hr><p><em>If all tests pass, the issue might be in the main PHP files. Check error logs.</em></p>";
?>

