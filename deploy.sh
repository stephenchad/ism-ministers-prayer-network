#!/bin/bash

# Quick Production Deployment Script
# This script automates the deployment process

set -e  # Exit on error

echo "=========================================="
echo "PRODUCTION DEPLOYMENT SCRIPT"
echo "=========================================="
echo ""

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

# Check if .env exists
if [ ! -f .env ]; then
    echo -e "${RED}Error: .env file not found${NC}"
    echo "Please copy .env.production.example to .env and configure it"
    exit 1
fi

# Confirm deployment
echo -e "${YELLOW}WARNING: This will deploy to PRODUCTION${NC}"
read -p "Are you sure you want to continue? (yes/no): " confirm
if [ "$confirm" != "yes" ]; then
    echo "Deployment cancelled"
    exit 0
fi

echo ""
echo "Step 1: Enabling maintenance mode..."
php artisan down --retry=60

echo ""
echo "Step 2: Pulling latest code..."
git pull origin main || echo "Skipping git pull (not a git repository or no changes)"

echo ""
echo "Step 3: Installing/updating dependencies..."
composer install --optimize-autoloader --no-dev --no-interaction

echo ""
echo "Step 4: Running database migrations..."
php artisan migrate --force

echo ""
echo "Step 5: Clearing caches..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

echo ""
echo "Step 6: Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

echo ""
echo "Step 7: Restarting queue workers..."
php artisan queue:restart || echo "No queue workers to restart"

echo ""
echo "Step 8: Setting permissions..."
chmod -R 775 storage bootstrap/cache

echo ""
echo "Step 9: Disabling maintenance mode..."
php artisan up

echo ""
echo -e "${GREEN}=========================================="
echo "DEPLOYMENT COMPLETED SUCCESSFULLY!"
echo "==========================================${NC}"
echo ""
echo "Next steps:"
echo "1. Test the application"
echo "2. Monitor logs: tail -f storage/logs/laravel.log"
echo "3. Check health endpoint: curl https://yourdomain.com/health"
echo ""
