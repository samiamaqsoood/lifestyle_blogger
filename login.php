<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

// If already logged in, redirect
if (isset($_SESSION['user_id'])) {
    redirect(SITE_URL . '/index.php');
}

$error = '';
$login_type = isset($_GET['type']) && $_GET['type'] === 'admin' ? 'admin' : 'user';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check database connection first
    if (!$conn) {
        $error = 'Database connection error. Please try again later.';
    } else {
        $username = sanitize_input($_POST['username']);
        $password = $_POST['password'];
        $remember = isset($_POST['remember']);
        // Check if admin_login is explicitly set to '1', not just if it exists
        $is_admin_login = isset($_POST['admin_login']) && $_POST['admin_login'] === '1';
        
        if (empty($username) || empty($password)) {
            $error = 'Please enter both username and password.';
        } else {
            if ($is_admin_login) {
                // Admin login - only allow admin users
                $username_escaped = mysqli_real_escape_string($conn, $username);
                $sql = "SELECT * FROM users WHERE username = '$username_escaped' LIMIT 1";
                $result = @mysqli_query($conn, $sql);
                
                if ($result && mysqli_num_rows($result) === 1) {
                    $user = mysqli_fetch_assoc($result);
                    
                    if (password_verify($password, $user['password'])) {
                        $_SESSION['admin_id'] = $user['id'];
                        $_SESSION['admin_username'] = $user['username'];
                        redirect(SITE_URL . '/admin/dashboard.php');
                    } else {
                        $error = 'Invalid admin credentials.';
                    }
                } else {
                    $error = 'Invalid admin credentials.';
                }
            } else {
                // User login - only allow regular users (not admins)
                $username_escaped = mysqli_real_escape_string($conn, $username);
                $sql = "SELECT * FROM user_accounts WHERE (username = '$username_escaped' OR email = '$username_escaped') LIMIT 1";
                $result = @mysqli_query($conn, $sql);
                
                if ($result && mysqli_num_rows($result) === 1) {
                    $user = mysqli_fetch_assoc($result);
                    
                    if (password_verify($password, $user['password'])) {
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['user_username'] = $user['username'];
                        $_SESSION['user_fullname'] = $user['fullname'];
                        
                        // Remember me functionality
                        if ($remember) {
                            setcookie('user_login', $user['id'], time() + (86400 * 30), '/');
                        }
                        
                        // Redirect to previous page or home
                        $redirect_url = isset($_SESSION['redirect_after_login']) ? $_SESSION['redirect_after_login'] : SITE_URL . '/index.php';
                        unset($_SESSION['redirect_after_login']);
                        redirect($redirect_url);
                    } else {
                        $error = 'Invalid username or password.';
                    }
                } else {
                    $error = 'Invalid username or password.';
                }
            }
        }
    }
}

$page_title = 'Login';
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

.login-type-toggle {
    display: flex;
    gap: 10px;
    margin-bottom: 30px;
}

.login-type-btn {
    flex: 1;
    padding: 12px;
    background-color: var(--light-bg);
    border: 2px solid var(--border-color);
    border-radius: 5px;
    cursor: pointer;
    transition: var(--transition);
    font-weight: 500;
}

.login-type-btn.active {
    background-color: var(--primary-color);
    color: #fff;
    border-color: var(--primary-color);
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

.form-options {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.remember-me {
    display: flex;
    align-items: center;
    gap: 8px;
}

.remember-me input {
    width: auto;
}

.forgot-password {
    color: var(--primary-color);
    font-size: 0.9rem;
}

.error-message {
    background-color: #f8d7da;
    color: #721c24;
    padding: 12px 15px;
    border-radius: 5px;
    margin-bottom: 20px;
    border-left: 4px solid #e74c3c;
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

.admin-notice {
    background-color: #fff3cd;
    color: #856404;
    padding: 12px 15px;
    border-radius: 5px;
    margin-bottom: 20px;
    border-left: 4px solid #ffc107;
    display: none;
}

.admin-notice.show {
    display: block;
}
</style>

<section class="auth-container">
    <div class="container">
        <div class="auth-box">
            <h1>Welcome Back</h1>
            <p class="subtitle">Login to continue your journey</p>
            
            <div class="login-type-toggle">
                <button type="button" class="login-type-btn <?php echo $login_type === 'user' ? 'active' : ''; ?>" 
                        onclick="switchLoginType('user')">User Login</button>
                <button type="button" class="login-type-btn <?php echo $login_type === 'admin' ? 'active' : ''; ?>" 
                        onclick="switchLoginType('admin')">Admin Login</button>
            </div>
            
            <div class="admin-notice" id="adminNotice">
                <strong>Admin Login:</strong> This is for website administrators only. Regular users should use "User Login".
            </div>
            
            <?php if ($error): ?>
                <div class="error-message" role="alert"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST" id="loginForm">
                <input type="hidden" name="admin_login" id="admin_login" value="<?php echo $login_type === 'admin' ? '1' : '0'; ?>">
                
                <div class="form-group">
                    <label for="username">
                        <span id="usernameLabel">Username or Email</span> <span style="color: #e74c3c;">*</span>
                    </label>
                    <input type="text" id="username" name="username" required autocomplete="off"
                           aria-required="true">
                </div>
                
                <div class="form-group">
                    <label for="password">Password <span style="color: #e74c3c;">*</span></label>
                    <div class="password-field">
                        <input type="password" id="password" name="password" required 
                               aria-required="true">
                        <i class="fas fa-eye password-toggle" id="togglePassword" 
                           onclick="togglePasswordVisibility()"
                           aria-label="Toggle password visibility"></i>
                    </div>
                </div>
                
                <div class="form-options">
                    <label class="remember-me" id="rememberSection">
                        <input type="checkbox" name="remember" value="1">
                        <span>Remember me</span>
                    </label>
                    <a href="forgot-password.php" class="forgot-password" id="forgotPasswordLink">Forgot Password?</a>
                </div>
                
                <button type="submit" class="submit-btn">Login</button>
            </form>
            
            <div class="auth-footer" id="signupLink">
                Don't have an account? <a href="register.php">Sign up here</a>
            </div>
        </div>
    </div>
</section>

<script>
// Password visibility toggle
function togglePasswordVisibility() {
    const input = document.getElementById('password');
    const icon = document.getElementById('togglePassword');
    
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

// Switch between user and admin login
function switchLoginType(type) {
    const buttons = document.querySelectorAll('.login-type-btn');
    buttons.forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    
    const adminInput = document.getElementById('admin_login');
    const adminNotice = document.getElementById('adminNotice');
    const usernameLabel = document.getElementById('usernameLabel');
    const rememberSection = document.getElementById('rememberSection');
    const forgotPasswordLink = document.getElementById('forgotPasswordLink');
    const signupLink = document.getElementById('signupLink');
    
    if (type === 'admin') {
        adminInput.value = '1';
        adminNotice.classList.add('show');
        usernameLabel.textContent = 'Admin Username';
        rememberSection.style.display = 'none';
        forgotPasswordLink.style.display = 'none';
        signupLink.style.display = 'none';
        
        // Update URL
        window.history.pushState({}, '', '?type=admin');
    } else {
        adminInput.value = '0';
        adminNotice.classList.remove('show');
        usernameLabel.textContent = 'Username or Email';
        rememberSection.style.display = 'flex';
        forgotPasswordLink.style.display = 'block';
        signupLink.style.display = 'block';
        
        // Update URL
        window.history.pushState({}, '', '?type=user');
    }
}

// Initialize on page load
window.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const type = urlParams.get('type') || 'user';
    
    if (type === 'admin') {
        document.querySelector('.login-type-btn:last-child').click();
    }
});
</script>

<?php include 'includes/footer.php'; ?>