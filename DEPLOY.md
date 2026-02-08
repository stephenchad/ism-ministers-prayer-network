# Deployment Guide for ISM Ministers Prayer Network

## Option 1: Vercel (Free Tier)

### Prerequisites
- Vercel account (sign up with GitHub)
- GitHub repository: https://github.com/stephenchad/ism-ministers-prayer-network

### ⚠️ Limitations of Vercel with Laravel
- **No persistent file storage** (uploads won't persist)
- **No PostgreSQL database** (need external database)
- **No cron jobs**
- Best for **static/demo sites**

### Step 1: Create Vercel Account
1. Go to [vercel.com](https://vercel.com)
2. Sign up with **GitHub**
3. Verify email

### Step 2: Import Project
1. Click **"Add New..."** → **"Project"**
2. Import your GitHub repo
3. Configure:
   - **Framework Preset**: `Other`
   - **Build Command**: (leave empty)
   - **Output Directory**: `public`
4. Click **"Deploy"**

### Step 3: Add Environment Variables
1. Go to **Settings** → **Environment Variables**
2. Add:
   ```
   APP_NAME=ISM Ministers Prayer Network
   APP_ENV=production
   APP_DEBUG=false
   APP_KEY= (run `php artisan key:generate` locally, paste here)
   DB_CONNECTION=pgsql
   ```

### ⚠️ Important: Database Required
Vercel doesn't provide databases. Use:
- **Neon** (free PostgreSQL)
- **Supabase** (free PostgreSQL)
- **Railway** (PostgreSQL - had free tier)

---

## Option 2: Coolify (Self-Hosted Free)

Coolify is open-source, you host it on your own server.

### Prerequisites
- VPS server ($4-10/month) from DigitalOcean, Hetzner, Linode
- SSH access to server

### Installation
```bash
# SSH into your server
ssh root@your-server-ip

# Install Coolify
bash <(curl -fsSL get.coolify.io)
```

### Setup
1. Access Coolify at `https://your-server-ip`
2. Create admin account
3. Click **"Add New Project"**
4. Import from GitHub
5. Configure:
   - **Type**: Laravel (PHP)
   - **Database**: PostgreSQL
   - **Domains**: your-domain.com

---

## Option 3: DigitalOcean VPS ($4/month)

### Step 1: Create Droplet
1. Go to [digitalocean.com](https://digitalocean.com)
2. Create **"Droplet"**
3. Choose:
   - **Image**: Ubuntu 22.04 LTS
   - **Size**: Basic ($4/month - 1GB RAM)
   - **Region**: Near your users

### Step 2: Connect via SSH
```bash
ssh root@your-droplet-ip
```

### Step 3: Install Laravel Stack
```bash
# Update
apt update && apt upgrade -y

# Install Nginx
apt install nginx -y

# Install PHP 8.2
apt install software-properties-common -y
add-apt-repository ppa:ondrej/php -y
apt update
apt install php8.2 php8.2-fpm php8.2-mbstring php8.2-xml php8.2-curl php8.2-pgsql php8.2-redis -y

# Install PostgreSQL
apt install postgresql postgresql-contrib -y

# Install Composer
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

# Install Git
apt install git -y
```

### Step 4: Configure Laravel
```bash
# Create directory
mkdir -p /var/www/ism-prayer
cd /var/www/ism-prayer

# Clone repo
git clone https://github.com/stephenchad/ism-ministers-prayer-network.git .

# Install dependencies
composer install --no-interaction --prefer-dist --optimize-autoloader

# Copy env file
cp .env.example .env
php artisan key:generate

# Configure .env for PostgreSQL
nano .env
# Update DB_* variables

# Run migrations
php artisan migrate --force

# Set permissions
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data /var/www/ism-prayer
```

### Step 5: Configure Nginx
```bash
nano /etc/nginx/sites-available/ism-prayer
```

Add configuration:
```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /var/www/ism-prayer/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.2-fpm.sock;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

```bash
# Enable site
ln -s /etc/nginx/sites-available/ism-prayer /etc/nginx/sites-enabled/
nginx -t
systemctl reload nginx

# Setup SSL (optional)
apt install certbot python3-certbot-nginx
certbot --nginx -d your-domain.com
```

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
