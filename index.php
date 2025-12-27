<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'track-view.php';

$page_title = 'Home';
$featured_posts = getFeaturedPosts(3);
$latest_posts = getAllPosts(6);
$categories = getAllCategories();

// Get ML-based recommendations
if (isset($_SESSION['user_id'])) {
    $recommended_posts = getPersonalizedRecommendations($_SESSION['user_id'], 3);
} else {
    $recommended_posts = getTrendingPosts(3);
}

include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <div class="hero-content">
            <div class="hero-text">
                <p class="hero-subtitle">I'm Samiyah!</p>
                <h1 class="hero-title">Welcome to My Journey of Discovery and Growth</h1>
                <p class="hero-description">A marketing professional passionate about exploring the world, embracing technology, enhancing personal growth, and nurturing wellness.</p>
                <a href="#featured" class="btn btn-primary">Get Inspired</a>
            </div>
            <div class="hero-images">
                <div class="hero-image-grid">
                    <img src="<?php echo SITE_URL; ?>/assets/images/hero/hero-1.jpg" alt="Lifestyle image 1">
                    <img src="<?php echo SITE_URL; ?>/assets/images/hero/hero-2.jpg" alt="Lifestyle image 2">
                    <img src="<?php echo SITE_URL; ?>/assets/images/hero/hero-3.jpg" alt="Lifestyle image 3">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Social Stats Section -->
<section class="social-stats">
    <div class="container">
        <h2 class="section-title">Over 30K people in my Network</h2>
        <div class="stats-grid">
            <div class="stat-item">
                <i class="fab fa-instagram"></i>
                <h3>12K+</h3>
            </div>
            <div class="stat-item">
                <i class="fab fa-facebook"></i>
                <h3>08K+</h3>
            </div>
            <div class="stat-item">
                <i class="fab fa-twitter"></i>
                <h3>13K+</h3>
            </div>
            <div class="stat-item">
                <i class="fab fa-pinterest"></i>
                <h3>09K+</h3>
            </div>
        </div>
    </div>
</section>

<!-- Featured Blogs Section -->
<section class="featured-blogs" id="featured">
    <div class="container">
        <h2 class="section-title">My Featured Blogs</h2>
        <div class="featured-grid">
            <?php foreach ($featured_posts as $post): ?>
            <div class="featured-card">
                <a href="<?php echo SITE_URL; ?>/blog-single.php?slug=<?php echo $post['slug']; ?>">
                    <img src="<?php echo SITE_URL; ?>/assets/images/blog/<?php echo $post['image']; ?>" alt="<?php echo htmlspecialchars($post['title']); ?>">
                </a>
                <div class="featured-card-content">
                    <h3><a href="<?php echo SITE_URL; ?>/blog-single.php?slug=<?php echo $post['slug']; ?>"><?php echo htmlspecialchars($post['title']); ?></a></h3>
                    <a href="<?php echo SITE_URL; ?>/blog-single.php?slug=<?php echo $post['slug']; ?>" class="btn btn-secondary">Read More</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="categories-section">
    <div class="container">
        <h2 class="section-title">Explore My Passions</h2>
        <div class="categories-grid">
            <?php foreach ($categories as $category): ?>
            <div class="category-card">
                <h3><?php echo htmlspecialchars($category['name']); ?></h3>
                <p><?php echo htmlspecialchars($category['description']); ?></p>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center">
            <a href="<?php echo SITE_URL; ?>/blog.php" class="btn btn-primary">View All Blogs</a>
        </div>
    </div>
</section>

<!-- Latest Blogs Section -->
<section class="latest-blogs">
    <div class="container">
        <h2 class="section-title">Latest Blogs</h2>
        <div class="blog-grid">
            <?php foreach ($latest_posts as $post): ?>
            <div class="blog-card">
                <a href="<?php echo SITE_URL; ?>/blog-single.php?slug=<?php echo $post['slug']; ?>" class="blog-image">
                    <img src="<?php echo SITE_URL; ?>/assets/images/blog/<?php echo $post['image']; ?>" alt="<?php echo htmlspecialchars($post['title']); ?>">
                </a>
                <div class="blog-card-content">
                    <span class="blog-category"><?php echo htmlspecialchars($post['category_name']); ?></span>
                    <h3><a href="<?php echo SITE_URL; ?>/blog-single.php?slug=<?php echo $post['slug']; ?>"><?php echo htmlspecialchars($post['title']); ?></a></h3>
                    <div class="blog-meta">
                        <span><?php echo formatDate($post['created_at']); ?></span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center">
            <a href="<?php echo SITE_URL; ?>/blog.php" class="btn btn-primary">All Blogs</a>
        </div>
    </div>
</section>

<!-- Testimonial Section -->
<section class="testimonial-section">
    <div class="container">
        <div class="testimonial-content">
            <h2 class="section-title">What Readers Say</h2>
            <blockquote class="testimonial">
                <p>"Sophia's blog is a treasure trove of inspiration and insight. Her travel stories transport you to new worlds, while her tech tips and wellness advice have genuinely improved my daily routine. I always look forward to her latest posts. It's like getting a dose of motivation straight to my inbox!"</p>
                <cite>- Emily Thompson</cite>
            </blockquote>
        </div>
    </div>
</section>

<!-- About Preview Section -->
<section class="about-preview">
    <div class="container">
        <div class="about-preview-content">
            <div class="about-image">
                <img src="<?php echo SITE_URL; ?>/assets/images/about.jpg" alt="Sophia Ellis">
            </div>
            <div class="about-text">
                <h2>hi!</h2>
                <p>I'm Sophia Ellis—a marketing professional passionate about exploring the world, embracing technology, enhancing personal growth, and nurturing wellness. Here, I share my adventures, insights, and tips to inspire and empower you.</p>
                <p>Technology is another realm I'm deeply fascinated by. I enjoy diving into the latest innovations and understanding how they shape our lives and industries.</p>
                <p>This blog is more than just a collection of thoughts—it's a community. Whether you're here for travel tips, tech knowledge, or wellness advice, you'll find a space that welcomes curiosity and encourages growth.</p>
                <a href="<?php echo SITE_URL; ?>/about.php" class="btn btn-primary">More About Me</a>
            </div>
        </div>
    </div>
</section>

<!-- ML-Based Recommendations Section -->
<section class="recommended-blogs">
    <div class="container">
        <h2 class="section-title">
            <?php echo isset($_SESSION['user_id']) ? 'Recommended For You' : 'Trending Now'; ?>
        </h2>
        <p style="text-align: center; color: var(--light-text); margin-bottom: 40px;">
            <?php echo isset($_SESSION['user_id']) ? 
                'Based on your reading history and interests' : 
                'Most popular articles this week'; ?>
        </p>
        <div class="blog-grid">
            <?php foreach ($recommended_posts as $post): ?>
            <div class="blog-card">
                <a href="<?php echo isset($_SESSION['user_id']) ? SITE_URL . '/blog-single.php?slug=' . $post['slug'] : SITE_URL . '/login.php'; ?>" 
                   class="blog-image">
                    <img src="<?php echo SITE_URL; ?>/assets/images/blog/<?php echo $post['image']; ?>" 
                         alt="<?php echo htmlspecialchars($post['title']); ?>">
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <div style="position: absolute; top: 10px; right: 10px; background: var(--primary-color); color: #fff; padding: 5px 10px; border-radius: 5px; font-size: 0.85rem;">
                            <i class="fas fa-fire"></i> Trending
                        </div>
                    <?php endif; ?>
                </a>
                <div class="blog-card-content">
                    <span class="blog-category"><?php echo htmlspecialchars($post['category_name']); ?></span>
                    <h3>
                        <a href="<?php echo isset($_SESSION['user_id']) ? SITE_URL . '/blog-single.php?slug=' . $post['slug'] : 'javascript:void(0)'; ?>"
                           <?php if (!isset($_SESSION['user_id'])): ?>
                           onclick="alert('Please login to read full articles'); return false;"
                           <?php endif; ?>>
                            <?php echo htmlspecialchars($post['title']); ?>
                        </a>
                    </h3>
                    <div class="blog-meta">
                        <span><?php echo formatDate($post['created_at']); ?></span>
                    </div>
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <div style="margin-top: 10px;">
                            <a href="<?php echo SITE_URL; ?>/login.php" class="btn btn-primary" style="font-size: 0.9rem; padding: 8px 20px;">
                                Login to Read
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="newsletter-section">
    <div class="container">
        <div class="newsletter-content">
            <h2 class="section-title">Let's learn, explore, and thrive together!</h2>
            <p>Connect with 4000+ like-minded individuals and be part of a community that values growth, curiosity, and empowerment.</p>
            <form id="newsletterForm" method="POST" class="newsletter-form">
                <input type="email" name="email" placeholder="Add your e-mail" required>
                <button type="submit" class="btn btn-primary">Subscribe</button>
            </form>
            <div id="newsletterMessage"></div>
        </div>
    </div>
</section>

<!-- Ad Popup Modal -->
<div class="ad-popup-modal" id="adPopupModal">
    <div class="ad-popup-content">
        <span class="ad-close-btn">&times;</span>
        <div class="ad-content">
            <h3>Special Offer!</h3>
            <p>Get 20% off on our premium subscription</p>
            <a href="<?php echo SITE_URL; ?>/blog.php" class="btn btn-primary">Explore Now</a>
        </div>
    </div>
</div>

<!-- Test: Uncomment below to reset popup (for testing only) -->
<!-- <script>localStorage.removeItem('adPopupClosed'); console.log('Ad popup reset - refresh page to see it');</script> -->

<?php include 'includes/footer.php'; ?>