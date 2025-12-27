<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize_input($_POST['email']);
    
    if (empty($email)) {
        $error = 'Please enter your email address.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } else {
        // Check if email exists
        $sql = "SELECT * FROM user_accounts WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) === 1) {
            $user = mysqli_fetch_assoc($result);
            
            // Generate reset token
            $token = bin2hex(random_bytes(32));
            $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
            
            // Store token in database
            $update_sql = "UPDATE user_accounts SET 
                          reset_token = '$token', 
                          reset_expires = '$expires' 
                          WHERE email = '$email'";
            
            if (mysqli_query($conn, $update_sql)) {
                // In real application, send email with reset link
                $reset_link = SITE_URL . "/reset-password.php?token=$token";
                
                // For demo purposes, show the link
                $success = "Password reset instructions have been sent to your email. 
                           <br><br><strong>Demo Link:</strong> <a href='$reset_link'>Click here to reset password</a>
                           <br><small>(In production, this would be sent via email)</small>";
                
                // In production, use PHPMailer or similar:
                // mail($email, "Password Reset", "Click here to reset: $reset_link");
            } else {
                $error = 'An error occurred. Please try again.';
            }
        } else {
            // Don't reveal if email doesn't exist (security best practice)
            $success = 'If an account exists with this email, you will receive password reset instructions.';
        }
    }
}

$page_title = 'Forgot Password';
include 'includes/header.php';
?>

<style>
.auth-container {
    padding: 80px 0;
    background-color: var(--light-bg);
}

.auth-box {
    max-width: 500px;
    margin: 0 auto;
    background: #fff;
    padding: 40px;
    border-radius: 10px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

.auth-box h1 {
    text-align: center;
    margin-bottom: 10px;
    color: var(--secondary-color);
}

.auth-box .subtitle {
    text-align: center;
    color: var(--light-text);
    margin-bottom: 30px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: var(--secondary-color);
}

.form-group input {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid var(--border-color);
    border-radius: 5px;
    font-size: 1rem;
    transition: var(--transition);
}

.form-group input:focus {
    outline: none;
    border-color: var(--primary-color);
}

.error-message {
    background-color: #f8d7da;
    color: #721c24;
    padding: 12px 15px;
    border-radius: 5px;
    margin-bottom: 20px;
    border-left: 4px solid #e74c3c;
}

.success-message {
    background-color: #d4edda;
    color: #155724;
    padding: 12px 15px;
    border-radius: 5px;
    margin-bottom: 20px;
    border-left: 4px solid #28a745;
}

.submit-btn {
    width: 100%;
    padding: 15px;
    background-color: var(--primary-color);
    color: #fff;
    border: none;
    border-radius: 5px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
}

.submit-btn:hover {
    background-color: #c89563;
}

.auth-footer {
    text-align: center;
    margin-top: 20px;
    color: var(--light-text);
}

.auth-footer a {
    color: var(--primary-color);
    font-weight: 500;
}

.info-box {
    background-color: #e3f2fd;
    color: #1565c0;
    padding: 12px 15px;
    border-radius: 5px;
    margin-bottom: 20px;
    border-left: 4px solid #2196f3;
}
</style>

<section class="auth-container">
    <div class="container">
        <div class="auth-box">
            <h1>Forgot Password?</h1>
            <p class="subtitle">Enter your email to reset your password</p>
            
            <div class="info-box">
                <i class="fas fa-info-circle"></i>
                Enter the email address associated with your account and we'll send you a link to reset your password.
            </div>
            
            <?php if ($error): ?>
                <div class="error-message" role="alert"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="success-message" role="alert"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <?php if (!$success): ?>
            <form method="POST">
                <div class="form-group">
                    <label for="email">Email Address <span style="color: #e74c3c;">*</span></label>
                    <input type="email" id="email" name="email" required autocomplete="off"
                           placeholder="Enter your registered email"
                           aria-required="true">
                </div>
                
                <button type="submit" class="submit-btn">Send Reset Link</button>
            </form>
            <?php endif; ?>
            
            <div class="auth-footer">
                Remember your password? <a href="login.php">Login here</a>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>