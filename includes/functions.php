<?php
// Helper functions

// Sanitize input
function sanitize_input($data) {
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = mysqli_real_escape_string($conn, $data);
    return $data;
}

// Generate slug from title
function generateSlug($string) {
    $string = strtolower($string);
    $string = preg_replace('/[^a-z0-9-]/', '-', $string);
    $string = preg_replace('/-+/', '-', $string);
    $string = trim($string, '-');
    return $string;
}

// Get all posts
function getAllPosts($limit = null) {
    global $conn;
    $sql = "SELECT p.*, c.name as category_name, c.slug as category_slug, u.username as author_name 
            FROM posts p 
            LEFT JOIN categories c ON p.category_id = c.id 
            LEFT JOIN users u ON p.author_id = u.id 
            ORDER BY p.created_at DESC";
    
    if ($limit) {
        $sql .= " LIMIT $limit";
    }
    
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Get featured posts
function getFeaturedPosts($limit = 3) {
    global $conn;
    $sql = "SELECT p.*, c.name as category_name, c.slug as category_slug 
            FROM posts p 
            LEFT JOIN categories c ON p.category_id = c.id 
            WHERE p.is_featured = 1 
            ORDER BY p.created_at DESC 
            LIMIT $limit";
    
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Get post by slug
function getPostBySlug($slug) {
    global $conn;
    $slug = sanitize_input($slug);
    $sql = "SELECT p.*, c.name as category_name, c.slug as category_slug, u.username as author_name 
            FROM posts p 
            LEFT JOIN categories c ON p.category_id = c.id 
            LEFT JOIN users u ON p.author_id = u.id 
            WHERE p.slug = '$slug'";
    
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

// Get posts by category
function getPostsByCategory($category_slug, $limit = null) {
    global $conn;
    $category_slug = sanitize_input($category_slug);
    $sql = "SELECT p.*, c.name as category_name, c.slug as category_slug 
            FROM posts p 
            LEFT JOIN categories c ON p.category_id = c.id 
            WHERE c.slug = '$category_slug' 
            ORDER BY p.created_at DESC";
    
    if ($limit) {
        $sql .= " LIMIT $limit";
    }
    
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Get all categories
function getAllCategories() {
    global $conn;
    $sql = "SELECT * FROM categories ORDER BY name ASC";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Format date
function formatDate($date) {
    return date('F j, Y', strtotime($date));
}

// Truncate text
function truncateText($text, $length = 150) {
    if (strlen($text) > $length) {
        return substr($text, 0, $length) . '...';
    }
    return $text;
}

// Check if user is logged in (admin)
function isLoggedIn() {
    return isset($_SESSION['admin_id']) && $_SESSION['admin_id'] > 0;
}

// Redirect function
function redirect($url) {
    header("Location: $url");
    exit();
}
?>