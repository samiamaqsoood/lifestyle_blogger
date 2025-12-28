<?php
require_once 'includes/config.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>reCAPTCHA Test</title>
</head>
<body>
    <h2>reCAPTCHA Configuration Test</h2>
    
    <p><strong>Site Key:</strong> <?php echo RECAPTCHA_SITE_KEY; ?></p>
    <p><strong>Secret Key:</strong> <?php echo substr(RECAPTCHA_SECRET_KEY, 0, 20); ?>...</p>
    <p><strong>Domain:</strong> <?php echo parse_url(SITE_URL, PHP_URL_HOST); ?></p>
    
    <hr>
    
    <h3>Test reCAPTCHA Widget:</h3>
    <div id="status" style="padding: 10px; margin: 10px 0; background: #f0f0f0; border-radius: 5px;">
        <strong>Status:</strong> <span id="statusText">Loading...</span>
    </div>
    
    <form>
        <div class="g-recaptcha" data-sitekey="<?php echo RECAPTCHA_SITE_KEY; ?>" id="recaptcha-widget"></div>
        <br>
        <button type="submit">Test</button>
    </form>
    
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
    // Check reCAPTCHA loading status
    window.addEventListener('load', function() {
        setTimeout(function() {
            var statusText = document.getElementById('statusText');
            var recaptchaWidget = document.getElementById('recaptcha-widget');
            
            if (typeof grecaptcha !== 'undefined') {
                statusText.textContent = '✓ reCAPTCHA API loaded successfully';
                statusText.style.color = 'green';
                
                // Check if widget rendered
                setTimeout(function() {
                    var iframe = recaptchaWidget.querySelector('iframe');
                    if (iframe) {
                        statusText.textContent = '✓ reCAPTCHA widget rendered successfully!';
                        statusText.style.color = 'green';
                    } else {
                        statusText.textContent = '⚠ reCAPTCHA API loaded but widget not rendered. Check console for errors.';
                        statusText.style.color = 'orange';
                    }
                }, 2000);
            } else {
                statusText.textContent = '✗ reCAPTCHA API failed to load. Check network or domain settings.';
                statusText.style.color = 'red';
            }
        }, 1000);
    });
    
    // Listen for reCAPTCHA errors
    window.addEventListener('error', function(e) {
        if (e.message && e.message.includes('recaptcha')) {
            document.getElementById('statusText').textContent = '✗ Error: ' + e.message;
            document.getElementById('statusText').style.color = 'red';
        }
    });
    </script>
    
    <hr>
    <p><strong>Debugging Steps:</strong></p>
    <ol>
        <li>Check browser console (F12) for any errors</li>
        <li>Verify domain <code><?php echo parse_url(SITE_URL, PHP_URL_HOST); ?></code> is in Google console</li>
        <li>Verify Site Key matches: <code><?php echo RECAPTCHA_SITE_KEY; ?></code></li>
        <li>Clear browser cache and try again</li>
        <li>Try in incognito/private window</li>
    </ol>
    
    <hr>
    <p><strong>If widget shows "Invalid site key":</strong></p>
    <ol>
        <li>Go to <a href="https://www.google.com/recaptcha/admin" target="_blank">Google reCAPTCHA Console</a></li>
        <li>Click on your site (blogbee.lovestoblog.com)</li>
        <li>Click "Settings" or edit icon</li>
        <li>Under "Domains", make sure <code>blogbee.lovestoblog.com</code> is listed</li>
        <li>If not, click "+ Add a domain" and add it</li>
        <li>Save and wait 5-10 minutes</li>
    </ol>
</body>
</html>

