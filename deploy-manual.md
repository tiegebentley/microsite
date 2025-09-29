# Manual Deployment Guide

## Safe Deployment to GoDaddy (No stored credentials)

### Method 1: FTP Upload
1. **Download FTP client** (FileZilla, Cyberduck, etc.)
2. **Get credentials from GoDaddy**: Hosting → Manage → FTP Access
3. **Upload these files/folders**:
   - All files EXCEPT: `.git/`, `vendor/`, `deploy.sh`
   - Upload to your web root (usually `public_html/`)

### Method 2: Check for Git Integration
1. **Log into GoDaddy hosting panel**
2. **Look for**: "Git", "GitHub", "Repository" options
3. **If available**: Connect https://github.com/tiegebentley/microsite.git
4. **If not available**: Use FTP method above

### Method 3: Command Line (Advanced)
Only if you have SSH access to your GoDaddy hosting:
```bash
# Connect to your hosting (enter password when prompted)
ssh your_username@your_domain.com

# Clone your repository
cd ~/public_html
git clone https://github.com/tiegebentley/microsite.git .

# Install dependencies
composer install --no-dev --optimize-autoloader
```

### After Deployment:
- Visit your domain to test
- Check that all pages load correctly
- Verify images and CSS are working

### Security Notes:
- ✅ Never store FTP passwords in files
- ✅ Use SFTP instead of FTP when possible
- ✅ Keep credentials in password manager
- ✅ Use Git integration if available