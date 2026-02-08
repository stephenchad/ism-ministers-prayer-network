# Safe cPanel Deployment Instructions

## Files Removed for Safety:
- `vendor/` directory (will be regenerated)
- `Archive.zip` files
- `public/check_directory.php`
- `public/test_upload.php`
- `.env` (replaced with `.env.production`)
- `storage/logs/` (will be recreated)
- `.phpunit.result.cache`

## Deployment Steps:

### 1. Upload Files
- Upload all files from this clean directory to your cPanel public_html folder
- Make sure to upload the Laravel project to the root, not inside a subdirectory

### 2. Configure Environment
- Rename `.env.production` to `.env`
- Update the following values in `.env`:
  - `APP_URL` - Your domain URL
  - `DB_*` - Your cPanel database credentials
  - `MAIL_*` - Your email settings
  - `GOOGLE_*` - Your Google OAuth credentials (if using social login)

### 3. Generate Application Key
Run this command in cPanel Terminal or via SSH:
```bash
php artisan key:generate
```

### 4. Install Dependencies
Run this command in cPanel Terminal:
```bash
composer install --optimize-autoloader --no-dev
```

### 5. Set Permissions
```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

### 6. Create Storage Link
```bash
php artisan storage:link
```

### 7. Run Migrations
```bash
php artisan migrate --force
```

### 8. Clear Caches
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Security Fixes Applied:
- ✅ Fixed hardcoded credentials
- ✅ Added CSRF protection to forms
- ✅ Secured session configuration
- ✅ Fixed critical code injection vulnerability
- ✅ Improved SQL injection prevention

## Important Notes:
- The `public` folder contents should be in your domain's public_html root
- All other Laravel files should be one level up from public_html
- Make sure your cPanel PHP version is compatible with Laravel requirements
- **HTTPS is recommended** for secure cookie transmission
- Test the application thoroughly after deployment
- Review SECURITY_FIXES.md for detailed security information

## Troubleshooting:
- If you get permission errors, check file permissions
- If database connection fails, verify your .env database settings
- If images don't load, ensure the storage link was created successfully
- If CSRF errors occur, ensure forms include @csrf directive