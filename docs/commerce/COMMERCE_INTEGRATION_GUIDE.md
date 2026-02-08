# Commerce Integration Implementation Guide

## Overview
This document describes the internal e-commerce integration between Department A (this Laravel website) and Department B (Commerce API).

## Installation Steps

### 1. Install JWT Library

```bash
composer require firebase/php-jwt
```

### 2. Run Migrations

```bash
php artisan migrate
```

### 3. Configure Environment Variables

Add to your `.env` file:

```env
COMMERCE_API_URL=https://commerce-api.deptb.internal
COMMERCE_API_KEY=your-api-key-here
COMMERCE_API_SECRET=your-api-secret-here
COMMERCE_JWT_ISSUER=department-a
COMMERCE_JWT_AUDIENCE=department-b
COMMERCE_JWT_TTL=3600
```

### 4. Clear Configuration Cache

```bash
php artisan config:clear
php artisan cache:clear
```

### 5. Register Service Provider (if needed)

The `CommerceApiClient` service is automatically resolved via dependency injection. No additional registration required.

## Architecture

### Data Flow

1. **Book Browsing**: User → BookController → CommerceApiClient → Dept B API
2. **Checkout**: User → CheckoutController → CommerceApiClient → Dept B API → Embedded iframe
3. **Payment**: User completes payment in iframe (stays on Dept A site)
4. **Verification**: Dept A polls Dept B API for order status
5. **Download**: User → DownloadController → CommerceApiClient → Dept B API → Proxied file

### Security Layers

1. **JWT Authentication**: Machine-to-machine auth with time-limited tokens
2. **HMAC Signatures**: Every request signed with SHA-256 HMAC
3. **Download Proxy**: Files streamed through Dept A, never exposing Dept B URLs
4. **Session Validation**: Order ownership verified before downloads
5. **Webhook Verification**: Incoming webhooks validated via HMAC

## Files Added

### Controllers
- `app/Http/Controllers/BookController.php` - Book browsing and library
- `app/Http/Controllers/CheckoutController.php` - Checkout and webhooks
- `app/Http/Controllers/DownloadController.php` - Secure download proxy

### Services
- `app/Services/CommerceApiClient.php` - Centralized API client with JWT + HMAC

### Models
- `app/Models/BookOrder.php` - Local order reference cache

### Views
- `resources/views/front/books/index.blade.php` - Book listing
- `resources/views/front/books/show.blade.php` - Book details with checkout
- `resources/views/front/books/my-books.blade.php` - User's purchased books

### Migrations
- `database/migrations/2026_02_07_000000_create_book_orders_table.php`

### Configuration
- `config/services.php` - Commerce API configuration added

### Routes
- Added to `routes/web.php`:
  - `/books` - Book listing
  - `/books/{id}` - Book details
  - `/books/my-books` - User's library
  - `/commerce/checkout` - Checkout initiation
  - `/commerce/download/{orderId}` - Secure download
  - `/commerce/webhook` - Webhook receiver

## Usage

### For Users

1. Browse books at `/books`
2. Click "Buy Now" on any book
3. Complete payment in embedded modal (never leaves site)
4. Access purchased books at `/books/my-books`
5. Download books securely

### For Developers

#### Get Books
```php
$commerceApi = app(CommerceApiClient::class);
$response = $commerceApi->getBooks(['category' => 'spiritual']);
```

#### Create Checkout
```php
$response = $commerceApi->createCheckout($bookId, $userId, $metadata);
```

#### Get Order Status
```php
$response = $commerceApi->getOrder($orderId);
```

#### Get Download URL
```php
$response = $commerceApi->getDownloadUrl($orderId);
```

## Security Considerations

### Why Dept A Cannot Manipulate Prices

1. **No Price Storage**: Dept A never stores prices locally
2. **API Authority**: All prices fetched from Dept B API in real-time
3. **Checkout Validation**: Dept B validates all checkout requests
4. **Payment Processing**: Dept B handles all payment logic
5. **HMAC Signatures**: Requests cannot be tampered with

### JWT + HMAC Protection

```
Request Flow:
1. Generate JWT with expiry
2. Create HMAC signature: HMAC-SHA256(method + path + timestamp + body, secret)
3. Send request with headers:
   - Authorization: Bearer {jwt}
   - X-Signature: {hmac}
   - X-Timestamp: {unix_timestamp}
4. Dept B verifies both JWT and HMAC
5. Dept B checks timestamp (prevents replay attacks)
```

### Download Security

1. User requests download
2. Dept A verifies user owns the order
3. Dept A requests time-limited URL from Dept B
4. Dept A streams file through own server
5. User never sees Dept B's file URL

## Webhook Configuration

Department B should send webhooks to:
```
POST https://your-domain.com/commerce/webhook
```

With headers:
```
X-Signature: {hmac_signature}
X-Timestamp: {unix_timestamp}
Content-Type: application/json
```

Payload example:
```json
{
  "event": "order.completed",
  "order_id": "ord_123456",
  "user_id": 42,
  "book_id": "book_789",
  "amount": 29.99
}
```

## Testing

### Test Checkout Flow

1. Ensure Dept B API is accessible
2. Configure valid credentials in `.env`
3. Login as a user
4. Navigate to `/books`
5. Click "Buy Now" on any book
6. Complete test payment in iframe
7. Verify redirect to "My Books"
8. Test download functionality

### Test API Client

```php
php artisan tinker

$api = app(\App\Services\CommerceApiClient::class);
$books = $api->getBooks();
dd($books);
```

## Monitoring

### Logs

All API interactions are logged:
- `storage/logs/laravel.log`

Search for:
- "Commerce API Request"
- "Commerce API Success"
- "Commerce API Error"
- "Commerce webhook received"

### Key Metrics to Monitor

1. API response times
2. Failed checkout attempts
3. Download success rate
4. Webhook delivery failures
5. JWT token refresh rate

## Troubleshooting

### "Connection error"
- Check `COMMERCE_API_URL` is correct
- Verify network connectivity to Dept B
- Check firewall rules

### "Invalid signature"
- Verify `COMMERCE_API_SECRET` matches Dept B
- Check system time synchronization
- Ensure HMAC algorithm matches (SHA-256)

### "Order not found"
- Verify order belongs to authenticated user
- Check order status in Dept B
- Review session data

### Downloads fail
- Check file size limits (php.ini)
- Verify timeout settings
- Check disk space

## Production Checklist

- [ ] Configure production API credentials
- [ ] Set up SSL/TLS for all connections
- [ ] Configure webhook endpoint in Dept B
- [ ] Test webhook signature verification
- [ ] Set up monitoring and alerts
- [ ] Configure rate limiting
- [ ] Test download proxy with large files
- [ ] Verify JWT token caching
- [ ] Set up log rotation
- [ ] Test error handling scenarios
- [ ] Configure backup API credentials (if available)
- [ ] Document incident response procedures

## Support

For issues with:
- **Department A integration**: Contact your development team
- **Department B API**: Contact Department B support
- **Payment processing**: Contact Department B payment team
