# reCAPTCHA "Invalid Site Key" Fix Guide

## Problem
The error "ERROR for site owner: Invalid site key" appears on the registration page.

## Root Cause
The domain `blogbee.lovestoblog.com` is not registered in your Google reCAPTCHA console.

## Solution Steps

### Step 1: Add Domain to Google reCAPTCHA Console

1. **Go to Google reCAPTCHA Admin:**
   - Visit: https://www.google.com/recaptcha/admin
   - Sign in with your Google account

2. **Find Your Site:**
   - Look for the site with keys starting with `6LevMDks...`
   - OR create a new site if needed

3. **Edit Site Settings:**
   - Click on your site or click "Settings" (gear icon)
   - Scroll down to "Domains" section

4. **Add Your Domain:**
   - Click "+ Add Domain"
   - Enter: `blogbee.lovestoblog.com`
   - Click "Save"

5. **Optional - Add Root Domain:**
   - Also add: `lovestoblog.com` (for all subdomains)
   - This allows it to work on any subdomain

### Step 2: Verify reCAPTCHA Version

Your keys might be for reCAPTCHA v3, but the code uses v2. Check in the console:
- **v2**: Shows "I'm not a robot" checkbox
- **v3**: Invisible, runs in background

If your keys are v3, the code needs to be updated.

### Step 3: Wait and Test

1. **Wait 5-10 minutes** after adding the domain (Google needs time to update)
2. **Clear your browser cache**
3. **Test the registration page again**

## Current Configuration

- **Site Key:** `6LevMDksAAAAAJBPP1hx7YiBEaFf57X9ZgywFhsS`
- **Secret Key:** `6LevMDksAAAAAOygJmeFs2bY4p-y8hLU_a78-sES`
- **Domain:** `blogbee.lovestoblog.com`
- **Implementation:** reCAPTCHA v2 (checkbox)

## If Still Not Working

1. **Check Domain Spelling:**
   - Make sure it's exactly: `blogbee.lovestoblog.com`
   - No `www.` unless you added it
   - No trailing slash

2. **Verify Key Type:**
   - In Google console, check if keys are v2 or v3
   - If v3, we need to update the code

3. **Generate New Keys:**
   - If nothing works, create new keys in Google console
   - Make sure to select the correct version (v2)
   - Add domain before generating keys

## Quick Test

After adding domain, test by:
1. Going to: https://blogbee.lovestoblog.com/register.php
2. The reCAPTCHA should load without error
3. You should see the checkbox, not an error message

