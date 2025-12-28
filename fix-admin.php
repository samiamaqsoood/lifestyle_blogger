<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

// This script will create/update the admin user with password "admin123"

if (!$conn) {
    die("Database connection failed!");
}

// Generate password hash for "admin123"
$password = 'admin123';
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

echo "<h2>Admin User Setup</h2>";
echo "<p><strong>Password:</strong> admin123</p>";
echo "<p><strong>Hashed Password:</strong> " . $hashed_password . "</p>";

// Check if admin user exists
$check_sql = "SELECT * FROM users WHERE username = 'admin' LIMIT 1";
$result = mysqli_query($conn, $check_sql);

if ($result && mysqli_num_rows($result) > 0) {
    // Admin exists, update password
    $update_sql = "UPDATE users SET password = '$hashed_password', email = 'admin@lifestyleblogger.com' WHERE username = 'admin'";
    if (mysqli_query($conn, $update_sql)) {
        echo "<p style='color: green;'>✓ Admin user password updated successfully!</p>";
    } else {
        echo "<p style='color: red;'>✗ Error updating admin: " . mysqli_error($conn) . "</p>";
    }
} else {
    // Admin doesn't exist, create it
    $insert_sql = "INSERT INTO users (username, password, email) VALUES ('admin', '$hashed_password', 'admin@lifestyleblogger.com')";
    if (mysqli_query($conn, $insert_sql)) {
        echo "<p style='color: green;'>✓ Admin user created successfully!</p>";
    } else {
        echo "<p style='color: red;'>✗ Error creating admin: " . mysqli_error($conn) . "</p>";
    }
}

// Verify the admin user
$verify_sql = "SELECT * FROM users WHERE username = 'admin' LIMIT 1";
$verify_result = mysqli_query($conn, $verify_sql);
if ($verify_result && mysqli_num_rows($verify_result) > 0) {
    $admin = mysqli_fetch_assoc($verify_result);
    echo "<hr>";
    echo "<h3>Admin User Details:</h3>";
    echo "<p><strong>ID:</strong> " . $admin['id'] . "</p>";
    echo "<p><strong>Username:</strong> " . $admin['username'] . "</p>";
    echo "<p><strong>Email:</strong> " . $admin['email'] . "</p>";
    
    // Test password verification
    if (password_verify('admin123', $admin['password'])) {
        echo "<p style='color: green;'>✓ Password verification successful!</p>";
    } else {
        echo "<p style='color: red;'>✗ Password verification failed!</p>";
    }
}

echo "<hr>";
echo "<p><strong>Next Steps:</strong></p>";
echo "<ol>";
echo "<li>Try logging in with username: <strong>admin</strong> and password: <strong>admin123</strong></li>";
echo "<li>Go to: <a href='login.php?type=admin'>login.php?type=admin</a></li>";
echo "<li>Make sure to select 'Admin Login' button</li>";
echo "<li>After testing, delete this file (fix-admin.php) for security</li>";
echo "</ol>";
?>

