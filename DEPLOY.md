# Deployment Guide

## 🚂 Deploy to Railway.app (Recommended)

### Step 1: Create Account
1. Go to [Railway.app](https://railway.app)
2. Sign up with **GitHub**
3. Install Railway CLI (optional)

### Step 2: Deploy
**Option A: Web Dashboard**
1. Go to [Railway Dashboard](https://railway.app/dashboard)
2. Click **"New Project"**
3. Select **"Deploy from GitHub repo"**
4. Search for: `stephenchad/ism-ministers-prayer-network`
5. Click **"Deploy"**

**Option B: CLI**
```bash
npm i -g @railway/cli
railway login
railway init
railway up
```

### Step 3: Add Database
1. In Railway dashboard, click **"New +"**
2. Select **"Database"** → **"PostgreSQL"**
3. Wait for creation (~2 minutes)
4. Click **"Connect"** → **"Variables"**
5. Copy the `DATABASE_URL`

### Step 4: Configure Environment
1. Go to your project → **"Variables"**
2. Add:
   ```env
   APP_ENV=production
   APP_DEBUG=false
   APP_KEY=base64:xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
   APP_URL=https://your-app.up.railway.app
   DB_CONNECTION=pgsql
   DATABASE_URL=postgres://user:pass@host:5432/dbname
   ```

### Step 5: Generate APP_KEY
1. In Railway terminal:
   ```bash
   php artisan key:generate
   ```

### Step 6: Run Migrations
```bash
php artisan migrate --force
```

### Step 7: Set Permissions
```bash
chmod -R 755 storage bootstrap/cache
```

---

## 🔧 Environment Variables

**Required:**
```env
APP_NAME="ISM Ministers Prayer Network"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app.up.railway.app
APP_KEY=base64:xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
DB_CONNECTION=pgsql
DATABASE_URL=postgres://user:pass@host:5432/dbname
```

**Optional:**
```env
# Email
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=xxx
MAIL_PASSWORD=xxx

# Social Login
GOOGLE_CLIENT_ID=xxx
GOOGLE_CLIENT_SECRET=xxx
FACEBOOK_CLIENT_ID=xxx
FACEBOOK_CLIENT_SECRET=xxx
```

---

## ✅ After Deployment

```bash
php artisan config:cache
php artisan route:cache
```

---

## 🔍 Troubleshooting

| Error | Solution |
|-------|----------|
| Database connection | Check DATABASE_URL format |
| APP_KEY missing | Run `php artisan key:generate` |
| 500 Error | Check logs: `railway logs` |
| Permission denied | `chmod -R 755 storage bootstrap/cache` |

---

## 📝 Quick Commands

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
