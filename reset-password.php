<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

$error = '';
$success = '';
$valid_token = false;

// Check if token is provided
if (!isset($_GET['token']) || empty($_GET['token'])) {
    $error = 'Invalid or missing reset token.';
} else {
    $token = sanitize_input($_GET['token']);
    
    // Verify token
    $sql = "SELECT * FROM user_accounts WHERE reset_token = '$token' AND reset_expires > NOW()";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) === 1) {
        $valid_token = true;
        $user = mysqli_fetch_assoc($result);
        
        // Handle password reset
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];
            
            if (empty($password) || empty($confirm_password)) {
                $error = 'Please fill in all fields.';
            } elseif (strlen($password) < 6) {
                $error = 'Password must be at least 6 characters long.';
            } elseif ($password !== $confirm_password) {
                $error = 'Passwords do not match.';
            } else {
                // Hash new password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                
                // Update password and clear reset token
                $update_sql = "UPDATE user_accounts SET 
                              password = '$hashed_password',
                              reset_token = NULL,
                              reset_expires = NULL
                              WHERE id = {$user['id']}";
                
                if (mysqli_query($conn, $update_sql)) {
                    $success = 'Password reset successful! You can now login with your new password.';
                    $valid_token = false; // Prevent form from showing
                } else {
                    $error = 'An error occurred. Please try again.';
                }
            }
        }
    } else {
        $error = 'Invalid or expired reset token. Please request a new password reset.';
    }
}

$page_title = 'Reset Password';
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

.password-field {
    position: relative;
}

.password-toggle {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: var(--light-text);
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
</style>

<section class="auth-container">
    <div class="container">
        <div class="auth-box">
            <h1>Reset Password</h1>
            <p class="subtitle">Enter your new password</p>
            
            <?php if ($error): ?>
                <div class="error-message" role="alert"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="success-message" role="alert">
                    <?php echo $success; ?>
                    <br><br>
                    <a href="login.php" class="btn btn-primary" style="display: inline-block; margin-top: 10px;">Go to Login</a>
                </div>
            <?php endif; ?>
            
            <?php if ($valid_token && !$success): ?>
            <form method="POST" id="resetForm">
                <div class="form-group">
                    <label for="password">New Password <span style="color: #e74c3c;">*</span></label>
                    <div class="password-field">
                        <input type="password" id="password" name="password" required 
                               minlength="6" aria-required="true">
                        <i class="fas fa-eye password-toggle" id="togglePassword" 
                           onclick="togglePasswordVisibility('password', 'togglePassword')"
                           aria-label="Toggle password visibility"></i>
                    </div>
                    <small style="color: var(--light-text);">Minimum 6 characters</small>
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">Confirm New Password <span style="color: #e74c3c;">*</span></label>
                    <div class="password-field">
                        <input type="password" id="confirm_password" name="confirm_password" required 
                               aria-required="true" aria-describedby="password-match-error">
                        <i class="fas fa-eye password-toggle" id="toggleConfirmPassword" 
                           onclick="togglePasswordVisibility('confirm_password', 'toggleConfirmPassword')"
                           aria-label="Toggle confirm password visibility"></i>
                    </div>
                    <div id="password-match-error" style="color: #e74c3c; font-size: 0.9rem; margin-top: 5px; display: none;" role="alert"></div>
                </div>
                
                <button type="submit" class="submit-btn">Reset Password</button>
            </form>
            <?php endif; ?>
            
            <div class="auth-footer">
                <a href="login.php">← Back to Login</a>
            </div>
        </div>
    </div>
</section>

<script>
// Password visibility toggle
function togglePasswordVisibility(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// Password match validation
document.getElementById('confirm_password')?.addEventListener('input', function(e) {
    const password = document.getElementById('password').value;
    const confirmPassword = e.target.value;
    const errorDiv = document.getElementById('password-match-error');
    
    if (confirmPassword && password !== confirmPassword) {
        errorDiv.textContent = 'Passwords do not match';
        errorDiv.style.display = 'block';
        e.target.setCustomValidity('Passwords do not match');
    } else {
        errorDiv.style.display = 'none';
        e.target.setCustomValidity('');
    }
});

// Real-time password match on password field change
document.getElementById('password')?.addEventListener('input', function() {
    const confirmPassword = document.getElementById('confirm_password');
    if (confirmPassword.value) {
        confirmPassword.dispatchEvent(new Event('input'));
    }
});
</script>

<?php include 'includes/footer.php'; ?>