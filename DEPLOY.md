# Deployment Guide

## Free Hosting Options for Laravel

### 1. Render.com (Recommended)

#### Step 1: Push to GitHub
Your code is already on GitHub: https://github.com/stephenchad/ism-ministers-prayer-network

#### Step 2: Create Render Account
1. Go to [Render.com](https://render.com) and sign up
2. Connect your GitHub account

#### Step 3: Create Web Service
1. Click "New +" → "Web Service"
2. Select your repository: `stephenchad/ism-ministers-prayer-network`
3. Configure:
   - **Name:** ism-ministers-prayer-network
   - **Environment:** PHP
   - **Build Command:** `composer install --no-interaction --optimize-autoloader`
   - **Start Command:** `php artisan serve --host=0.0.0.0 --port=$PORT`

#### Step 4: Add Environment Variables
In Render dashboard, add:
```
APP_ENV=production
APP_DEBUG=false
APP_KEY= (click "Generate" button)
APP_URL= (your Render URL)
```

#### Step 5: Create Database
1. Click "New +" → "PostgreSQL"
2. Name: `ism-prayer-db`
3. Plan: Free
4. Copy the connection details

#### Step 6: Connect Database
1. Go to your Web Service → "Environment"
2. Add database variables:
```
DB_CONNECTION=pgsql
DB_DATABASE= (from PostgreSQL)
DB_HOST= (from PostgreSQL)
DB_USERNAME= (from PostgreSQL)
DB_PASSWORD= (from PostgreSQL)
```

---

### 2. Railway.app (Easier Setup)

#### Step 1: Create Railway Account
1. Go to [Railway.app](https://railway.app) and sign up
2. Connect GitHub

#### Step 2: Deploy
1. Click "New Project"
2. Select "Deploy from GitHub repo"
3. Select: `stephenchad/ism-ministers-prayer-network`

#### Step 3: Add Database
1. Click "New +" → "Database" → "PostgreSQL"
2. Copy the connection URL

#### Step 4: Configure Environment
1. Go to your service → "Variables"
2. Add:
```
APP_ENV=production
APP_DEBUG=false
APP_KEY= (run: php artisan key:generate)
DATABASE_URL= (from PostgreSQL)
```

---

### 3. 000WebHost (Simplest - PHP/MySQL)

#### Step 1: Create Account
1. Go to [000WebHost.com](https://www.000webhost.com)
2. Sign up for free

#### Step 2: Upload Files
1. In 000WebHost panel, go to "Manage Website"
2. Click "Upload Website"
3. Zip your project files (exclude vendor, node_modules)
4. Upload and extract

#### Step 3: Create Database
1. Go to "MySQL Databases"
2. Create database and user
3. Note the credentials

#### Step 4: Configure .env
Edit `.env` file on server with your database details

---

## After Deployment

### 1. Run Migrations
```bash
php artisan migrate --force
```

### 2. Generate APP_KEY (if not set)
```bash
php artisan key:generate
```

### 3. Clear Cache
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
```

### 4. Set File Permissions
```bash
chmod -R 755 storage bootstrap/cache
```

---

## Troubleshooting

### "No input file specified"
- Check your `public` directory is set as document root

### Database connection errors
- Verify database credentials in `.env`
- Ensure database host allows connections

### 500 Internal Server Error
- Check `storage/logs/laravel.log`
- Set `APP_DEBUG=true` temporarily to see errors

---

## Recommended: Use Deploy Script

Create `deploy.sh`:
```bash
#!/bin/bash
git pull origin main
composer install --no-interaction --optimize-autoloader
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:clear
echo "Deployment complete!"
```

Make executable: `chmod +x deploy.sh`
