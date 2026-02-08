# Quick Start Guide - Commerce Integration

## Immediate Implementation Steps

### Step 1: Install Dependencies (2 minutes)

```bash
composer require firebase/php-jwt
```

### Step 2: Configure Environment (3 minutes)

Add to `.env`:

```env
COMMERCE_API_URL=https://commerce-api.deptb.internal
COMMERCE_API_KEY=your-api-key-here
COMMERCE_API_SECRET=your-api-secret-here
COMMERCE_JWT_ISSUER=department-a
COMMERCE_JWT_AUDIENCE=department-b
COMMERCE_JWT_TTL=3600
```

### Step 3: Run Migrations (1 minute)

```bash
php artisan migrate
```

### Step 4: Clear Caches (1 minute)

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### Step 5: Test API Connection (2 minutes)

```bash
php artisan tinker
```

Then in tinker:
```php
$api = app(\App\Services\CommerceApiClient::class);
$response = $api->getBooks();
dd($response);
```

If you see books data, you're ready!

### Step 6: Add Navigation Link (2 minutes)

Add to your main navigation (likely in `resources/views/front/layouts/app.blade.php` or similar):

```blade
<li><a href="{{ route('books.index') }}">Books</a></li>
```

### Step 7: Test User Flow (5 minutes)

1. Login as a user
2. Navigate to `/books`
3. Click on a book
4. Click "Buy Now"
5. Complete test payment in modal
6. Verify redirect to "My Books"
7. Test download

---

## Files Summary

### NEW Files Created:
```
app/
├── Http/Controllers/
│   ├── BookController.php
│   ├── CheckoutController.php
│   └── DownloadController.php
├── Models/
│   └── BookOrder.php
└── Services/
    └── CommerceApiClient.php

resources/views/front/books/
├── index.blade.php
├── show.blade.php
└── my-books.blade.php

database/migrations/
└── 2026_02_07_000000_create_book_orders_table.php
```

### MODIFIED Files:
```
.env.example (added commerce config)
config/services.php (added commerce config)
routes/web.php (added commerce routes)
```

---

## Key Routes

| Route | Purpose |
|-------|---------|
| `GET /books` | Browse books |
| `GET /books/{id}` | Book details |
| `GET /books/my-books` | User's library |
| `POST /commerce/checkout` | Initiate purchase |
| `GET /commerce/download/{orderId}` | Download book |

---

## Security Features Implemented

✅ JWT machine-to-machine authentication  
✅ HMAC-SHA256 request signing  
✅ Webhook signature verification  
✅ Download proxy (hides Dept B URLs)  
✅ Order ownership verification  
✅ Session validation  
✅ Comprehensive error logging  
✅ Retry logic with exponential backoff  

---

## Troubleshooting

### "Class 'Firebase\JWT\JWT' not found"
```bash
composer require firebase/php-jwt
composer dump-autoload
```

### "Connection refused"
- Check `COMMERCE_API_URL` in `.env`
- Verify network access to Dept B
- Check firewall rules

### "Invalid signature"
- Verify `COMMERCE_API_SECRET` matches Dept B
- Check system time is synchronized
- Ensure no extra whitespace in `.env` values

### Modal doesn't open
- Check browser console for JavaScript errors
- Verify Bootstrap is loaded
- Check CSRF token is present

### Downloads fail
- Check `max_execution_time` in `php.ini`
- Verify `memory_limit` is sufficient
- Check disk space

---

## Next Steps

1. **Customize Views**: Update Blade templates to match your design
2. **Add Navigation**: Link to books from homepage/menu
3. **Configure Webhooks**: Set webhook URL in Dept B admin
4. **Set Up Monitoring**: Configure alerts for API errors
5. **Test Edge Cases**: Failed payments, timeouts, etc.
6. **Add Analytics**: Track purchases, popular books
7. **Optimize Performance**: Add caching where appropriate

---

## Support Resources

- **Full Documentation**: See `COMMERCE_IMPLEMENTATION_SUMMARY.md`
- **Integration Guide**: See `COMMERCE_INTEGRATION_GUIDE.md`
- **Logs**: `storage/logs/laravel.log`

---

## Production Checklist

Before going live:

- [ ] Production API credentials configured
- [ ] SSL/TLS enabled
- [ ] Webhook endpoint configured in Dept B
- [ ] Test complete purchase flow
- [ ] Test download with large files
- [ ] Verify error handling
- [ ] Set up monitoring/alerts
- [ ] Configure log rotation
- [ ] Test on staging environment
- [ ] Document incident response procedures

---

## Estimated Total Time: 15-20 minutes

You now have a fully functional, secure e-commerce integration!
