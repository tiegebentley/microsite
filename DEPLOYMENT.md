# Kirby CMS Deployment to GoDaddy

## Prerequisites
- GoDaddy hosting account with PHP 8.0+ support
- SSH/FTP access to your GoDaddy hosting
- Git installed locally
- GitHub repository (optional but recommended)

## Local Setup Status
✅ Site running locally on http://localhost:7234
✅ Git repository initialized
⏳ GitHub repository needs to be created manually

## GitHub Setup

1. Create a new repository on GitHub:
   - Go to https://github.com/new
   - Name: `kirby-site` (or your preferred name)
   - Set as Public or Private
   - Don't initialize with README (we already have files)

2. Connect local repository to GitHub:
```bash
cd /root/kirby-site
git remote add origin https://github.com/YOUR_USERNAME/kirby-site.git
git push -u origin main
```

## GoDaddy Deployment Options

### Option 1: FTP Deployment (Simplest)

1. **Get FTP Credentials from GoDaddy:**
   - Log into GoDaddy account
   - Go to Web Hosting → Manage → Settings → FTP Users
   - Note your FTP hostname, username, and password

2. **Upload Files:**
   - Use an FTP client (FileZilla, Cyberduck, etc.)
   - Connect to your GoDaddy hosting
   - Upload all files EXCEPT:
     - `.git/` folder
     - `.gitignore`
     - `DEPLOYMENT.md`
     - `/vendor/` folder (will regenerate)

3. **Set Permissions:**
   - `/content/` - 755
   - `/site/accounts/` - 755
   - `/site/cache/` - 755
   - `/site/sessions/` - 755
   - `/media/` - 755
   - `/storage/` - 755

### Option 2: SSH + Git Deployment (Recommended)

1. **Enable SSH on GoDaddy:**
   - GoDaddy Account → Web Hosting → Manage → Settings → SSH Access
   - Enable SSH if not already enabled

2. **Connect via SSH:**
```bash
ssh YOUR_USERNAME@YOUR_DOMAIN.com
```

3. **Clone Repository on Server:**
```bash
cd ~/public_html  # or your web root
git clone https://github.com/YOUR_USERNAME/kirby-site.git .
```

4. **Install Dependencies:**
```bash
composer install --no-dev --optimize-autoloader
```

### Option 3: Automated Deployment Script

Use the included deployment script for quick updates:

```bash
# Run from local machine
./deploy.sh
```

## Important Configuration Changes for Production

1. **Update `/site/config/config.php`:**
```php
<?php
return [
    'debug' => false,  // IMPORTANT: Set to false in production
    'url' => 'https://yourdomain.com',
    'panel' => [
        'install' => false  // Disable panel installer
    ]
];
```

2. **Update `.htaccess` (if needed):**
   - GoDaddy may require specific RewriteBase settings
   - Add if needed: `RewriteBase /`

3. **PHP Version:**
   - Ensure GoDaddy is using PHP 8.0+
   - Check in cPanel: Software → Select PHP Version

## Database Configuration (if needed)

If using database features:
1. Create MySQL database in GoDaddy cPanel
2. Update database credentials in config

## Troubleshooting Common GoDaddy Issues

### White Screen / 500 Error
- Check PHP version (must be 8.0+)
- Check file permissions
- Enable debug mode temporarily to see errors

### Panel Not Working
- Clear browser cache
- Check `/media/` folder permissions
- Verify `.htaccess` file is uploaded

### Slow Performance
- Enable OPcache in cPanel
- Consider CDN for assets
- Optimize images

## Keeping Sites in Sync

### Manual Sync
1. Make changes locally
2. Test on http://localhost:7234
3. Commit to Git
4. Deploy to GoDaddy

### Semi-Automated Sync
Use the deployment script to:
- Push to GitHub
- Pull on GoDaddy via SSH
- Clear caches
- Set permissions

## Security Checklist

- [ ] Debug mode disabled in production
- [ ] Panel installer disabled
- [ ] Strong passwords for panel users
- [ ] Regular backups configured
- [ ] SSL certificate active
- [ ] File permissions properly set

## Support Resources

- Kirby Documentation: https://getkirby.com/docs
- GoDaddy Help: https://www.godaddy.com/help
- GitHub: Your repository issues section