# Deployment Guide

## Recommended: 000WebHost (Free - No Docker!)

### Step 1: Create Account
1. Go to [000WebHost.com](https://www.000webhost.com)
2. Sign up for free account

### Step 2: Create Website
1. Click "Create New Website"
2. Choose "Upload Website"
3. Name your site

### Step 3: Upload Files
1. **ZIP** these files/folders:
   ```
   app/
   bootstrap/
   config/
   public/
   resources/
   routes/
   storage/
   artisan
   composer.json
   package.json
   ```
2. **DO NOT include:** vendor/, node_modules/, .env
3. Upload ZIP file and extract

### Step 4: Create Database
1. Go to "MySQL Databases"
2. Create: Database Name, User, Password
3. Note all credentials

### Step 5: Install Dependencies
1. In 000WebHost panel, go to "Advanced" → "Terminal"
2. Run:
   ```bash
   composer install --no-dev --optimize-autoloader
   ```

### Step 6: Configure .env
1. Go to "Advanced" → "File Manager"
2. Create `.env` file with:
   ```env
   APP_NAME="ISM Ministers Prayer Network"
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://yoursite.000webhostapp.com
   APP_KEY=base64:xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

   DB_CONNECTION=mysql
   DB_HOST=localhost
   DB_PORT=3306
   DB_DATABASE=your_db_name
   DB_USER=your_db_user
   DB_PASSWORD=your_db_password
   ```

### Step 7: Generate APP_KEY
In terminal:
```bash
php artisan key:generate
```

### Step 8: Run Migrations
```bash
php artisan migrate --force
```

---

## Alternative: Railway.app (Easy with GitHub)

### Step 1: Create Railway Account
1. Go to [Railway.app](https://railway.app)
2. Sign up with GitHub

### Step 2: Deploy
1. Click "New Project" → "Deploy from GitHub repo"
2. Select: `stephenchad/ism-ministers-prayer-network`

### Step 3: Add Database
1. Click "New +" → "Database" → "PostgreSQL"
2. Wait for creation

### Step 4: Configure Environment
Add to Railway Variables:
```env
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:YOUR_KEY
DATABASE_URL=postgres://user:pass@host:5432/db
```

### Step 5: Deploy
1. Click "Deploy"

---

## Environment Variables Reference

**Required:**
```env
APP_NAME="ISM Ministers Prayer Network"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com
APP_KEY=base64:xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_db_name
DB_USER=your_db_user
DB_PASSWORD=your_db_password
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

---

## After Deployment

```bash
# Clear cache
php artisan config:clear
php artisan cache:clear
php artisan route:clear

# Set permissions
chmod -R 755 storage bootstrap/cache
```

---

## Troubleshooting

| Error | Solution |
|-------|----------|
| "No input file specified" | Set public/ as document root |
| Database connection error | Check DB credentials in .env |
| 500 Internal Server Error | Check storage/logs/laravel.log |
| Composer memory error | Use `--no-dev` flag |

---

## Quick Deploy Commands

```bash
# Install dependencies
composer install --no-dev --optimize-autoloader

# Generate app key
php artisan key:generate

# Run migrations
php artisan migrate --force

# Clear cache
php artisan config:cache
php artisan route:cache
```

---

**Repository:** https://github.com/stephenchad/ism-ministers-prayer-network
