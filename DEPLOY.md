# Deployment Guide for ISM Ministers Prayer Network

## AWS Free Tier Setup (12 Months Free)

### Step 1: Create AWS Account

1. Go to [aws.amazon.com](https://aws.amazon.com)
2. Click **"Create an AWS Account"**
3. Fill in your details
4. Add payment method (required for verification, won't charge)
5. Complete verification

---

### Step 2: Create EC2 Instance (Free Tier Eligible)

1. Login to [AWS Console](https://console.aws.amazon.com)
2. Search for **"EC2"** in the search bar
3. Click **"Launch Instance"**
4. Configure:
   - **Name**: `ism-prayer-network`
   - **Amazon Machine Image (AMI)**: `Ubuntu Server 22.04 LTS`
   - **Instance Type**: `t2.micro` or `t3.micro` (FREE TIER ELIGIBLE)
   - **Key Pair**: Create new key pair → Download `.pem` file
   - **Security Group**: Create new
     - Add rule: SSH (port 22) - Your IP
     - Add rule: HTTP (port 80) - Anywhere
     - Add rule: HTTPS (port 443) - Anywhere
5. Click **"Launch Instance"**

---

### Step 3: Connect to Your Server

1. Wait for instance to start (Status: Running)
2. Copy the **Public IPv4 address**
3. Open Terminal (Mac/Linux) or PowerShell (Windows):
   ```bash
   ssh -i /path/to/your-key.pem ubuntu@your-public-ip
   ```

---

### Step 4: Install Laravel Stack

Run these commands on your server:

```bash
# Update server
sudo apt update && sudo apt upgrade -y

# Install Nginx
sudo apt install nginx -y

# Install PHP 8.2 and extensions
sudo apt install software-properties-common -y
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update
sudo apt install php8.2 php8.2-fpm php8.2-mbstring php8.2-xml php8.2-curl php8.2-pgsql php8.2-redis php8.2-gd php8.2-tokenizer php8.2-intl -y

# Install PostgreSQL
sudo apt install postgresql postgresql-contrib -y

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Install Git
sudo apt install git -y
```

---

### Step 5: Deploy Laravel Application

```bash
# Navigate to web directory
cd /var/www

# Clone your repository
sudo git clone https://github.com/stephenchad/ism-ministers-prayer-network.git
cd ism-ministers-prayer-network

# Install dependencies
sudo composer install --no-interaction --prefer-dist --optimize-autoloader

# Create .env file
sudo cp .env.example .env

# Generate app key
sudo php artisan key:generate

# Configure .env with PostgreSQL settings
sudo nano .env
```

**Edit .env:**
```env
APP_NAME="ISM Ministers Prayer Network"
APP_ENV=production
APP_DEBUG=false
APP_KEY= (already generated)

DB_CONNECTION=pgsql
DB_HOST=localhost
DB_PORT=5432
DB_DATABASE=postgres
DB_USER=postgres
DB_PASSWORD= (leave empty or set password)
```

```bash
# Set permissions
sudo chown -R www-data:www-data /var/www/ism-ministers-prayer-network
sudo chmod -R 755 /var/www/ism-ministers-prayer-network/storage /var/www/ism-ministers-prayer-network/bootstrap/cache

# Run database migrations
sudo php artisan migrate --force

# Clear caches
sudo php artisan config:cache
sudo php artisan route:cache
```

---

### Step 6: Configure Nginx

```bash
sudo nano /etc/nginx/sites-available/ism-prayer
```

Add this configuration:
```nginx
server {
    listen 80;
    server_name your-domain.com;  # Or your AWS public IP
    root /var/www/ism-ministers-prayer-network/public;
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
# Enable the site
sudo ln -s /etc/nginx/sites-available/ism-prayer /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx

# Remove default site
sudo rm /etc/nginx/sites-enabled/default
```

---

### Step 7: Visit Your Site

1. Copy your AWS public IP
2. Open browser
3. Go to `http://your-public-ip`

---

## Troubleshooting

### 500 Error
```bash
# Check Nginx error logs
sudo tail -f /var/log/nginx/error.log

# Check Laravel logs
sudo tail -f /var/www/ism-ministers-prayer-network/storage/logs/laravel.log
```

### Permission Issues
```bash
sudo chown -R www-data:www-data /var/www/ism-ministers-prayer-network
sudo chmod -R 755 /var/www/ism-ministers-prayer-network/storage /var/www/ism-ministers-prayer-network/bootstrap/cache
```

### Database Connection Failed
```bash
# Check PostgreSQL status
sudo systemctl status postgresql

# Connect to PostgreSQL
sudo -u postgres psql

# Create database
CREATE DATABASE ism_prayer_db;
```

---

## Important Notes

- **AWS Free Tier**: t2.micro/t3.micro is free for 12 months (750 hours/month)
- After 12 months, ~$10/month
- Don't forget to stop the instance when not in use!
