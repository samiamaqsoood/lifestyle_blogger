<?php
if (!defined('DB_HOST')) {
    require_once 'config.php';
    require_once 'functions.php';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - ' : ''; ?><?php echo SITE_NAME; ?></title>
    <meta name="description" content="<?php echo SITE_DESCRIPTION; ?>">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo SITE_URL; ?>/assets/images/favicon.ico?v=<?php echo time(); ?>">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo SITE_URL; ?>/assets/images/favicon.ico?v=<?php echo time(); ?>">
    <link rel="icon" type="image/vnd.microsoft.icon" href="<?php echo SITE_URL; ?>/assets/images/favicon.ico?v=<?php echo time(); ?>">
    <link rel="apple-touch-icon" href="<?php echo SITE_URL; ?>/assets/images/favicon.ico?v=<?php echo time(); ?>">
    
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <nav class="navbar">
            <div class="container">
                <div class="nav-wrapper">
                    <a href="<?php echo SITE_URL; ?>" class="logo">
                        <img src="<?php echo SITE_URL; ?>/assets/images/favicon.ico" alt="Lifestyle Blogger Logo" class="logo-image">
                        <span class="logo-text">Lifestyle Blogger</span>
                    </a>
                    
                    <button class="mobile-menu-toggle" id="mobileMenuToggle">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                    
                    <ul class="nav-menu" id="navMenu">
                        <li><a href="<?php echo SITE_URL; ?>/index.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">Home</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/blog.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'blog.php' ? 'active' : ''; ?>">Blog</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/about.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'about.php' ? 'active' : ''; ?>">About</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/contact.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'active' : ''; ?>">Contact</a></li>
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <li><a href="<?php echo SITE_URL; ?>/logout.php" title="Logout"><i class="fas fa-sign-out-alt"></i></a></li>
                        <?php else: ?>
                            <li><a href="<?php echo SITE_URL; ?>/login.php" title="Login"><i class="fas fa-sign-in-alt"></i></a></li>
                        <?php endif; ?>
                    </ul>
                    
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <div class="user-greeting" style="margin-right: 15px; color: var(--primary-color); font-weight: 500;">
                            Welcome, <?php echo htmlspecialchars($_SESSION['user_fullname'] ?? $_SESSION['user_username']); ?>!
                        </div>
                    <?php endif; ?>
                    
                    <button class="subscribe-btn">Subscribe</button>
                </div>
            </div>
        </nav>
    </header>

    <!-- Subscribe Modal -->
    <div class="modal" id="subscribeModal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h2>Subscribe to Newsletter</h2>
            <p>Get the latest updates and articles directly in your inbox.</p>
            <form id="subscribeForm" method="POST">
                <input type="email" name="email" placeholder="Enter your email" required>
                <button type="submit">Subscribe</button>
            </form>
            <div id="subscribeMessage"></div>
        </div>
    </div>