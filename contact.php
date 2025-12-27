<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

$page_title = 'Contact';

include 'includes/header.php';
?>

<style>
.contact-hero {
    padding: 60px 0;
    background-color: var(--light-bg);
    text-align: center;
}

.contact-hero h1 {
    font-size: 3rem;
    margin-bottom: 1rem;
}

.contact-content {
    padding: 80px 0;
}

.contact-wrapper {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    max-width: 1000px;
    margin: 0 auto;
}

.contact-info h2 {
    font-size: 2rem;
    margin-bottom: 1.5rem;
}

.contact-info p {
    margin-bottom: 2rem;
    line-height: 1.8;
}

.contact-details {
    margin-bottom: 2rem;
}

.contact-item {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 1.5rem;
}

.contact-item i {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: var(--primary-color);
    color: #fff;
    border-radius: 50%;
}

.contact-social {
    display: flex;
    gap: 15px;
}

.contact-social a {
    width: 45px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: var(--light-bg);
    color: var(--text-color);
    border-radius: 50%;
    transition: var(--transition);
}

.contact-social a:hover {
    background-color: var(--primary-color);
    color: #fff;
}

.contact-form-wrapper h2 {
    font-size: 2rem;
    margin-bottom: 1.5rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 12px 20px;
    border: 1px solid var(--border-color);
    border-radius: 5px;
    font-size: 1rem;
    font-family: var(--body-font);
    transition: var(--transition);
}

.form-group input:focus,
.form-group textarea:focus {
    outline: none;
    border-color: var(--primary-color);
}

.form-group textarea {
    min-height: 150px;
    resize: vertical;
}

.submit-btn {
    width: 100%;
    padding: 15px;
    background-color: var(--primary-color);
    color: #fff;
    border: none;
    border-radius: 30px;
    font-size: 1rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    cursor: pointer;
    transition: var(--transition);
}

.submit-btn:hover {
    background-color: #c89563;
    transform: translateY(-2px);
}

#contactMessage {
    margin-top: 1rem;
    padding: 15px;
    border-radius: 5px;
    display: none;
}

#contactMessage.success {
    display: block;
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

#contactMessage.error {
    display: block;
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

@media (max-width: 992px) {
    .contact-wrapper {
        grid-template-columns: 1fr;
    }
}
</style>

<!-- Contact Hero -->
<section class="contact-hero">
    <div class="container">
        <h1>Get In Touch</h1>
        <p>Have a question or want to collaborate? I'd love to hear from you!</p>
    </div>
</section>

<!-- Contact Content -->
<section class="contact-content">
    <div class="container">
        <div class="contact-wrapper">
            <!-- Contact Info -->
            <div class="contact-info">
                <h2>Let's Connect</h2>
                <p>Whether you have a question about my content, want to collaborate on a project, or just want to say hello, feel free to reach out. I typically respond within 24-48 hours.</p>
                
                <div class="contact-details">
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <div>
                            <strong>Email</strong><br>
                            sophia@lifestyleblogger.com
                        </div>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <strong>Location</strong><br>
                            San Francisco, CA
                        </div>
                    </div>
                </div>
                
                <!-- Google Map -->
                <div class="map-container" style="margin: 30px 0;">
                    <h3 style="margin-bottom: 15px;">Find Us</h3>
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.8354345093703!2d-122.41941492347107!3d37.77492971021411!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8085809c6c8f4459%3A0xb10ed6d9b5050fa5!2sSan%20Francisco%2C%20CA%2C%20USA!5e0!3m2!1sen!2s!4v1234567890123!5m2!1sen!2s" 
                        width="100%" 
                        height="300" 
                        style="border:0; border-radius: 10px;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Location Map">
                    </iframe>
                </div>
                
                <h3>Follow Me</h3>
                <div class="contact-social">
                    <a href="https://instagram.com/samiamaqsood_" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.linkedin.com/in/samia-maqsood-a30b6b358" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn"><i class="fab fa-linkedin"></i></a>
                    <a href="https://github.com/samiamaqsoood" target="_blank" rel="noopener noreferrer" aria-label="GitHub"><i class="fab fa-github"></i></a>
                    <a href="mailto:samiamaqsoood@email.com" aria-label="Email"><i class="fas fa-envelope"></i></a>
                </div>
            </div>
            
            <!-- Contact Form -->
            <div class="contact-form-wrapper">
                <h2>Send a Message</h2>
                <form id="contactForm" method="POST">
                    <div class="form-group">
                        <label for="name">Your Name *</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Your Email *</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="subject">Subject *</label>
                        <input type="text" id="subject" name="subject" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="message">Message *</label>
                        <textarea id="message" name="message" required maxlength="1500"></textarea>
                        <small style="color: var(--light-text);">
                            <span id="charCount">0</span>/250 words (Max 1500 characters)
                        </small>
                    </div>
                    
                    <button type="submit" class="submit-btn">Send Message</button>
                    
                    <div id="contactMessage"></div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
// Character/Word counter for message textarea
const messageTextarea = document.getElementById('message');
const charCountSpan = document.getElementById('charCount');

if (messageTextarea) {
    messageTextarea.addEventListener('input', function() {
        const text = this.value.trim();
        const words = text.split(/\s+/).filter(word => word.length > 0);
        const wordCount = words.length;
        
        charCountSpan.textContent = wordCount;
        
        // Limit to 250 words
        if (wordCount > 250) {
            const limitedWords = words.slice(0, 250).join(' ');
            this.value = limitedWords;
            charCountSpan.textContent = '250';
            charCountSpan.style.color = '#e74c3c';
        } else {
            charCountSpan.style.color = wordCount > 200 ? '#f39c12' : 'inherit';
        }
    });
}
</script>

<?php include 'includes/footer.php'; ?>