# Deployment Guide

## 🚂 Deploy to Railway (Recommended)

### Step 1: Create Account
1. Go to [Railway.app](https://railway.app)
2. Sign up with **GitHub**

### Step 2: Deploy
1. Go to [Railway Dashboard](https://railway.app/dashboard)
2. Click **"New Project"**
3. Select **"Deploy from GitHub repo"**
4. Search for: `stephenchad/ism-ministers-prayer-network`
5. Click **"Deploy"**

### Step 3: Add PostgreSQL
1. In your project dashboard, click **"New +"**
2. Select **"Database"** → **"PostgreSQL"**
3. Wait for creation (~2 minutes)
4. Click **"Connect"** → **"Variables"**
5. Copy the `DATABASE_URL`

### Step 4: Configure Environment
1. Go to your project → **"Variables"** tab
2. Add these variables:
   ```env
   APP_NAME=ISM Ministers Prayer Network
   APP_ENV=production
   APP_DEBUG=false
   APP_KEY= # Click "Add" then "Generate" button
   APP_URL= # Your Railway URL (shown after deploy)
   DB_CONNECTION=pgsql
   DATABASE_URL= # Already added from PostgreSQL
   ```

### Step 5: Deploy
1. Go to **"Deployments"** tab
2. Click **"Deploy Now"**

### Step 6: Run Migrations
1. Go to **"Networking"** → **"Shell"**
2. Run:
   ```bash
   php artisan migrate --force
   ```

---

## 🔧 Environment Variables

**Required:**
```
APP_NAME=ISM Ministers Prayer Network
APP_ENV=production
APP_DEBUG=false
APP_KEY= (Generate in Railway dashboard)
APP_URL= (Your Railway URL)
DB_CONNECTION=pgsql
DATABASE_URL= (From PostgreSQL)
```

**Optional:**
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME=ISM Prayer Network

GOOGLE_CLIENT_ID=xxx
GOOGLE_CLIENT_SECRET=xxx

FACEBOOK_CLIENT_ID=xxx
FACEBOOK_CLIENT_SECRET=xxx
```

---

## ✅ After Deployment

In Railway Shell:
```bash
php artisan config:cache
php artisan route:cache
chmod -R 755 storage bootstrap/cache
```

---

## 🔍 Troubleshooting

| Error | Solution |
|-------|----------|
| Database connection failed | Check DATABASE_URL format |
| APP_KEY missing | Generate in Variables tab |
| 500 Error | Check logs in Railway dashboard |
| Static assets not loading | Run `php artisan route:cache` |

---

## 📝 Quick Commands (Railway Shell)

```bash
# View logs
railway logs

# Open shell
railway run bash

# Restart
railway up
```

---

**Repository:** https://github.com/stephenchad/ism-ministers-prayer-network
