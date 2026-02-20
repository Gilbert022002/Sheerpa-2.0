# 📦 Hostinger Deployment Guide - Image Upload Fix

## ✅ Files Modified

### **Controllers Updated:**
1. `app/Http/Controllers/Instructor/CourseController.php`
   - Changed thumbnail upload path to `uploads/course-thumbnails`
   
2. `app/Http/Controllers/ProfileController.php`
   - Changed profile image upload path to `uploads/profile-images`
   
3. `app/Http/Controllers/Admin/UserController.php`
   - Changed profile image upload path to `uploads/profile-images`

---

## 🚀 Steps to Deploy on Hostinger

### **Step 1: Upload Modified Files**

Upload these 3 files to your Hostinger server:
```
app/Http/Controllers/Instructor/CourseController.php
app/Http/Controllers/ProfileController.php
app/Http/Controllers/Admin/UserController.php
```

### **Step 2: Create Storage Symlink**

**Option A - Via SSH (Recommended):**
1. Login to Hostinger
2. Go to **Advanced** → **SSH Access**
3. Connect via SSH
4. Run:
```bash
cd public_html
php artisan storage:link
```

**Option B - Via File Manager (If SSH not available):**
1. Go to **File Manager**
2. Navigate to `public_html`
3. Create a new folder: `uploads` inside `public`
4. The files will now be stored in `public/uploads/`

### **Step 3: Set Folder Permissions**

In **File Manager**, set these permissions:

```
storage/                  → 755
storage/app/             → 755
storage/app/public/      → 755
public/uploads/          → 755 (if created)
```

### **Step 4: Update .env File**

In Hostinger **File Manager** → `public_html/.env`:

```env
FILESYSTEM_DISK=public
APP_URL=https://your-domain.com
```

### **Step 5: Clear Caches**

**Via SSH:**
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

**OR via Web:**
Create a file `clear-cache.php` in `public_html`:
```php
<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
echo "Config: " . (Artisan::call('config:clear') === 0 ? "Cleared\n" : "Failed\n");
echo "Cache: " . (Artisan::call('cache:clear') === 0 ? "Cleared\n" : "Failed\n");
echo "View: " . (Artisan::call('view:clear') === 0 ? "Cleared\n" : "Failed\n");
```

Visit: `https://your-domain.com/clear-cache.php`
Then delete the file.

---

## 📁 Where Files Will Be Stored

After upload, files will be in:
```
storage/app/public/uploads/course-thumbnails/xxx.jpg
storage/app/public/uploads/profile-images/xxx.jpg
```

And accessible via:
```
https://your-domain.com/storage/uploads/course-thumbnails/xxx.jpg
https://your-domain.com/storage/uploads/profile-images/xxx.jpg
```

---

## ✅ Testing

### **Test Course Thumbnail:**
1. Login as instructor
2. Go to **Mes Cours** → **Créer un cours**
3. Upload a thumbnail
4. Save the course
5. Check if thumbnail appears

### **Test Profile Picture:**
1. Go to your profile
2. Click edit profile picture
3. Upload an image
4. Check if it appears in header

---

## 🔧 Troubleshooting

### **Images Still Not Showing?**

**Check 1:** Verify symlink exists
```bash
ls -la public/storage
```
Should show: `storage -> ../../storage/app/public`

**Check 2:** Verify files exist
```bash
ls storage/app/public/uploads/
```

**Check 3:** Check file permissions
```bash
chmod -R 755 storage/app/public/uploads
```

**Check 4:** Verify database paths
```sql
SELECT thumbnail FROM courses ORDER BY created_at DESC LIMIT 5;
```
Should show: `uploads/course-thumbnails/xxx.jpg`

---

## 📞 Need Help?

If images still don't appear:
1. Check browser console for 404 errors
2. Verify the image URL in browser
3. Check Hostinger error logs in **Logs** section

---

## ✨ Done!

Your image uploads should now work perfectly on Hostinger! 🎉
