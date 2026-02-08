# Deployment Guide for ISM Ministers Prayer Network

## Railway Deployment

### 1. Setup on Railway

1. Create a new project on [Railway](https://railway.app)
2. Connect your GitHub repository
3. Add a PostgreSQL database
4. Add Environment Variables:

```
APP_NAME="ISM Ministers Prayer Network"
APP_ENV=production
APP_KEY=base64:... (generate using "Generate" button)
APP_DEBUG=false
APP_URL=https://your-app.railway.app

DB_CONNECTION=pgsql
DB_HOST=/cloudsql/...
DB_PORT=5432
DB_DATABASE=...
DB_USER=...
DB_PASSWORD=...

CACHE_DRIVER=file
FILESYSTEM_DISK=local
```

### 2. Deploy

1. Click "Deploy Now" on Railway dashboard
2. The Procfile will automatically:
   - Create storage directories
   - Set proper permissions
   - Start the PHP server

### 3. Database Setup

In Railway Shell, run:
```bash
php artisan migrate --force
```

### 4. Optional: Cache Configuration

After deployment, in Railway Shell:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## Local Development (XAMPP)

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
php artisan serve
```

---

## Troubleshooting

### "Please provide a valid cache path"
The storage directories need to exist. Procfile now handles this automatically.

### PSR-4 Namespace Error
Controllers are in `App\Http\Controllers\Admin` (capital A). Make sure all controllers use this namespace.

### Missing Environment Variables
Ensure all variables are set in Railway dashboard, especially `APP_KEY`.
