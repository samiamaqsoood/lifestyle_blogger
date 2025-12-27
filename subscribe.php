<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? sanitize_input($_POST['email']) : '';
    
    // Validate email
    if (empty($email)) {
        echo json_encode([
            'success' => false,
            'message' => 'Please enter your email address.'
        ]);
        exit;
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode([
            'success' => false,
            'message' => 'Please enter a valid email address.'
        ]);
        exit;
    }
    
    // Check if email already exists
    $check_sql = "SELECT id FROM subscribers WHERE email = '$email'";
    $check_result = mysqli_query($conn, $check_sql);
    
    if (mysqli_num_rows($check_result) > 0) {
        echo json_encode([
            'success' => false,
            'message' => 'This email is already subscribed to our newsletter.'
        ]);
        exit;
    }
    
    // Insert into database
    $insert_sql = "INSERT INTO subscribers (email) VALUES ('$email')";
    
    if (mysqli_query($conn, $insert_sql)) {
        echo json_encode([
            'success' => true,
            'message' => 'Thank you for subscribing! Welcome to our community.'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'An error occurred. Please try again later.'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method.'
    ]);
}
?>