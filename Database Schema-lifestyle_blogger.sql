-- Database: lifestyle_blogger
-- Create database
CREATE DATABASE IF NOT EXISTS lifestyle_blogger;
USE lifestyle_blogger;

-- Users table (for admin)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Categories table
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) UNIQUE NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Posts table
CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    content TEXT NOT NULL,
    excerpt TEXT,
    image VARCHAR(255),
    category_id INT,
    author_id INT DEFAULT 1,
    is_featured TINYINT(1) DEFAULT 0,
    views INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Subscribers table
CREATE TABLE subscribers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) UNIQUE NOT NULL,
    subscribed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default admin user (password: admin123)
INSERT INTO users (username, password, email) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@lifestyleblogger.com');

-- Insert default categories
INSERT INTO categories (name, slug, description) VALUES 
('Marketing', 'marketing', 'Elevate your skills with expert strategies and industry secrets.'),
('Travel', 'travel', 'Uncover hidden gems and travel tips for your next adventure.'),
('Technology', 'technology', 'Stay ahead with the latest tech trends and insights.'),
('Wellness', 'wellness', 'Embrace health and balance in your everyday life.');

-- Insert sample posts
INSERT INTO posts (title, slug, content, excerpt, image, category_id, is_featured) VALUES 
('The Future of Wearable Tech: Innovations Shaping Our Lives', 
'future-of-wearable-tech', 
'<p>Wearable technology has evolved from simple fitness trackers to sophisticated devices that monitor our health, enhance our productivity, and seamlessly integrate with our daily lives...</p><p>From smartwatches to AR glasses, these innovations are transforming how we interact with the world around us.</p>', 
'Discover how wearable technology is revolutionizing our daily lives and what the future holds for smart devices.', 
'post-01.jpg', 
3, 
1),
('Unplugged Adventures: How Digital Detoxing Transformed My Travels', 
'unplugged-adventures-digital-detox', 
'<p>In our hyper-connected world, the concept of disconnecting can seem foreign, even frightening. But what if unplugging could actually enhance your travel experiences?</p><p>My journey into digital detoxing began unexpectedly during a trip to the mountains...</p>', 
'Learn how stepping away from digital devices enhanced my travel experiences and brought me closer to authentic moments.', 
'post-02.jpg', 
2, 
1),
('From Burnout to Balance: My Journey to Wellness and Productivity', 
'burnout-to-balance-wellness-journey', 
'<p>Burnout is real, and it affected me deeply. As someone who prided themselves on being productive and efficient, hitting a wall was both shocking and eye-opening.</p><p>This is the story of how I transformed my approach to work and life...</p>', 
'Discover practical strategies that helped me overcome burnout and achieve a healthier work-life balance.', 
'post-03.jpg', 
4, 
1);