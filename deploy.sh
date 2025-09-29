#!/bin/bash

# Kirby Site Deployment Script for GoDaddy
# =========================================
# This script helps deploy your local Kirby site to GoDaddy hosting

# Configuration - EDIT THESE VALUES
GODADDY_USER="YOUR_GODADDY_USERNAME"
GODADDY_HOST="YOUR_DOMAIN.com"
GODADDY_PATH="~/public_html"  # Adjust if your web root is different
GITHUB_REPO="https://github.com/tiegebentley/microsite.git"

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo "🚀 Kirby Site Deployment Script"
echo "================================"

# Function to check if configuration is set
check_config() {
    if [[ "$GODADDY_USER" == "YOUR_GODADDY_USERNAME" ]] || [[ "$GODADDY_HOST" == "YOUR_DOMAIN.com" ]]; then
        echo -e "${RED}❌ Error: Please edit this script and set your GoDaddy credentials${NC}"
        echo "   Edit the configuration section at the top of deploy.sh"
        exit 1
    fi
}

# Function to deploy via FTP
deploy_ftp() {
    echo -e "${YELLOW}📦 Preparing FTP deployment...${NC}"

    # Create deployment package
    DEPLOY_DIR="deploy_temp"
    rm -rf $DEPLOY_DIR
    mkdir -p $DEPLOY_DIR

    # Copy files (excluding unnecessary ones)
    rsync -av --progress \
        --exclude '.git' \
        --exclude '.gitignore' \
        --exclude 'deploy.sh' \
        --exclude 'DEPLOYMENT.md' \
        --exclude 'deploy_temp' \
        --exclude 'vendor' \
        --exclude '.DS_Store' \
        --exclude 'node_modules' \
        ./ $DEPLOY_DIR/

    echo -e "${GREEN}✓ Files prepared for deployment${NC}"
    echo -e "${YELLOW}⚠️  Now use your FTP client to upload the contents of 'deploy_temp' folder${NC}"
    echo "   Don't forget to:"
    echo "   1. Set proper permissions (755 for folders)"
    echo "   2. Run 'composer install' on server if possible"
}

# Function to deploy via SSH
deploy_ssh() {
    echo -e "${YELLOW}🔌 Deploying via SSH...${NC}"

    # Test SSH connection
    ssh -o ConnectTimeout=5 $GODADDY_USER@$GODADDY_HOST "echo '✓ SSH connection successful'" 2>/dev/null

    if [ $? -ne 0 ]; then
        echo -e "${RED}❌ Cannot connect via SSH. Falling back to FTP method.${NC}"
        deploy_ftp
        return
    fi

    # Push local changes to GitHub first
    echo -e "${YELLOW}📤 Pushing to GitHub...${NC}"
    git add .
    git commit -m "Deployment update $(date +%Y-%m-%d_%H-%M-%S)" 2>/dev/null
    git push origin main

    # Execute deployment commands on server
    echo -e "${YELLOW}🔄 Pulling changes on server...${NC}"

    ssh $GODADDY_USER@$GODADDY_HOST << 'ENDSSH'
        cd $GODADDY_PATH

        # Pull latest changes
        if [ -d ".git" ]; then
            echo "Pulling latest changes..."
            git pull origin main
        else
            echo "Cloning repository..."
            git clone $GITHUB_REPO .
        fi

        # Install/update dependencies if composer exists
        if command -v composer &> /dev/null; then
            echo "Installing dependencies..."
            composer install --no-dev --optimize-autoloader
        fi

        # Set permissions
        echo "Setting permissions..."
        chmod -R 755 content/ site/accounts/ site/cache/ site/sessions/ media/ storage/ 2>/dev/null

        # Clear cache
        echo "Clearing cache..."
        rm -rf site/cache/* 2>/dev/null

        echo "✓ Deployment complete!"
ENDSSH
}

# Function for quick sync (only changed files)
quick_sync() {
    echo -e "${YELLOW}⚡ Quick sync via rsync...${NC}"

    rsync -avz --delete \
        --exclude '.git' \
        --exclude '.gitignore' \
        --exclude 'deploy.sh' \
        --exclude 'DEPLOYMENT.md' \
        --exclude 'vendor' \
        --exclude 'node_modules' \
        --exclude '.DS_Store' \
        --exclude 'site/accounts/*' \
        --exclude 'site/cache/*' \
        --exclude 'site/sessions/*' \
        --exclude 'content/*' \
        --exclude 'media/*' \
        ./ $GODADDY_USER@$GODADDY_HOST:$GODADDY_PATH/

    if [ $? -eq 0 ]; then
        echo -e "${GREEN}✓ Quick sync completed!${NC}"
    else
        echo -e "${RED}❌ Sync failed. Check your connection and credentials.${NC}"
    fi
}

# Main menu
main_menu() {
    check_config

    echo ""
    echo "Choose deployment method:"
    echo "1) SSH Deployment (Recommended)"
    echo "2) Prepare for FTP Upload"
    echo "3) Quick Sync (rsync - only code changes)"
    echo "4) Exit"
    echo ""
    read -p "Enter choice [1-4]: " choice

    case $choice in
        1)
            deploy_ssh
            ;;
        2)
            deploy_ftp
            ;;
        3)
            quick_sync
            ;;
        4)
            echo "Exiting..."
            exit 0
            ;;
        *)
            echo -e "${RED}Invalid option${NC}"
            main_menu
            ;;
    esac
}

# Check if we're in the right directory
if [ ! -f "index.php" ] || [ ! -d "kirby" ]; then
    echo -e "${RED}❌ Error: This doesn't look like a Kirby installation${NC}"
    echo "   Run this script from your Kirby site root directory"
    exit 1
fi

# Run main menu
main_menu

echo ""
echo -e "${GREEN}🎉 Deployment process completed!${NC}"
echo "   Check your site at: https://$GODADDY_HOST"