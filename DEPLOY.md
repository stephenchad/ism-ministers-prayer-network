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

#### Step 4: Environment Variables
Add these in Render Dashboard → Your Service → Environment:

**Required:**
```env
APP_NAME="ISM Ministers Prayer Network"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app.onrender.com
APP_KEY=base64:xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

DB_CONNECTION=pgsql
DB_HOST=xxxxx.render.com
DB_PORT=5432
DB_DATABASE=xxxxx
DB_USER=xxxxx
DB_PASSWORD=xxxxx
```

**Optional (Email & Social Login):**
```env
# Email (use Mailtrap for testing)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@yourdomain.com"
MAIL_FROM_NAME="ISM Prayer Network"

# Google Login
GOOGLE_CLIENT_ID=xxxxx.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=xxxxx
GOOGLE_REDIRECT_URI=https://yourdomain.com/auth/google/callback

# Facebook Login
FACEBOOK_CLIENT_ID=xxxxx
FACEBOOK_CLIENT_SECRET=xxxxx
FACEBOOK_REDIRECT_URI=https://yourdomain.com/auth/facebook/callback
```

#### Step 5: Create Database
1. Click "New +" → "PostgreSQL"
2. Name: `ism-prayer-db`
3. Plan: Free
4. Copy the connection details and add to Environment Variables

#### Step 6: Deploy
1. Click "Create Web Service"
2. Wait for build to complete
3. Visit your URL

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
Add to Railway Variables:
```env
APP_ENV=production
APP_DEBUG=false
APP_KEY= (run: php artisan key:generate in local)
DATABASE_URL=postgres://user:pass@host:5432/db
```

---

### 3. 000WebHost (Simplest - PHP/MySQL)

#### Step 1: Create Account
1. Go to [000WebHost.com](https://www.000webhost.com)
2. Sign up for free

#### Step 2: Upload Files
1. In 000WebHost panel, go to "Manage Website"
2. Click "Upload Website"
3. Zip project files (exclude vendor, node_modules)
4. Upload and extract

#### Step 3: Create Database
1. Go to "MySQL Databases"
2. Create database and user
3. Note credentials

#### Step 4: Configure .env on Server
```env
APP_NAME="ISM Ministers Prayer Network"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yoursite.000webhostapp.com
APP_KEY=base64:xxxxx

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_db_name
DB_USER=your_db_user
DB_PASSWORD=your_db_password
```

---

## After Deployment

### Run Migrations
```bash
php artisan migrate --force
```

### Generate APP_KEY
```bash
php artisan key:generate
```

### Clear Cache
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
```

### Set Permissions
```bash
chmod -R 755 storage bootstrap/cache
```

---

## Environment Variables Reference

| Variable | Required | Description |
|----------|----------|-------------|
| APP_NAME | Yes | Application name |
| APP_ENV | Yes | Set to `production` |
| APP_DEBUG | Yes | Set to `false` in production |
| APP_URL | Yes | Your domain URL |
| APP_KEY | Yes | Run `php artisan key:generate` |
| DB_* | Yes | Database connection settings |
| MAIL_* | No | Email configuration |
| GOOGLE_CLIENT_* | No | Google OAuth |
| FACEBOOK_CLIENT_* | No | Facebook OAuth |

---

## Troubleshooting

### "No input file specified"
- Check your `public` directory is set as document root

### Database connection errors
- Verify database credentials in Environment Variables
- Ensure database host allows connections

### 500 Internal Server Error
- Check `storage/logs/laravel.log`
- Set `APP_DEBUG=true` temporarily to see errors

---

## Quick Deploy Script

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

Run: `chmod +x deploy.sh`
