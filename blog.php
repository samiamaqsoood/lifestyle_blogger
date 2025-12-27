<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

$page_title = 'Blog';

// Pagination
$posts_per_page = 9;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $posts_per_page;

// Filter by category
$category_filter = isset($_GET['category']) ? sanitize_input($_GET['category']) : '';

// Search
$search_query = isset($_GET['search']) ? sanitize_input($_GET['search']) : '';

// Build query
$where_clauses = [];
if ($category_filter) {
    $where_clauses[] = "c.slug = '$category_filter'";
}
if ($search_query) {
    $where_clauses[] = "(p.title LIKE '%$search_query%' OR p.excerpt LIKE '%$search_query%' OR p.content LIKE '%$search_query%')";
}

$where_sql = !empty($where_clauses) ? 'WHERE ' . implode(' AND ', $where_clauses) : '';

// Get total posts
$count_sql = "SELECT COUNT(*) as total FROM posts p LEFT JOIN categories c ON p.category_id = c.id $where_sql";
$count_result = mysqli_query($conn, $count_sql);
$total_posts = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_posts / $posts_per_page);

// Get posts
$sql = "SELECT p.*, c.name as category_name, c.slug as category_slug, u.username as author_name 
        FROM posts p 
        LEFT JOIN categories c ON p.category_id = c.id 
        LEFT JOIN users u ON p.author_id = u.id 
        $where_sql
        ORDER BY p.created_at DESC 
        LIMIT $posts_per_page OFFSET $offset";

$result = mysqli_query($conn, $sql);
$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

$categories = getAllCategories();

include 'includes/header.php';
?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <h1>Blog</h1>
        <p>Explore articles on marketing, travel, technology, and wellness</p>
    </div>
</section>

<!-- Blog Filter Section -->
<section class="blog-filter">
    <div class="container">
        <div class="filter-wrapper">
            <!-- Search Form -->
            <form method="GET" class="search-form">
                <input type="text" name="search" placeholder="Search articles..." value="<?php echo htmlspecialchars($search_query); ?>">
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
            
            <!-- Category Filter -->
            <div class="category-filter">
                <a href="blog.php" class="filter-btn <?php echo !$category_filter ? 'active' : ''; ?>">All</a>
                <?php foreach ($categories as $category): ?>
                    <a href="blog.php?category=<?php echo $category['slug']; ?>" 
                       class="filter-btn <?php echo $category_filter == $category['slug'] ? 'active' : ''; ?>">
                        <?php echo htmlspecialchars($category['name']); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- Blog Grid Section -->
<section class="blog-listing">
    <div class="container">
        <?php if (empty($posts)): ?>
            <div class="no-posts">
                <h3>No posts found</h3>
                <p>Try adjusting your search or filter criteria.</p>
            </div>
        <?php else: ?>
            <div class="blog-grid">
                <?php foreach ($posts as $post): ?>
                <div class="blog-card">
                    <a href="<?php echo SITE_URL; ?>/blog-single.php?slug=<?php echo $post['slug']; ?>" class="blog-image">
                        <img src="<?php echo SITE_URL; ?>/assets/images/blog/<?php echo $post['image']; ?>" 
                             alt="<?php echo htmlspecialchars($post['title']); ?>">
                    </a>
                    <div class="blog-card-content">
                        <a href="blog.php?category=<?php echo $post['category_slug']; ?>" class="blog-category">
                            <?php echo htmlspecialchars($post['category_name']); ?>
                        </a>
                        <h3>
                            <a href="<?php echo SITE_URL; ?>/blog-single.php?slug=<?php echo $post['slug']; ?>">
                                <?php echo htmlspecialchars($post['title']); ?>
                            </a>
                        </h3>
                        <p class="blog-excerpt">
                            <?php echo truncateText(strip_tags($post['excerpt']), 100); ?>
                        </p>
                        <div class="blog-meta">
                            <span><i class="far fa-calendar"></i> <?php echo formatDate($post['created_at']); ?></span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="?page=<?php echo $page - 1; ?><?php echo $category_filter ? '&category=' . $category_filter : ''; ?><?php echo $search_query ? '&search=' . urlencode($search_query) : ''; ?>" 
                       class="page-btn">
                        <i class="fas fa-chevron-left"></i> Previous
                    </a>
                <?php endif; ?>
                
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="?page=<?php echo $i; ?><?php echo $category_filter ? '&category=' . $category_filter : ''; ?><?php echo $search_query ? '&search=' . urlencode($search_query) : ''; ?>" 
                       class="page-btn <?php echo $i == $page ? 'active' : ''; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>
                
                <?php if ($page < $total_pages): ?>
                    <a href="?page=<?php echo $page + 1; ?><?php echo $category_filter ? '&category=' . $category_filter : ''; ?><?php echo $search_query ? '&search=' . urlencode($search_query) : ''; ?>" 
                       class="page-btn">
                        Next <i class="fas fa-chevron-right"></i>
                    </a>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>

<style>
.page-header {
    padding: 60px 0;
    background-color: var(--light-bg);
    text-align: center;
}

.page-header h1 {
    font-size: 3rem;
    margin-bottom: 1rem;
}

.blog-filter {
    padding: 40px 0;
    background-color: #fff;
    border-bottom: 1px solid var(--border-color);
}

.filter-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 30px;
    flex-wrap: wrap;
}

.search-form {
    display: flex;
    gap: 10px;
    flex: 1;
    max-width: 400px;
}

.search-form input {
    flex: 1;
    padding: 10px 20px;
    border: 1px solid var(--border-color);
    border-radius: 25px;
    font-size: 0.95rem;
}

.search-form button {
    padding: 10px 20px;
    background-color: var(--primary-color);
    color: #fff;
    border: none;
    border-radius: 25px;
    cursor: pointer;
}

.category-filter {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.filter-btn {
    padding: 8px 20px;
    background-color: var(--light-bg);
    color: var(--text-color);
    border-radius: 20px;
    font-size: 0.9rem;
    transition: var(--transition);
}

.filter-btn:hover,
.filter-btn.active {
    background-color: var(--primary-color);
    color: #fff;
}

.blog-listing {
    padding: 60px 0;
}

.blog-excerpt {
    color: var(--light-text);
    margin-bottom: 1rem;
}

.no-posts {
    text-align: center;
    padding: 60px 20px;
}

.pagination {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 40px;
}

.page-btn {
    padding: 10px 20px;
    background-color: var(--light-bg);
    color: var(--text-color);
    border-radius: 5px;
    transition: var(--transition);
}

.page-btn:hover,
.page-btn.active {
    background-color: var(--primary-color);
    color: #fff;
}

@media (max-width: 768px) {
    .filter-wrapper {
        flex-direction: column;
        align-items: stretch;
    }
    
    .search-form {
        max-width: 100%;
    }
}
</style>

<?php include 'includes/footer.php'; ?>