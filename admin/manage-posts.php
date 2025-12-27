<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

if (!isLoggedIn()) {
    redirect(SITE_URL . '/admin/index.php');
}

$success = '';
$error = '';

// Handle post deletion
if (isset($_GET['delete'])) {
    $post_id = (int)$_GET['delete'];
    
    // Get post image to delete
    $post = mysqli_fetch_assoc(mysqli_query($conn, "SELECT image FROM posts WHERE id = $post_id"));
    
    if (mysqli_query($conn, "DELETE FROM posts WHERE id = $post_id")) {
        // Delete image file if exists
        if ($post && $post['image']) {
            $image_path = '../assets/images/blog/' . $post['image'];
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }
        $success = 'Post deleted successfully!';
    } else {
        $error = 'Error deleting post.';
    }
}

// Get all posts
$posts = getAllPosts();

$page_title = 'Manage Posts';
include 'includes/admin-header.php';
?>

<?php if ($success): ?>
    <div class="alert alert-success"><?php echo $success; ?></div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
<?php endif; ?>

<div class="content-section">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>All Posts (<?php echo count($posts); ?>)</h2>
        <a href="add-post.php" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Post
        </a>
    </div>
    
    <?php if (empty($posts)): ?>
        <p style="text-align: center; padding: 40px; color: #7f8c8d;">
            No posts found. <a href="add-post.php">Create your first post</a>
        </p>
    <?php else: ?>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Views</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($posts as $post): ?>
                    <tr>
                        <td>
                            <img src="<?php echo SITE_URL; ?>/assets/images/blog/<?php echo $post['image']; ?>" 
                                 style="width: 60px; height: 60px; object-fit: cover; border-radius: 5px;">
                        </td>
                        <td>
                            <strong><?php echo htmlspecialchars($post['title']); ?></strong>
                        </td>
                        <td>
                            <span class="badge"><?php echo htmlspecialchars($post['category_name']); ?></span>
                        </td>
                        <td>
                            <?php if ($post['is_featured']): ?>
                                <span class="badge" style="background-color: #f39c12;">Featured</span>
                            <?php else: ?>
                                <span class="badge" style="background-color: #95a5a6;">Regular</span>
                            <?php endif; ?>
                        </td>
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
                            <a href="?delete=<?php echo $post['id']; ?>" 
                               class="btn-icon" 
                               title="Delete" 
                               onclick="return confirm('Are you sure you want to delete this post?');">
                                <i class="fas fa-trash" style="color: #e74c3c;"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/admin-footer.php'; ?>