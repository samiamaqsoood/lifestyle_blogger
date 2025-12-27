# 🚀 Quick Start Guide - 5 Minutes Setup

## Step 1: Install XAMPP (2 minutes)
1. Download XAMPP: https://www.apachefriends.org/
2. Install it with default settings
3. Open XAMPP Control Panel
4. Click "Start" for Apache and MySQL

## Step 2: Create Database (1 minute)
1. Open browser: http://localhost/phpmyadmin
2. Click "New" to create database
3. Name it: `lifestyle_blogger`
4. Click "Create"
5. Click "Import" tab
6. Choose the `lifestyle_blogger.sql` file
7. Click "Go"

## Step 3: Copy Files (1 minute)
1. Copy the entire project folder to:
   ```
   C:\xampp\htdocs\lifestyle-blogger
   ```

## Step 4: Add Images (1 minute)
1. Download 6-10 free images from Unsplash or Pexels
2. Rename them: post-01.jpg, post-02.jpg, post-03.jpg, etc.
3. Put them in: `assets/images/blog/`
4. Add 3 more as: hero-1.jpg, hero-2.jpg, hero-3.jpg
5. Put them in: `assets/images/hero/`
6. Add one as: about.jpg in `assets/images/`

## Step 5: Access Website (30 seconds)
1. **Frontend**: http://localhost/lifestyle-blogger/
2. **Admin Panel**: http://localhost/lifestyle-blogger/admin/
   - Username: `admin`
   - Password: `admin123`

## ✅ Verification Checklist
- [ ] Home page shows
- [ ] Can navigate to Blog, About, Contact pages
- [ ] Can login to admin panel
- [ ] Can create a new blog post in admin
- [ ] New post appears on frontend

## 🎯 Quick Test
1. Login to admin
2. Create a test post with title "My First Post"
3. Go back to home page
4. Your post should appear!

## 🆘 Quick Fixes

**MySQL not starting?**
- Change MySQL port in XAMPP config to 3307
- Update `includes/config.php` port if needed

**Page shows error?**
- Check if Apache and MySQL are running in XAMPP
- Verify database name is `lifestyle_blogger`

**Images not showing?**
- Make sure image filenames match (case-sensitive)
- Check images are in correct folders

## 📞 Need Help?
Common issues usually fixed by:
1. Restarting Apache and MySQL in XAMPP
2. Clearing browser cache (Ctrl + Shift + Del)
3. Checking folder names are correct

---

**You're all set! Time to demo your project! 🎉**