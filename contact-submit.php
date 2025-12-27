<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? sanitize_input($_POST['name']) : '';
    $email = isset($_POST['email']) ? sanitize_input($_POST['email']) : '';
    $subject = isset($_POST['subject']) ? sanitize_input($_POST['subject']) : '';
    $message = isset($_POST['message']) ? sanitize_input($_POST['message']) : '';
    
    // Validate inputs
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        echo json_encode([
            'success' => false,
            'message' => 'Please fill in all required fields.'
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
    
    // In a real application, you would:
    // 1. Send an email notification
    // 2. Store the message in a database
    // 3. Integrate with a CRM or notification system
    
    // For this university project, we'll just simulate success
    // You can add email functionality using PHP's mail() function or PHPMailer
    
    // Example: Store in database (create a contacts table if needed)
    // $sql = "INSERT INTO contacts (name, email, subject, message, created_at) 
    //         VALUES ('$name', '$email', '$subject', '$message', NOW())";
    // mysqli_query($conn, $sql);
    
    // Simulate sending email
    $to = "admin@lifestyleblogger.com";
    $email_subject = "New Contact Form Submission: " . $subject;
    $email_body = "Name: $name\n";
    $email_body .= "Email: $email\n";
    $email_body .= "Subject: $subject\n\n";
    $email_body .= "Message:\n$message";
    
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    
    // Note: mail() function requires proper mail server configuration
    // For XAMPP, you need to configure php.ini with SMTP settings
    // For university project demo, we'll just return success
    
    // mail($to, $email_subject, $email_body, $headers);
    
    echo json_encode([
        'success' => true,
        'message' => 'Thank you for your message! I will get back to you soon.'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method.'
    ]);
}
?>