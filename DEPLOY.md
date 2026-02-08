# Deployment Guide for ISM Ministers Prayer Network

## Free Hosting Options

### Option 1: InfinityFree (Recommended)

**Features:**
- ✅ Free PHP 8.x hosting
- ✅ Free MySQL database
- ✅ Unlimited bandwidth
- ✅ 5GB disk space
- ✅ Free SSL
- ✅ No ads

**Setup:**

1. **Create Account**
   - Go to [infinityfree.net](https://infinityfree.net)
   - Sign up for free account
   - Verify email

2. **Create Website**
   - Click **"Get Free Hosting"**
   - Enter your desired subdomain: `yoursite.epizy.com`
   - Complete registration

3. **Upload Files**
   - Go to **"File Manager"** in InfinityFree
   - Upload all project files to `/htdocs` folder
   - Important: Upload `.env` file with your settings

4. **Create Database**
   - Go to **"MySQL Databases"**
   - Create new database (name, username, password)
   - Note the credentials

5. **Import Database**
   - Go to **"phpMyAdmin"**
   - Import your local database SQL file

6. **Configure .env**
   ```env
   APP_NAME=ISM Ministers Prayer Network
   APP_ENV=production
   APP_DEBUG=false
   APP_KEY= (generate locally: php artisan key:generate)
   APP_URL=https://yoursite.epizy.com

   DB_CONNECTION=mysql
   DB_HOST=localhost
   DB_PORT=3306
   DB_DATABASE=your_db_name
   DB_USERNAME=your_db_user
   DB_PASSWORD=your_db_password
   ```

7. **Visit Your Site**
   - Go to `https://yoursite.epizy.com`

---

### Option 2: HelioHost

**Features:**
- ✅ Free PHP hosting
- ✅ Free MySQL database
- ✅ cPanel access
- ✅ Good performance

**Setup:**

1. **Request Hosting**
   - Go to [heliohost.org](https://heliohost.org)
   - Click **"Request Hosting"**
   - Choose **"Tommy"** (free tier)
   - Fill in your details

2. **Wait for Activation**
   - Usually takes a few hours
   - You'll receive email with login details

3. **Upload via File Manager**
   - Use the provided URL to access cPanel
   - Upload files via File Manager
   - Import database via phpMyAdmin

---

### Option 3: 000WebHost

**Features:**
- ✅ Free PHP hosting
- ✅ Free MySQL database
- ✅ Easy 1-click install

**Setup:**

1. **Create Account**
   - Go to [000webhost.com](https://000webhost.com)
   - Sign up for free

2. **Create Site**
   - Click **"Create New Site"**
   - Upload files or use website builder

3. **Database**
   - Go to **"Tools"** → **"Database"**
   - Create MySQL database

**Note:** Free tier has no HTTPS and displays ads.

---

## Local Development (XAMPP)

```bash
cd /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network

# Install dependencies
composer install

# Setup environment
cp .env.example .env
php artisan key:generate

# Setup database
php artisan migrate:fresh --seed

# Start server
php artisan serve
```

---

## Moving from Local to Live

### Step 1: Export Local Database
1. Go to phpMyAdmin (localhost)
2. Select your database
3. Click **"Export"** → **"Go"**
4. Save the `.sql` file

### Step 2: Upload Files
1. Connect via FTP/File Manager
2. Upload all files EXCEPT `/vendor` and `/node_modules`
3. Upload `.env` file with live settings

### Step 3: Import Database
1. Go to live phpMyAdmin
2. Create new database
3. Click **"Import"**
4. Upload your local `.sql` file

### Step 4: Install Dependencies on Server
If you have SSH access:
```bash
composer install --no-dev --optimize-autoloader
```

---

## Troubleshooting

### "500 Internal Server Error"
- Check `.env` file exists and has correct credentials
- Run `php artisan config:clear`
- Check file permissions: `chmod -R 755 storage bootstrap/cache`

### Database Connection Failed
- Verify `DB_*` variables in `.env`
- Check database user has permissions
- Ensure database exists

### Blank White Page
- Enable debug: `APP_DEBUG=true` temporarily
- Check PHP error logs
