<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

// If already logged in, redirect to home
if (isset($_SESSION['user_id'])) {
    redirect(SITE_URL . '/index.php');
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = sanitize_input($_POST['fullname']);
    $username = sanitize_input($_POST['username']);
    $email = sanitize_input($_POST['email']);
    $phone = sanitize_input($_POST['phone']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $captcha_response = $_POST['g-recaptcha-response'] ?? '';
    
    // Validation
    if (empty($fullname) || empty($username) || empty($email) || empty($phone) || empty($password) || empty($confirm_password)) {
        $error = 'Please fill in all required fields.';
    } elseif (strtolower($username) === 'admin') {
        $error = 'Username "admin" is not allowed. Please choose another username.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters long.';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match.';
    } elseif (empty($captcha_response)) {
        $error = 'Please complete the captcha verification.';
    } else {
        // Verify reCAPTCHA with Google
        $recaptcha_secret = RECAPTCHA_SECRET_KEY;
        $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
        $recaptcha_data = [
            'secret' => $recaptcha_secret,
            'response' => $captcha_response,
            'remoteip' => $_SERVER['REMOTE_ADDR'] ?? ''
        ];
        
        $recaptcha_options = [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-Type: application/x-www-form-urlencoded',
                'content' => http_build_query($recaptcha_data)
            ]
        ];
        
        $recaptcha_context = stream_context_create($recaptcha_options);
        $recaptcha_result = @file_get_contents($recaptcha_url, false, $recaptcha_context);
        $recaptcha_json = json_decode($recaptcha_result, true);
        
        if (!$recaptcha_json || !isset($recaptcha_json['success']) || !$recaptcha_json['success']) {
            $error = 'reCAPTCHA verification failed. Please try again.';
        } else {
            // Check if username exists
            $check_username = mysqli_query($conn, "SELECT id FROM user_accounts WHERE username = '$username'");
            if (mysqli_num_rows($check_username) > 0) {
                $error = 'Username already exists. Please choose another one.';
            } else {
                // Check if email exists
                $check_email = mysqli_query($conn, "SELECT id FROM user_accounts WHERE email = '$email'");
                if (mysqli_num_rows($check_email) > 0) {
                    $error = 'Email already registered. Please use another email or login.';
                } else {
                    // Hash password
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    
                    // Insert user
                    $sql = "INSERT INTO user_accounts (fullname, username, email, phone, password, created_at) 
                            VALUES ('$fullname', '$username', '$email', '$phone', '$hashed_password', NOW())";
                    
                    if (mysqli_query($conn, $sql)) {
                        $success = 'Registration successful! You can now login.';
                        // Optionally auto-login
                        // $_SESSION['user_id'] = mysqli_insert_id($conn);
                        // redirect(SITE_URL . '/index.php');
                    } else {
                        $error = 'Registration failed. Please try again.';
                    }
                }
            }
        }
    }
}

$page_title = 'Sign Up';
include 'includes/header.php';
?>

<style>
.auth-container {
    padding: 80px 0;
    background-color: var(--light-bg);
}

.auth-box {
    max-width: 600px;
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

.form-group label .required {
    color: #e74c3c;
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

.captcha-container {
    margin-bottom: 20px;
    display: flex;
    justify-content: center;
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

.username-error {
    color: #e74c3c;
    font-size: 0.9rem;
    margin-top: 5px;
    display: none;
}

.username-error.show {
    display: block;
}
</style>

<section class="auth-container">
    <div class="container">
        <div class="auth-box">
            <h1>Create Your Account</h1>
            <p class="subtitle">Join our community and start exploring</p>
            
            <?php if ($error): ?>
                <div class="error-message" role="alert"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="success-message" role="alert">
                    <?php echo $success; ?>
                    <a href="login.php">Click here to login</a>
                </div>
            <?php endif; ?>
            
            <form method="POST" id="registerForm" novalidate>
                <div class="form-group">
                    <label for="fullname">Full Name <span class="required">*</span></label>
                    <input type="text" id="fullname" name="fullname" required 
                           value="<?php echo isset($_POST['fullname']) ? htmlspecialchars($_POST['fullname']) : ''; ?>"
                           aria-required="true">
                </div>
                
                <div class="form-group">
                    <label for="username">Username <span class="required">*</span></label>
                    <input type="text" id="username" name="username" required 
                           value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"
                           aria-required="true" aria-describedby="username-error">
                    <div class="username-error" id="username-error" role="alert">
                        Username "admin" is not allowed. Please choose another username.
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="email">Email Address <span class="required">*</span></label>
                    <input type="email" id="email" name="email" required autocomplete="off"
                           value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                           aria-required="true">
                </div>
                
                <div class="form-group">
                    <label for="phone">Phone Number <span class="required">*</span></label>
                    <input type="tel" id="phone" name="phone" required 
                           value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>"
                           aria-required="true">
                </div>
                
                <div class="form-group">
                    <label for="password">Password <span class="required">*</span></label>
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
                    <label for="confirm_password">Confirm Password <span class="required">*</span></label>
                    <div class="password-field">
                        <input type="password" id="confirm_password" name="confirm_password" required 
                               aria-required="true" aria-describedby="password-match-error">
                        <i class="fas fa-eye password-toggle" id="toggleConfirmPassword" 
                           onclick="togglePasswordVisibility('confirm_password', 'toggleConfirmPassword')"
                           aria-label="Toggle confirm password visibility"></i>
                    </div>
                    <div id="password-match-error" style="color: #e74c3c; font-size: 0.9rem; margin-top: 5px; display: none;" role="alert"></div>
                </div>
                
                <div class="captcha-container">
                    <div class="g-recaptcha" data-sitekey="<?php echo RECAPTCHA_SITE_KEY; ?>" data-theme="light"></div>
                </div>
                
                <button type="submit" class="submit-btn">Create Account</button>
            </form>
            
            <div class="auth-footer">
                Already have an account? <a href="login.php">Login here</a>
            </div>
        </div>
    </div>
</section>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>
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

// Username validation (prevent "admin")
document.getElementById('username').addEventListener('input', function(e) {
    const username = e.target.value.toLowerCase();
    const errorDiv = document.getElementById('username-error');
    
    if (username === 'admin') {
        errorDiv.classList.add('show');
        e.target.setCustomValidity('Username "admin" is not allowed');
    } else {
        errorDiv.classList.remove('show');
        e.target.setCustomValidity('');
    }
});

// Password match validation
document.getElementById('confirm_password').addEventListener('input', function(e) {
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
document.getElementById('password').addEventListener('input', function() {
    const confirmPassword = document.getElementById('confirm_password');
    if (confirmPassword.value) {
        confirmPassword.dispatchEvent(new Event('input'));
    }
});
</script>

<?php include 'includes/footer.php'; ?>