# Deployment Guide for ISM Ministers Prayer Network

## Render.com Free Tier Deployment

### Prerequisites
- GitHub account with repository: https://github.com/stephenchad/ism-ministers-prayer-network
- Free Render.com account

### Step 1: Create Render Account

1. Go to [render.com](https://render.com) and sign up with GitHub
2. Verify your email

### Step 2: Create New Web Service

1. Click **"New +"** → **"Web Service"**
2. Connect your GitHub repository
3. Configure:
   - **Name**: `ism-prayer-network`
   - **Environment**: `PHP`
   - **Build Command**: (leave empty - uses render.yaml)
   - **Start Command**: (leave empty - uses render.yaml)
4. Click **"Create Web Service"**

### Step 3: Add PostgreSQL Database

1. Click **"New +"** → **"PostgreSQL"**
2. Configure:
   - **Name**: `ism-prayer-db`
   - **Plan**: `Free`
   - **Region**: `Ohio` (or nearest to you)
3. Click **"Create Database"**

### Step 4: Connect Database to Web Service

1. Go to your **Web Service** → **"Environment"** tab
2. Add these variables (delete duplicates):
   ```
   APP_NAME=ISM Ministers Prayer Network
   APP_ENV=production
   APP_DEBUG=false
   APP_KEY= (click "Generate" button)
   ```
3. For database connection, Render auto-links them. Add:
   ```
   DB_CONNECTION=pgsql
   DB_HOST= (from PostgreSQL service - Internal URL)
   DB_PORT=5432
   DB_DATABASE= (from PostgreSQL service)
   DB_USER= (from PostgreSQL service)
   DB_PASSWORD= (from PostgreSQL service)
   ```

### Step 5: Deploy

1. Go to your **Web Service**
2. Click **"Deploy"** (manual) or wait for auto-deploy
3. Watch **"Logs"** for progress

### Step 6: Run Database Migration

1. Click **"Shell"** in your web service
2. Run:
   ```bash
   php artisan migrate --force
   ```

### Step 7: Visit Your App

1. Click the **URL** shown in your web service (e.g., `https://ism-prayer-network.onrender.com`)

---

## Troubleshooting

### "Please provide a valid cache path"
Fixed by the `mkdir` commands in render.yaml build command.

### Database connection failed
Ensure `DB_*` variables match your PostgreSQL service's Internal URL.

### 500 Error
Check logs in Render dashboard. Common issues:
- Missing APP_KEY
- Database not migrated
- Storage permissions

---

## Local Development (XAMPP)

```bash
cd /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
php artisan serve
```

---

## Useful Commands

```bash
# Clear all caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Recreate storage links
php artisan storage:link

# Seed database
php artisan db:seed
```
