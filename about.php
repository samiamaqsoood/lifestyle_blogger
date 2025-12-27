<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

$page_title = 'About Me';

include 'includes/header.php';
?>

<style>
.about-hero {
    padding: 80px 0;
    background-color: var(--light-bg);
}

.about-hero-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    align-items: center;
}

.about-hero-image img {
    width: 100%;
    border-radius: 10px;
}

.about-hero-text h1 {
    font-size: 3.5rem;
    margin-bottom: 1.5rem;
}

.about-mission {
    padding: 80px 0;
    background-color: #fff;
}

.mission-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 40px;
    margin-top: 40px;
}

.mission-card {
    padding: 40px;
    background-color: var(--light-bg);
    border-radius: 10px;
}

.mission-card h3 {
    font-size: 1.8rem;
    margin-bottom: 1rem;
    color: var(--primary-color);
}

.about-values {
    padding: 80px 0;
    background-color: var(--light-bg);
    text-align: center;
}

.values-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 30px;
    margin-top: 40px;
}

.value-item {
    padding: 30px 20px;
}

.value-item i {
    font-size: 3rem;
    color: var(--primary-color);
    margin-bottom: 1rem;
}

.value-item h4 {
    font-size: 1.3rem;
    margin-bottom: 0.5rem;
}

.about-cta {
    padding: 80px 0;
    background-color: var(--secondary-color);
    color: #fff;
    text-align: center;
}

.about-cta h2 {
    font-size: 2.5rem;
    color: #fff;
    margin-bottom: 1rem;
}

.about-cta p {
    font-size: 1.2rem;
    margin-bottom: 2rem;
    color: rgba(255,255,255,0.9);
}

.social-links {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-top: 2rem;
}

.social-links a {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background-color: rgba(255,255,255,0.1);
    color: #fff;
    font-size: 1.3rem;
    transition: var(--transition);
}

.social-links a:hover {
    background-color: var(--primary-color);
    transform: translateY(-5px);
}

@media (max-width: 992px) {
    .about-hero-content {
        grid-template-columns: 1fr;
    }
    
    .mission-grid {
        grid-template-columns: 1fr;
    }
    
    .values-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .about-hero-text h1 {
        font-size: 2.5rem;
    }
    
    .values-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<!-- About Hero -->
<section class="about-hero">
    <div class="container">
        <div class="about-hero-content">
            <div class="about-hero-image">
                <img src="<?php echo SITE_URL; ?>/assets/images/about.jpg" alt="Sophia Ellis">
            </div>
            <div class="about-hero-text">
                <h1>Hi! I'm Sophia Ellis</h1>
                <p>I'm a marketing professional passionate about exploring the world, embracing technology, enhancing personal growth, and nurturing wellness.</p>
                <p>Here, I share my adventures, insights, and tips to inspire and empower you. Whether you're seeking travel inspiration, tech updates, self-improvement strategies, or wellness advice, you're in the right place.</p>
                <p>My journey began with a curiosity about the world and a desire to connect with others who share similar passions. Over the years, I've traveled to dozens of countries, worked with innovative tech companies, and developed a holistic approach to wellness that balances mind, body, and spirit.</p>
            </div>
        </div>
    </div>
</section>

<!-- Mission Section -->
<section class="about-mission">
    <div class="container">
        <h2 class="section-title">My Mission & Approach</h2>
        <div class="mission-grid">
            <div class="mission-card">
                <h3>My Mission</h3>
                <p>To inspire and empower individuals to live their best lives through thoughtful exploration of marketing, travel, technology, and wellness. I believe that by sharing knowledge and experiences, we can all grow together and create a more connected, informed world.</p>
            </div>
            <div class="mission-card">
                <h3>My Approach</h3>
                <p>I combine personal experience with research and expert insights to create content that's both relatable and informative. Every article is crafted with care, aiming to provide value while maintaining authenticity and honesty.</p>
            </div>
        </div>
    </div>
</section>

<!-- Values Section -->
<section class="about-values">
    <div class="container">
        <h2 class="section-title">What Drives Me</h2>
        <div class="values-grid">
            <div class="value-item">
                <i class="fas fa-compass"></i>
                <h4>Exploration</h4>
                <p>Discovering new places, ideas, and perspectives</p>
            </div>
            <div class="value-item">
                <i class="fas fa-lightbulb"></i>
                <h4>Innovation</h4>
                <p>Embracing new technologies and creative solutions</p>
            </div>
            <div class="value-item">
                <i class="fas fa-heart"></i>
                <h4>Wellness</h4>
                <p>Prioritizing mental and physical health</p>
            </div>
            <div class="value-item">
                <i class="fas fa-users"></i>
                <h4>Community</h4>
                <p>Building meaningful connections and relationships</p>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="about-cta">
    <div class="container">
        <h2>Let's Connect!</h2>
        <p>Join me on this journey and be part of a community that values growth, curiosity, and empowerment.</p>
        <a href="<?php echo SITE_URL; ?>/contact.php" class="btn btn-primary">Get In Touch</a>
        
        <div class="social-links">
            <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
            <a href="#" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
            <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
            <a href="#" aria-label="Pinterest"><i class="fab fa-pinterest"></i></a>
            <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin"></i></a>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>