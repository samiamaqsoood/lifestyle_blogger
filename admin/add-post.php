<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

if (!isLoggedIn()) {
    redirect(SITE_URL . '/admin/index.php');
}

$edit_mode = false;
$post = null;
$success = '';
$error = '';

// Check if editing
if (isset($_GET['id'])) {
    $edit_mode = true;
    $post_id = (int)$_GET['id'];
    $post = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM posts WHERE id = $post_id"));
    
    if (!$post) {
        redirect(SITE_URL . '/admin/manage-posts.php');
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = sanitize_input($_POST['title']);
    $content = $_POST['content']; // Don't sanitize HTML content
    $excerpt = sanitize_input($_POST['excerpt']);
    $category_id = (int)$_POST['category_id'];
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $slug = generateSlug($title);
    
    // Handle image upload
    $image = $edit_mode ? $post['image'] : '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['image']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if (in_array($ext, $allowed)) {
            $new_filename = uniqid() . '.' . $ext;
            $upload_path = '../assets/images/blog/' . $new_filename;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                $image = $new_filename;
            }
        }
    }
    
    if ($edit_mode) {
        // Update post
        $sql = "UPDATE posts SET 
                title = '$title',
                slug = '$slug',
                content = '$content',
                excerpt = '$excerpt',
                category_id = $category_id,
                is_featured = $is_featured,
                image = '$image'
                WHERE id = $post_id";
        
        if (mysqli_query($conn, $sql)) {
            $success = 'Post updated successfully!';
            $post = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM posts WHERE id = $post_id"));
        } else {
            $error = 'Error updating post.';
        }
    } else {
        // Insert new post
        $sql = "INSERT INTO posts (title, slug, content, excerpt, category_id, is_featured, image, author_id) 
                VALUES ('$title', '$slug', '$content', '$excerpt', $category_id, $is_featured, '$image', {$_SESSION['admin_id']})";
        
        if (mysqli_query($conn, $sql)) {
            $success = 'Post created successfully!';
            $post_id = mysqli_insert_id($conn);
            redirect(SITE_URL . '/admin/add-post.php?id=' . $post_id);
        } else {
            $error = 'Error creating post.';
        }
    }
}

$categories = getAllCategories();
$page_title = $edit_mode ? 'Edit Post' : 'Add New Post';
include 'includes/admin-header.php';
?>

<?php if ($success): ?>
    <div class="alert alert-success"><?php echo $success; ?></div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
<?php endif; ?>

<div class="content-section">
    <h2><?php echo $edit_mode ? 'Edit Post' : 'Add New Post'; ?></h2>
    
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Title *</label>
            <input type="text" id="title" name="title" required 
                   value="<?php echo $edit_mode ? htmlspecialchars($post['title']) : ''; ?>">
        </div>
        
        <div class="form-group">
            <label for="excerpt">Excerpt *</label>
            <textarea id="excerpt" name="excerpt" rows="3" required><?php echo $edit_mode ? htmlspecialchars($post['excerpt']) : ''; ?></textarea>
        </div>
        
        <div class="form-group">
            <label for="content">Content *</label>
            <textarea id="content" name="content" required><?php echo $edit_mode ? htmlspecialchars($post['content']) : ''; ?></textarea>
            <small>You can use HTML tags for formatting.</small>
        </div>
        
        <div class="form-group">
            <label for="category_id">Category *</label>
            <select id="category_id" name="category_id" required>
                <option value="">Select Category</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category['id']; ?>" 
                            <?php echo ($edit_mode && $post['category_id'] == $category['id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($category['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="image">Featured Image <?php echo $edit_mode ? '' : '*'; ?></label>
            <input type="file" id="image" name="image" accept="image/*" <?php echo $edit_mode ? '' : 'required'; ?>>
            <?php if ($edit_mode && $post['image']): ?>
                <p style="margin-top: 10px;">
                    Current image: <strong><?php echo $post['image']; ?></strong><br>
                    <img src="<?php echo SITE_URL; ?>/assets/images/blog/<?php echo $post['image']; ?>" 
                         style="max-width: 300px; margin-top: 10px; border-radius: 5px;">
                </p>
            <?php endif; ?>
        </div>
        
        <div class="form-group">
            <label>
                <input type="checkbox" name="is_featured" value="1" 
                       <?php echo ($edit_mode && $post['is_featured']) ? 'checked' : ''; ?>>
                Mark as Featured Post
            </label>
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn btn-primary">
                <?php echo $edit_mode ? 'Update Post' : 'Create Post'; ?>
            </button>
            <a href="manage-posts.php" class="btn" style="background-color: #95a5a6; margin-left: 10px;">Cancel</a>
        </div>
    </form>
</div>

<?php include 'includes/admin-footer.php'; ?>