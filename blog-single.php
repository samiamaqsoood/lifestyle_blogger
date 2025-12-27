<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'track-view.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
    redirect(SITE_URL . '/login.php');
}

// Get post by slug
$slug = isset($_GET['slug']) ? sanitize_input($_GET['slug']) : '';

if (empty($slug)) {
    redirect(SITE_URL . '/blog.php');
}

$post = getPostBySlug($slug);

if (!$post) {
    redirect(SITE_URL . '/blog.php');
}

// Update view count
$post_id = $post['id'];
mysqli_query($conn, "UPDATE posts SET views = views + 1 WHERE id = $post_id");

// Track view for ML recommendations
trackPostView($post_id);

// Get related posts
$category_id = $post['category_id'];
$related_sql = "SELECT p.*, c.name as category_name, c.slug as category_slug 
                FROM posts p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.category_id = $category_id AND p.id != $post_id 
                ORDER BY RAND() 
                LIMIT 3";
$related_result = mysqli_query($conn, $related_sql);
$related_posts = mysqli_fetch_all($related_result, MYSQLI_ASSOC);

$page_title = $post['title'];

include 'includes/header.php';
?>

<style>
.post-header {
    padding: 60px 0 40px;
    background-color: var(--light-bg);
}

.post-category {
    display: inline-block;
    color: var(--primary-color);
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 1rem;
    font-weight: 600;
}

.post-title {
    font-size: 3rem;
    margin-bottom: 1.5rem;
    max-width: 900px;
    margin-left: auto;
    margin-right: auto;
}

.post-meta {
    display: flex;
    justify-content: center;
    gap: 30px;
    color: var(--light-text);
    font-size: 0.95rem;
}

.post-featured-image {
    width: 100%;
    max-width: 1000px;
    margin: 0 auto;
    border-radius: 10px;
    overflow: hidden;
    margin-bottom: 40px;
}

.post-featured-image img {
    width: 100%;
    height: auto;
}

.post-content-wrapper {
    padding: 40px 0 80px;
}

.post-content {
    max-width: 800px;
    margin: 0 auto;
    font-size: 1.1rem;
    line-height: 1.8;
}

.post-content p {
    margin-bottom: 1.5rem;
}

.post-content h2 {
    font-size: 2rem;
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.post-content h3 {
    font-size: 1.5rem;
    margin-top: 1.5rem;
    margin-bottom: 1rem;
}

.post-footer {
    max-width: 800px;
    margin: 0 auto;
    padding-top: 40px;
    border-top: 1px solid var(--border-color);
}

.share-post {
    text-align: center;
}

.share-post h4 {
    margin-bottom: 1rem;
}

.share-buttons {
    display: flex;
    justify-content: center;
    gap: 15px;
}

.share-btn {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    color: #fff;
    transition: var(--transition);
}

.share-btn:hover {
    transform: translateY(-3px);
}

.share-btn.facebook { background-color: #3b5998; }
.share-btn.twitter { background-color: #1da1f2; }
.share-btn.pinterest { background-color: #bd081c; }
.share-btn.linkedin { background-color: #0077b5; }

.related-posts {
    padding: 80px 0;
    background-color: var(--light-bg);
}

.related-posts h3 {
    font-size: 2rem;
    text-align: center;
    margin-bottom: 40px;
}

@media (max-width: 768px) {
    .post-title {
        font-size: 2rem;
    }
    
    .post-meta {
        flex-direction: column;
        gap: 10px;
    }
}
</style>

<!-- Post Header -->
<section class="post-header">
    <div class="container text-center">
        <a href="blog.php?category=<?php echo $post['category_slug']; ?>" class="post-category">
            <?php echo htmlspecialchars($post['category_name']); ?>
        </a>
        <h1 class="post-title"><?php echo htmlspecialchars($post['title']); ?></h1>
        <div class="post-meta">
            <span><i class="far fa-calendar"></i> <?php echo formatDate($post['created_at']); ?></span>
            <span><i class="far fa-user"></i> By <?php echo htmlspecialchars($post['author_name']); ?></span>
            <span><i class="far fa-eye"></i> <?php echo $post['views']; ?> views</span>
        </div>
    </div>
</section>

<!-- Post Content -->
<section class="post-content-wrapper">
    <div class="container">
        <div class="post-featured-image">
            <img src="<?php echo SITE_URL; ?>/assets/images/blog/<?php echo $post['image']; ?>" 
                 alt="<?php echo htmlspecialchars($post['title']); ?>">
        </div>
        
        <div class="post-content">
            <?php echo $post['content']; ?>
        </div>
        
        <div class="post-footer">
            <div class="share-post">
                <h4>Share This Post</h4>
                <div class="share-buttons">
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(SITE_URL . '/blog-single.php?slug=' . $post['slug']); ?>" 
                       target="_blank" class="share-btn facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(SITE_URL . '/blog-single.php?slug=' . $post['slug']); ?>&text=<?php echo urlencode($post['title']); ?>" 
                       target="_blank" class="share-btn twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="https://pinterest.com/pin/create/button/?url=<?php echo urlencode(SITE_URL . '/blog-single.php?slug=' . $post['slug']); ?>&description=<?php echo urlencode($post['title']); ?>" 
                       target="_blank" class="share-btn pinterest">
                        <i class="fab fa-pinterest-p"></i>
                    </a>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode(SITE_URL . '/blog-single.php?slug=' . $post['slug']); ?>" 
                       target="_blank" class="share-btn linkedin">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Posts -->
<?php if (!empty($related_posts)): ?>
<section class="related-posts">
    <div class="container">
        <h3>Related Posts</h3>
        <div class="blog-grid">
            <?php foreach ($related_posts as $related): ?>
            <div class="blog-card">
                <a href="<?php echo SITE_URL; ?>/blog-single.php?slug=<?php echo $related['slug']; ?>" class="blog-image">
                    <img src="<?php echo SITE_URL; ?>/assets/images/blog/<?php echo $related['image']; ?>" 
                         alt="<?php echo htmlspecialchars($related['title']); ?>">
                </a>
                <div class="blog-card-content">
                    <span class="blog-category"><?php echo htmlspecialchars($related['category_name']); ?></span>
                    <h3>
                        <a href="<?php echo SITE_URL; ?>/blog-single.php?slug=<?php echo $related['slug']; ?>">
                            <?php echo htmlspecialchars($related['title']); ?>
                        </a>
                    </h3>
                    <div class="blog-meta">
                        <span><?php echo formatDate($related['created_at']); ?></span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>