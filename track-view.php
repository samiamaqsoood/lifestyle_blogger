<?php
require_once 'includes/config.php';

// Function to track post view
function trackPostView($post_id) {
    global $conn;
    
    $user_id = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 'NULL';
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $post_id = (int)$post_id;
    
    // Check if this user/IP has viewed this post in the last hour (prevent duplicate counts)
    $check_sql = "SELECT id FROM page_views 
                  WHERE post_id = $post_id 
                  AND ip_address = '$ip_address' 
                  AND viewed_at > DATE_SUB(NOW(), INTERVAL 1 HOUR)";
    
    $result = mysqli_query($conn, $check_sql);
    
    if (mysqli_num_rows($result) == 0) {
        // Insert new view
        $insert_sql = "INSERT INTO page_views (post_id, user_id, ip_address) 
                      VALUES ($post_id, $user_id, '$ip_address')";
        mysqli_query($conn, $insert_sql);
    }
}

// Function to get most viewed posts (Simple ML: popularity-based recommendation)
function getMostViewedPosts($limit = 5, $days = 7) {
    global $conn;
    
    $sql = "SELECT p.*, c.name as category_name, c.slug as category_slug, 
            COUNT(pv.id) as view_count,
            u.username as author_name
            FROM posts p
            LEFT JOIN categories c ON p.category_id = c.id
            LEFT JOIN users u ON p.author_id = u.id
            LEFT JOIN page_views pv ON p.id = pv.post_id 
            WHERE pv.viewed_at > DATE_SUB(NOW(), INTERVAL $days DAY)
            GROUP BY p.id
            ORDER BY view_count DESC, p.created_at DESC
            LIMIT $limit";
    
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Function to get trending posts (weighted by recency and views)
function getTrendingPosts($limit = 5) {
    global $conn;
    
    // Calculate trending score: (views in last 7 days * 2) + (views in last 30 days)
    $sql = "SELECT p.*, c.name as category_name, c.slug as category_slug,
            u.username as author_name,
            (SELECT COUNT(*) FROM page_views pv1 
             WHERE pv1.post_id = p.id 
             AND pv1.viewed_at > DATE_SUB(NOW(), INTERVAL 7 DAY)) * 2 +
            (SELECT COUNT(*) FROM page_views pv2 
             WHERE pv2.post_id = p.id 
             AND pv2.viewed_at > DATE_SUB(NOW(), INTERVAL 30 DAY)) as trending_score
            FROM posts p
            LEFT JOIN categories c ON p.category_id = c.id
            LEFT JOIN users u ON p.author_id = u.id
            ORDER BY trending_score DESC, p.created_at DESC
            LIMIT $limit";
    
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Function to get personalized recommendations based on user's reading history
function getPersonalizedRecommendations($user_id, $limit = 5) {
    global $conn;
    
    $user_id = (int)$user_id;
    
    // Get categories user has viewed
    $sql = "SELECT DISTINCT p.category_id
            FROM page_views pv
            JOIN posts p ON pv.post_id = p.id
            WHERE pv.user_id = $user_id
            AND pv.viewed_at > DATE_SUB(NOW(), INTERVAL 30 DAY)
            ORDER BY pv.viewed_at DESC
            LIMIT 3";
    
    $result = mysqli_query($conn, $sql);
    $user_categories = [];
    
    while ($row = mysqli_fetch_assoc($result)) {
        $user_categories[] = $row['category_id'];
    }
    
    if (empty($user_categories)) {
        // If no history, return trending posts
        return getTrendingPosts($limit);
    }
    
    $category_list = implode(',', $user_categories);
    
    // Get posts from categories user has shown interest in, excluding already viewed
    $rec_sql = "SELECT DISTINCT p.*, c.name as category_name, c.slug as category_slug,
                u.username as author_name,
                (SELECT COUNT(*) FROM page_views pv 
                 WHERE pv.post_id = p.id 
                 AND pv.viewed_at > DATE_SUB(NOW(), INTERVAL 30 DAY)) as popularity_score
                FROM posts p
                LEFT JOIN categories c ON p.category_id = c.id
                LEFT JOIN users u ON p.author_id = u.id
                WHERE p.category_id IN ($category_list)
                AND p.id NOT IN (
                    SELECT post_id FROM page_views 
                    WHERE user_id = $user_id 
                    AND viewed_at > DATE_SUB(NOW(), INTERVAL 7 DAY)
                )
                ORDER BY popularity_score DESC, p.created_at DESC
                LIMIT $limit";
    
    $result = mysqli_query($conn, $rec_sql);
    $recommendations = mysqli_fetch_all($result, MYSQLI_ASSOC);
    
    // If not enough recommendations, fill with trending posts
    if (count($recommendations) < $limit) {
        $trending = getTrendingPosts($limit - count($recommendations));
        $recommendations = array_merge($recommendations, $trending);
    }
    
    return $recommendations;
}
?>