# 🚀 Quick Start Guide - Enhanced Version

## ⚡ 5-Minute Setup

### Step 1: Install XAMPP (2 minutes)
1. Download XAMPP: https://www.apachefriends.org/
2. Install with default settings
3. Open XAMPP Control Panel
4. Click "Start" for **Apache** and **MySQL**

### Step 2: Create Database (1 minute)
1. Open browser: **http://localhost/phpmyadmin**
2. Click "**New**" to create database
3. Name it: **`lifestyle_blogger`**
4. Click "**Create**"
5. Click "**Import**" tab
6. Choose **`lifestyle_blogger.sql`** file from project
7. Click "**Go**"

### Step 3: Copy Files (1 minute)
Copy the entire project folder to:
```
C:\xampp\htdocs\lifestyle-blogger
```

### Step 4: Add Images (1 minute)
1. Download 6-10 free images from **Unsplash.com** or **Pexels.com**
2. Rename them: `post-01.jpg`, `post-02.jpg`, `post-03.jpg`, etc.
3. Put in: `assets/images/blog/`
4. Add 3 more as: `hero-1.jpg`, `hero-2.jpg`, `hero-3.jpg`
5. Put in: `assets/images/hero/`
6. Add one as: `about.jpg` in `assets/images/`
7. **ADD FAVICON**: `favicon.ico` (16x16 px) in `assets/images/`

### Step 5: Access Website (30 seconds)
1. **Homepage**: http://localhost/lifestyle-blogger/
2. **User Registration**: http://localhost/lifestyle-blogger/register.php
3. **User Login**: http://localhost/lifestyle-blogger/login.php
4. **Admin Login**: http://localhost/lifestyle-blogger/login.php?type=admin
   - Username: `admin`
   - Password: `admin123`

---

## ✅ Quick Test Checklist

### Test 1: User Registration (30 sec)
- [ ] Go to register page
- [ ] Try username "**admin**" → Should show error ✓
- [ ] Fill all 6 fields
- [ ] Passwords must match ✓
- [ ] Complete reCAPTCHA ✓
- [ ] Register successfully

### Test 2: User Login (30 sec)
- [ ] Login with your new account
- [ ] See "**Welcome, [Your Name]**" in header ✓
- [ ] Click eye icon to toggle password visibility ✓
- [ ] Try "**Forgot Password**" link ✓

### Test 3: ML Recommendations (1 min)
- [ ] As guest, see "**Trending Now**" on homepage
- [ ] Login and read 2-3 posts from same category
- [ ] Go back to homepage
- [ ] Now see "**Recommended For You**" ✓

### Test 4: Content Access (30 sec)
- [ ] Logout, try clicking blog post → **"Login to Read"** ✓
- [ ] Login, now can read full posts ✓

### Test 5: Contact Features (30 sec)
- [ ] Go to contact page
- [ ] See **Google Maps** ✓
- [ ] Type in message box → See **word counter** ✓
- [ ] Try typing 250+ words → Gets limited ✓
- [ ] Click social media icons → Open correctly ✓

### Test 6: Image Hover (15 sec)
- [ ] Hover over blog post images
- [ ] Images **zoom without expanding card** ✓

### Test 7: Admin Panel (1 min)
- [ ] Go to admin login (or toggle in login page)
- [ ] Login: `admin` / `admin123`
- [ ] See dashboard with statistics ✓
- [ ] Create a new post ✓
- [ ] Check it appears on homepage ✓

---

## 🆘 Quick Fixes

### Problem: "Can't connect to database"
**Fix**: 
1. Check MySQL is running in XAMPP
2. Verify database name is `lifestyle_blogger`
3. Check `includes/config.php` settings

### Problem: "Images not showing"
**Fix**:
1. Make sure image filenames match exactly
2. Check images are in correct folders
3. File names are case-sensitive!

### Problem: "Admin login not working"
**Fix**:
1. Make sure you imported the SQL file
2. Default username: `admin`, password: `admin123`
3. Check if you're using admin login (not user login)

### Problem: "Page is blank/white screen"
**Fix**:
1. Check if Apache is running
2. Enable error display: Add to `config.php`:
   ```php
   error_reporting(E_ALL);
   ini_set('display_errors', 1);
   ```

### Problem: "reCAPTCHA error"
**Fix**: 
- Test key is included, works on localhost
- Ignore the warning banner (normal for test keys)

### Problem: "Can't reset password"
**Fix**:
- Demo mode shows reset link directly
- Email requires SMTP configuration (optional for project)

---

## 🎯 Demo Sequence (For Presentation)

### 1. Show Homepage (30 sec)
- Hero section
- Social stats
- **ML Recommendations** (highlight this!)
- Favicon in tab

### 2. User Registration (30 sec)
- Try "admin" username → Error
- Show password match validation
- reCAPTCHA

### 3. Login & Read Post (30 sec)
- Login
- Show "Welcome" message
- Read a post (requires login)

### 4. ML Magic (45 sec)
- Read 3 Tech posts
- Back to homepage
- "Recommended For You" shows Tech content

### 5. Features Tour (45 sec)
- Contact: Maps + word counter
- Image hover zoom
- Password visibility toggle
- Social media links

### 6. Admin Panel (30 sec)
- Switch to admin
- Dashboard
- Create post

**Total: ~4 minutes + Q&A**

---

## 🎨 Customization Tips

### Change Site Name:
Edit `includes/config.php`:
```php
define('SITE_NAME', 'Your Blog Name');
```

### Change Colors:
Edit `assets/css/style.css`:
```css
:root {
    --primary-color: #your-color;
}
```

### Add Your Favicon:
1. Create 16x16 or 32x32 px icon
2. Save as `favicon.ico`
3. Put in `assets/images/`

### Update Social Links:
Edit footer and contact page, replace with your links

---

## 📊 Features Implemented

✅ User registration (6 fields, captcha, validation)
✅ Dual login system (user + admin)
✅ Password recovery
✅ ML-based recommendations
✅ Google Maps integration
✅ Image hover zoom
✅ 250-word text limit
✅ Accessibility features
✅ Working social media links
✅ Favicon support
✅ Login-required content
✅ Real-time validations

---

## 🎓 Grading Checklist

- [x] Tab & Favicon ✓
- [x] Admin login with password toggle ✓
- [x] User registration (6 fields) ✓
- [x] Password match validation ✓
- [x] Google reCAPTCHA ✓
- [x] Block "admin" username ✓
- [x] Forgot password ✓
- [x] Accessibility ✓
- [x] Google Maps ✓
- [x] Social media links (4) ✓
- [x] Image hover zoom ✓
- [x] Text box limit (250 words) ✓
- [x] ML recommendations ✓

**ALL REQUIREMENTS MET! ✓**

---

## 📞 Need Help?

Most issues are fixed by:
1. **Restart Apache & MySQL** in XAMPP
2. **Clear browser cache** (Ctrl + Shift + Del)
3. **Check database exists** in phpMyAdmin
4. **Verify file paths** are correct
5. **Check image filenames** match exactly

---

**🎉 You're ready to present! Good luck!**