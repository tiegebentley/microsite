# GoDaddy 404 Error Troubleshooting

## Quick Fixes to Try:

### 1. Update .htaccess File
Replace your current `.htaccess` with the GoDaddy-specific version:
- Upload `.htaccess-godaddy` as `.htaccess` to your web root
- This includes `RewriteBase /` which GoDaddy often requires

### 2. Check File Structure
Ensure these files are in your GoDaddy web root (usually `public_html/`):
```
index.php          ← CRITICAL: This must be there
.htaccess          ← Updated version
kirby/             ← Kirby core files
site/              ← Your templates and config
content/           ← Your content files
assets/            ← CSS, JS, images
```

### 3. Verify PHP Version
1. Log into GoDaddy cPanel
2. Go to Software → Select PHP Version
3. Ensure it's PHP 8.0 or higher

### 4. Check Error Logs
In GoDaddy cPanel:
1. Go to Files → Error Logs
2. Check the most recent entries
3. Look for specific error messages

### 5. Test Basic PHP
Create a test file `test.php` with:
```php
<?php
phpinfo();
echo "PHP is working!";
?>
```
Upload and visit `yourdomain.com/test.php`

### 6. Directory Permissions
Set these permissions:
- Folders: 755
- Files: 644
- index.php: 644

### 7. Alternative .htaccess (If above doesn't work)
Try this minimal version:
```apache
RewriteEngine On
RewriteBase /
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]
```

### 8. Check URL Structure
- Try: `yourdomain.com` (no trailing slash)
- Try: `yourdomain.com/index.php` (direct PHP access)
- Try: `yourdomain.com/home` (Kirby page)

### 9. Common GoDaddy Issues:
- **Wrong directory**: Files might be in wrong folder
- **Missing index.php**: Must be in root directory
- **PHP not enabled**: Check hosting settings
- **RewriteBase missing**: GoDaddy usually needs this

### 10. Last Resort - Simple HTML Test
Create `index.html`:
```html
<!DOCTYPE html>
<html>
<head><title>Test</title></head>
<body><h1>Site is working!</h1></body>
</html>
```
If this works, the issue is with PHP/Kirby setup.

## What Error Are You Seeing?
- **404 Not Found**: Usually .htaccess or file location issue
- **500 Internal Server Error**: PHP or permission issue
- **White/blank page**: PHP error, check error logs
- **Index of /**: Missing index.php file