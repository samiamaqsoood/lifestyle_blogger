# Lifestyle Blogger Website - University Project

A full-stack lifestyle blog website clone built with HTML, CSS, JavaScript, PHP, MySQL, and XAMPP with advanced features including user authentication, ML-based recommendations, and accessibility support.

## 📋 Enhanced Features

### Frontend
- **Responsive Design**: Mobile-friendly layout with accessibility features
- **Home Page**: Hero section, featured posts, ML-based recommendations, categories
- **Blog Listing**: Pagination, search, category filtering, login requirement for full articles
- **Single Blog Post**: Full article view (requires login) with social sharing
- **About Page**: Author bio with mission statement
- **Contact Page**: Contact form with Google Maps integration, 250-word limit
- **User Authentication**: Complete registration and login system
- **Password Recovery**: Forgot password functionality with reset link
- **Newsletter Subscription**: Email capture system

### Backend (Admin Panel)
- **Dashboard**: Statistics overview with analytics
- **Post Management**: Create, edit, delete blog posts
- **Category Management**: Organize content
- **Image Upload**: Featured images for posts
- **User Authentication**: Secure admin login separate from user login

### Advanced Features ✨
1. **User Registration System**
   - 5 required fields (Full Name, Username, Email, Phone, Password)
   - Real-time username validation (prevents "admin")
   - Password match validation
   - Google reCAPTCHA integration
   - Password visibility toggle

2. **Dual Login System**
   - User login (with email/username)
   - Admin login (separate interface)
   - Remember me functionality
   - Forgot password with email recovery

3. **ML-Based Recommendations**
   - Personalized content based on reading history
   - Trending posts algorithm
   - Category-based suggestions
   - View tracking for analytics

4. **Accessibility Features**
   - ARIA labels for screen readers
   - Keyboard navigation support
   - High contrast mode support
   - Reduced motion preferences
   - Skip navigation links
   - Focus indicators

5. **Interactive Elements**
   - Image zoom on hover (without card expansion)
   - 250-word limit on textarea with counter
   - Google Maps integration
   - Social media links (working)
   - Password visibility toggles

6. **Security Features**
   - Password hashing (bcrypt)
   - SQL injection prevention
   - XSS protection
   - CSRF token ready
   - Session management

## 🚀 Installation Steps

### 1. Prerequisites
- XAMPP (Apache + MySQL + PHP)
- Modern web browser
- Text editor (VS Code, Sublime, etc.)

### 2. Setup XAMPP
1. Download and install XAMPP from https://www.apachefriends.org/
2. Start Apache and MySQL services from XAMPP Control Panel

### 3. Database Setup
1. Open phpMyAdmin: http://localhost/phpmyadmin
2. Create a new database named `lifestyle_blogger`
3. Import the SQL file:
   - Click on the `lifestyle_blogger` database
   - Go to "Import" tab
   - Choose `database/lifestyle_blogger.sql`
   - Click "Go" to import

### 4. Project Setup
1. Copy the entire `lifestyle-blogger` folder to:
   ```
   C:\xampp\htdocs\lifestyle-blogger
   ```
   (Or your XAMPP htdocs directory)

2. Update configuration if needed in `includes/config.php`:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   define('DB_NAME', 'lifestyle_blogger');
   define('SITE_URL', 'http://localhost/lifestyle-blogger');
   ```

### 5. Create Required Folders
Create these folders if they don't exist:
```
lifestyle-blogger/assets/images/
lifestyle-blogger/assets/images/blog/
lifestyle-blogger/assets/images/hero/
lifestyle-blogger/admin/includes/
```

### 6. Add Sample Images
Add placeholder images to:
- `assets/images/blog/` - Name them: post-01.jpg, post-02.jpg, post-03.jpg
- `assets/images/hero/` - Name them: hero-1.jpg, hero-2.jpg, hero-3.jpg
- `assets/images/about.jpg`
- `assets/images/favicon.ico` - Add your favicon (16x16 or 32x32 px)

You can download free images from:
- Unsplash: https://unsplash.com
- Pexels: https://www.pexels.com

### 7. Google reCAPTCHA Setup (Optional but Recommended)
1. Go to https://www.google.com/recaptcha/admin
2. Register your site (localhost)
3. Get your Site Key
4. Replace the site key in `register.php`:
   ```html
   <div class="g-recaptcha" data-sitekey="YOUR_SITE_KEY_HERE"></div>
   ```
   Note: The demo key works for testing: `6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI`

## 🔐 Access Credentials

### Admin Login
- **URL**: http://localhost/lifestyle-blogger/admin/
- **OR**: http://localhost/lifestyle-blogger/login.php?type=admin
- **Username**: admin
- **Password**: admin123

### User Registration
- **URL**: http://localhost/lifestyle-blogger/register.php
- Create your own account to test user features
- Username "admin" is blocked (case-insensitive)

### Admin Features
1. **Dashboard**: View statistics
2. **Add New Post**: Create blog posts with rich content
3. **Manage Posts**: Edit/delete existing posts
4. **Categories**: View all blog categories

## 📁 Complete Folder Structure

```
lifestyle-blogger/
│
├── index.php                    # Home page with ML recommendations
├── blog.php                     # Blog listing (login required to read)
├── blog-single.php              # Single post (requires login)
├── about.php                    # About page
├── contact.php                  # Contact page with Maps
├── login.php                    # User & Admin login
├── register.php                 # User registration with captcha
├── forgot-password.php          # Password recovery
├── reset-password.php           # Password reset form
├── logout.php                   # User logout
├── subscribe.php                # Newsletter handler
├── contact-submit.php           # Contact form handler
├── track-view.php               # ML tracking system
│
├── admin/                       # Admin panel
│   ├── index.php               # Admin login
│   ├── dashboard.php           # Dashboard
│   ├── add-post.php            # Add/Edit posts
│   ├── manage-posts.php        # Manage all posts
│   ├── categories.php          # Category management
│   ├── logout.php              # Admin logout
│   └── includes/
│       ├── admin-header.php    # Admin header
│       └── admin-footer.php    # Admin footer
│
├── includes/                    # PHP includes
│   ├── config.php              # Database config
│   ├── functions.php           # Helper functions
│   ├── header.php              # Site header (with user menu)
│   └── footer.php              # Site footer
│
├── assets/                      # Static assets
│   ├── css/
│   │   └── style.css           # Main stylesheet (with accessibility)
│   ├── js/
│   │   └── script.js           # JavaScript
│   └── images/                 # Images
│       ├── favicon.ico         # Website icon
│       ├── blog/               # Blog post images
│       ├── hero/               # Hero section images
│       └── about.jpg           # About page image
│
└── database/
    └── lifestyle_blogger.sql    # Database schema
```

## 🎨 Design Features

### Typography
- **Headings**: Cormorant Garamond (Serif)
- **Body**: Montserrat (Sans-serif)

### Color Scheme
- **Primary**: #d4a574 (Gold/Beige)
- **Secondary**: #1a1a1a (Dark)
- **Text**: #333333
- **Light Background**: #f9f9f9

### Responsive Breakpoints
- Desktop: 1200px+
- Tablet: 768px - 991px
- Mobile: < 768px

## 📝 Database Schema

### Tables

#### 1. users (Admin accounts)
- id, username, password, email, created_at

#### 2. user_accounts (Registered users)
- id, fullname, username, email, phone, password, reset_token, reset_expires, created_at

#### 3. categories
- id, name, slug, description, created_at

#### 4. posts
- id, title, slug, content, excerpt, image, category_id, author_id, is_featured, views, created_at, updated_at

#### 5. subscribers
- id, email, subscribed_at

#### 6. page_views (For ML recommendations)
- id, post_id, user_id, ip_address, viewed_at

## 🔧 Customization

### Changing Site Name
Edit `includes/config.php`:
```php
define('SITE_NAME', 'Your Site Name');
define('SITE_DESCRIPTION', 'Your tagline');
```

### Adding New Categories
1. Go to admin panel
2. Navigate to phpMyAdmin
3. Insert into `categories` table:
```sql
INSERT INTO categories (name, slug, description) 
VALUES ('Category Name', 'category-slug', 'Description');
```

### Updating Colors
Edit `assets/css/style.css` CSS variables:
```css
:root {
    --primary-color: #d4a574;
    --secondary-color: #1a1a1a;
}
```

## 🐛 Troubleshooting

### Issue: Database connection failed
**Solution**: 
- Check XAMPP MySQL is running
- Verify database credentials in `includes/config.php`
- Ensure database `lifestyle_blogger` exists

### Issue: Images not showing
**Solution**:
- Check folder permissions
- Verify image filenames match database entries
- Ensure images are in correct folders

### Issue: Admin login not working
**Solution**:
- Clear browser cache
- Check if sessions are enabled in php.ini
- Verify user exists in database

### Issue: Blank page on admin
**Solution**:
- Enable error reporting in `includes/config.php`:
```php
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

## 📱 Testing Checklist

### Frontend
- [ ] Home page loads correctly
- [ ] Navigation works on all pages
- [ ] Blog listing with pagination
- [ ] Single post page displays properly
- [ ] Contact form submits
- [ ] Newsletter subscription works
- [ ] Responsive on mobile devices

### Backend
- [ ] Admin login works
- [ ] Dashboard displays statistics
- [ ] Can create new posts
- [ ] Can edit existing posts
- [ ] Can delete posts
- [ ] Image upload functions
- [ ] Featured posts toggle works

## 🎓 University Project Notes

### Key Features for Grading
1. **Full Stack**: Frontend (HTML/CSS/JS) + Backend (PHP/MySQL)
2. **CRUD Operations**: Create, Read, Update, Delete posts
3. **Authentication**: Secure admin login system
4. **Database Design**: Normalized tables with relationships
5. **Responsive Design**: Mobile-friendly layout
6. **Form Validation**: Client and server-side
7. **File Upload**: Image handling
8. **Search & Filter**: Blog search and category filtering

### Technologies Used
- **Frontend**: HTML5, CSS3, JavaScript (ES6+)
- **Backend**: PHP 7.4+
- **Database**: MySQL 5.7+
- **Server**: Apache (XAMPP)
- **Libraries**: Font Awesome, Google Fonts

## 📚 Additional Resources

- PHP Documentation: https://www.php.net/docs.php
- MySQL Tutorial: https://www.mysqltutorial.org/
- MDN Web Docs: https://developer.mozilla.org/

## 👨‍💻 Development Tips

1. Always backup database before major changes
2. Test on multiple browsers
3. Keep code organized and commented
4. Use meaningful variable names
5. Follow security best practices

## 📄 License

This is a university project for educational purposes.

## 🙏 Credits

Design inspired by: https://websitedemos.net/lifestyle-blogger-04/

---

**Made with ❤️ for University Project**