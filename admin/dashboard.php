<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

// Check if user is logged in
if (!isLoggedIn()) {
    redirect(SITE_URL . '/admin/index.php');
}

// Get statistics
$total_posts = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM posts"))['count'];
$total_categories = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM categories"))['count'];
$total_subscribers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM subscribers"))['count'];
$total_views = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(views) as total FROM posts"))['total'] ?? 0;

// Get recent posts
$recent_posts = mysqli_fetch_all(
    mysqli_query($conn, "SELECT p.*, c.name as category_name FROM posts p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.created_at DESC LIMIT 5"),
    MYSQLI_ASSOC
);

$page_title = 'Dashboard';
include 'includes/admin-header.php';
?>

<div class="dashboard-stats">
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-file-alt"></i></div>
        <div class="stat-info">
            <h3><?php echo $total_posts; ?></h3>
            <p>Total Posts</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-folder"></i></div>
        <div class="stat-info">
            <h3><?php echo $total_categories; ?></h3>
            <p>Categories</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-users"></i></div>
        <div class="stat-info">
            <h3><?php echo $total_subscribers; ?></h3>
            <p>Subscribers</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-eye"></i></div>
        <div class="stat-info">
            <h3><?php echo number_format($total_views); ?></h3>
            <p>Total Views</p>
        </div>
    </div>
</div>

<div class="dashboard-content">
    <div class="content-section">
        <h2>Recent Posts</h2>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Views</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recent_posts as $post): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($post['title']); ?></td>
                        <td><span class="badge"><?php echo htmlspecialchars($post['category_name']); ?></span></td>
                        <td><?php echo $post['views']; ?></td>
                        <td><?php echo formatDate($post['created_at']); ?></td>
                        <td>
                            <a href="add-post.php?id=<?php echo $post['id']; ?>" class="btn-icon" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="<?php echo SITE_URL; ?>/blog-single.php?slug=<?php echo $post['slug']; ?>" 
                               class="btn-icon" title="View" target="_blank">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <a href="manage-posts.php" class="btn btn-primary" style="margin-top: 20px;">View All Posts</a>
    </div>
</div>

<?php include 'includes/admin-footer.php'; ?>