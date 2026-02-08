# E-Commerce Integration Implementation Summary

## SECTION 1 — INTEGRATION ARCHITECTURE

### Overview
Department A's existing Laravel website now includes digital book purchasing capabilities by integrating with Department B's Commerce API. Users never leave Department A's website during the entire purchase flow.

### Component Architecture

```
┌─────────────────────────────────────────────────────────────────┐
│                    DEPARTMENT A (Laravel Website)                │
│                                                                   │
│  NEW COMPONENTS ADDED:                                           │
│  ┌────────────────────────────────────────────────────────────┐ │
│  │ Controllers:                                                │ │
│  │  - BookController (browse, show, my-books)                 │ │
│  │  - CheckoutController (create, status, webhook)            │ │
│  │  - DownloadController (secure proxy)                       │ │
│  └────────────────────────────────────────────────────────────┘ │
│                                                                   │
│  ┌────────────────────────────────────────────────────────────┐ │
│  │ Services:                                                   │ │
│  │  - CommerceApiClient (JWT + HMAC authentication)           │ │
│  └────────────────────────────────────────────────────────────┘ │
│                                                                   │
│  ┌────────────────────────────────────────────────────────────┐ │
│  │ Views:                                                      │ │
│  │  - books/index.blade.php (listing)                         │ │
│  │  - books/show.blade.php (details + checkout modal)         │ │
│  │  - books/my-books.blade.php (user library)                 │ │
│  └────────────────────────────────────────────────────────────┘ │
│                                                                   │
│  ┌────────────────────────────────────────────────────────────┐ │
│  │ Routes:                                                     │ │
│  │  - GET  /books                                             │ │
│  │  - GET  /books/{id}                                        │ │
│  │  - GET  /books/my-books                                    │ │
│  │  - POST /commerce/checkout                                 │ │
│  │  - GET  /commerce/download/{orderId}                       │ │
│  │  - POST /commerce/webhook                                  │ │
│  └────────────────────────────────────────────────────────────┘ │
└─────────────────────────────────────────────────────────────────┘
                              │
                              │ Secure API Calls
                              │ (JWT + HMAC-SHA256)
                              ▼
┌─────────────────────────────────────────────────────────────────┐
│                 DEPARTMENT B (Commerce API)                      │
│                                                                   │
│  - Books catalog & pricing                                       │
│  - Checkout session creation                                     │
│  - Payment processing                                            │
│  - Order management                                              │
│  - Secure file delivery                                          │
└─────────────────────────────────────────────────────────────────┘
```

### Data Flow

**Book Browsing:**
```
User → BookController → CommerceApiClient → Dept B API → Response → Blade View
```

**Checkout:**
```
User clicks "Buy Now" 
  → AJAX to CheckoutController 
  → CommerceApiClient creates checkout session 
  → Dept B returns checkout_url 
  → Embedded in iframe modal 
  → User completes payment (stays on Dept A site)
  → JavaScript polls order status
  → Redirect to My Books on success
```

**Download:**
```
User clicks Download 
  → DownloadController 
  → Verify ownership 
  → CommerceApiClient gets secure URL 
  → Stream file through Dept A 
  → User receives file (never sees Dept B URL)
```

---

## SECTION 2 — DEPARTMENT B API CONTRACT

### Base URL
```
https://commerce-api.deptb.internal
```

### Authentication
Every request requires:
1. **JWT Bearer Token** (machine-to-machine)
2. **HMAC-SHA256 Signature**
3. **Timestamp** (prevents replay attacks)

### Request Headers
```
Authorization: Bearer {jwt_token}
X-Signature: {hmac_signature}
X-Timestamp: {unix_timestamp}
Content-Type: application/json
```

### HMAC Signature Generation
```
message = METHOD + "\n" + PATH + "\n" + TIMESTAMP + "\n" + BODY
signature = HMAC-SHA256(message, API_SECRET)
```

### API Endpoints

#### 1. List Books
```
GET /api/v1/books?category={category}&search={query}

Response:
{
  "books": [
    {
      "id": "book_123",
      "title": "Book Title",
      "author": "Author Name",
      "description": "...",
      "price": 29.99,
      "cover_image": "https://...",
      "details": {...}
    }
  ],
  "pagination": {...}
}
```

#### 2. Get Book Details
```
GET /api/v1/books/{id}

Response:
{
  "id": "book_123",
  "title": "Book Title",
  "author": "Author Name",
  "description": "...",
  "price": 29.99,
  "cover_image": "https://...",
  "details": {...}
}
```

#### 3. Create Checkout Session
```
POST /api/v1/checkout

Body:
{
  "book_id": "book_123",
  "user_id": 42,
  "return_url": "https://dept-a.com/commerce/checkout/return",
  "cancel_url": "https://dept-a.com/commerce/checkout/cancel",
  "webhook_url": "https://dept-a.com/commerce/webhook",
  "metadata": {...}
}

Response:
{
  "session_id": "sess_abc123",
  "order_id": "ord_xyz789",
  "checkout_url": "https://commerce-api.deptb.internal/checkout/sess_abc123",
  "expires_at": "2026-02-07T12:00:00Z"
}
```

#### 4. Get Order Status
```
GET /api/v1/orders/{order_id}

Response:
{
  "order_id": "ord_xyz789",
  "user_id": 42,
  "book_id": "book_123",
  "status": "completed", // pending, completed, failed
  "amount": 29.99,
  "purchased_at": "2026-02-07T11:30:00Z"
}
```

#### 5. Get Download URL
```
GET /api/v1/orders/{order_id}/download

Response:
{
  "download_url": "https://files.deptb.internal/secure/abc123?expires=...",
  "filename": "book-title.pdf",
  "content_type": "application/pdf",
  "expires_at": "2026-02-07T12:00:00Z"
}
```

#### 6. Webhook Events
```
POST {webhook_url}

Headers:
X-Signature: {hmac_signature}
X-Timestamp: {unix_timestamp}

Body:
{
  "event": "order.completed", // or "order.failed"
  "order_id": "ord_xyz789",
  "user_id": 42,
  "book_id": "book_123",
  "amount": 29.99,
  "timestamp": "2026-02-07T11:30:00Z"
}
```

---

## SECTION 3 — DEPARTMENT A IMPLEMENTATION

### Files Created

#### 1. Configuration

**File: `.env.example` (MODIFIED)**
```env
COMMERCE_API_URL=https://commerce-api.deptb.internal
COMMERCE_API_KEY=your-api-key-here
COMMERCE_API_SECRET=your-api-secret-here
COMMERCE_JWT_ISSUER=department-a
COMMERCE_JWT_AUDIENCE=department-b
COMMERCE_JWT_TTL=3600
```

**File: `config/services.php` (MODIFIED)**
Added commerce configuration block with API credentials, JWT settings, timeout, and retry configuration.

#### 2. API Client Service

**File: `app/Services/CommerceApiClient.php` (NEW)**

Key features:
- JWT token generation with caching
- HMAC-SHA256 request signing
- Centralized HTTP client with retry logic
- Methods for all Dept B API endpoints
- Webhook signature verification
- Comprehensive error logging

Methods:
- `getBooks($filters)` - List books
- `getBook($bookId)` - Get book details
- `createCheckout($bookId, $userId, $metadata)` - Create checkout
- `getOrder($orderId)` - Get order status
- `getDownloadUrl($orderId)` - Get secure download URL
- `verifyWebhookSignature($payload, $signature, $timestamp)` - Verify webhooks
- `getUserOrders($userId)` - Get user's purchase history

#### 3. Controllers

**File: `app/Http/Controllers/BookController.php` (NEW)**

Routes:
- `GET /books` → `index()` - List all books
- `GET /books/{id}` → `show($id)` - Show book details
- `GET /books/my-books` → `myBooks()` - User's purchased books

Features:
- Fetches data from Dept B API
- Checks if user already owns books
- Handles API errors gracefully

**File: `app/Http/Controllers/CheckoutController.php` (NEW)**

Routes:
- `POST /commerce/checkout` → `create()` - Initiate checkout
- `GET /commerce/checkout/status` → `status()` - Poll order status
- `GET /commerce/checkout/return` → `returnUrl()` - Success return
- `GET /commerce/checkout/cancel` → `cancelUrl()` - Cancel return
- `POST /commerce/webhook` → `webhook()` - Webhook receiver

Features:
- Creates checkout sessions
- Stores session data for verification
- Polls order status (for JavaScript)
- Verifies webhook signatures
- Handles order completion events

**File: `app/Http/Controllers/DownloadController.php` (NEW)**

Routes:
- `GET /commerce/download/{orderId}` → `download()` - Proxy download
- `GET /commerce/download-link/{orderId}` → `generateLink()` - Get link

Features:
- Verifies user owns the order
- Proxies files from Dept B
- Never exposes Dept B URLs
- Streams large files efficiently
- Sets proper headers for downloads

#### 4. Models

**File: `app/Models/BookOrder.php` (NEW)**

Purpose: Local cache of order references (optional but recommended)

Fields:
- `user_id` - Owner
- `order_id` - Dept B order ID
- `book_id` - Dept B book ID
- `status` - pending, completed, failed
- `amount` - Purchase amount
- `completed_at` - Completion timestamp

#### 5. Migrations

**File: `database/migrations/2026_02_07_000000_create_book_orders_table.php` (NEW)**

Creates `book_orders` table for local order caching.

#### 6. Views

**File: `resources/views/front/books/index.blade.php` (NEW)**

Features:
- Grid layout of available books
- Book covers, titles, authors, prices
- "View Details" buttons
- Link to "My Books"

**File: `resources/views/front/books/show.blade.php` (NEW)**

Features:
- Book details display
- "Buy Now" button
- Checkout modal with embedded iframe
- JavaScript for checkout flow
- Status polling
- Automatic redirect on success

**File: `resources/views/front/books/my-books.blade.php` (NEW)**

Features:
- List of purchased books
- Download buttons
- Purchase dates
- Empty state with CTA

#### 7. Routes

**File: `routes/web.php` (MODIFIED)**

Added route groups:
```php
// Book browsing (auth required)
Route::group(['prefix' => 'books', 'as' => 'books.', 'middleware' => 'auth'], function () {
    Route::get('/', [BookController::class, 'index']);
    Route::get('/my-books', [BookController::class, 'myBooks']);
    Route::get('/{id}', [BookController::class, 'show']);
});

// Commerce operations (auth required)
Route::group(['prefix' => 'commerce', 'as' => 'commerce.', 'middleware' => 'auth'], function () {
    Route::post('/checkout', [CheckoutController::class, 'create']);
    Route::get('/checkout/status', [CheckoutController::class, 'status']);
    Route::get('/checkout/return', [CheckoutController::class, 'returnUrl']);
    Route::get('/checkout/cancel', [CheckoutController::class, 'cancelUrl']);
    Route::get('/download/{orderId}', [DownloadController::class, 'download']);
    Route::get('/download-link/{orderId}', [DownloadController::class, 'generateLink']);
});

// Webhook (no auth - verified via HMAC)
Route::post('/commerce/webhook', [CheckoutController::class, 'webhook']);
```

---

## SECTION 4 — PAYMENT FLOW

### Embedded Checkout Flow

1. **User clicks "Buy Now"**
   - JavaScript sends AJAX request to `/commerce/checkout`
   - Includes book ID and CSRF token

2. **Dept A creates checkout session**
   - `CheckoutController::create()` called
   - Validates book exists via API
   - Calls `CommerceApiClient::createCheckout()`
   - Receives `checkout_url` and `order_id`
   - Stores session data for verification

3. **Modal opens with iframe**
   - JavaScript displays modal
   - Loads `checkout_url` in iframe
   - User sees Dept B payment form
   - User NEVER leaves Dept A website

4. **User completes payment**
   - Payment processed by Dept B
   - User stays in iframe on Dept A site

5. **Status verification**
   - JavaScript polls `/commerce/checkout/status` every 3 seconds
   - Dept A calls `CommerceApiClient::getOrder()`
   - Checks if status changed to "completed"

6. **Success handling**
   - When status = "completed":
     - Stop polling
     - Close modal
     - Redirect to `/books/my-books`
     - Show success message

7. **Optional webhook**
   - Dept B sends webhook to `/commerce/webhook`
   - Dept A verifies HMAC signature
   - Logs event (can trigger notifications)

### Why Users Never Leave Site

- Checkout URL embedded in `<iframe>`
- Modal overlay on Dept A's page
- Dept A's navigation remains visible
- No redirects to external domains
- Seamless user experience

### Payment Security

- Dept B handles all payment processing
- Dept A never touches credit card data
- PCI compliance handled by Dept B
- Dept A only receives order status

---

## SECTION 5 — SECURITY & ENTERPRISE CONTROLS

### 1. Price Manipulation Prevention

**Why Dept A Cannot Manipulate Prices:**

- ✅ No prices stored in Dept A database
- ✅ All prices fetched from Dept B API in real-time
- ✅ Checkout requests validated by Dept B
- ✅ Dept B authoritative for all pricing
- ✅ HMAC signatures prevent request tampering
- ✅ JWT tokens prevent impersonation

**Attack Scenario Prevention:**

❌ **Attempt**: Modify price in checkout request
```json
{
  "book_id": "book_123",
  "price": 0.01  // Attacker tries to set low price
}
```

✅ **Prevention**: 
- Dept A doesn't send price in request
- Dept B looks up price from its own database
- HMAC signature would be invalid if request modified
- JWT ensures request came from authorized Dept A

### 2. JWT + HMAC Protection

**JWT (JSON Web Token):**
```
Purpose: Authenticate Dept A to Dept B
Algorithm: HS256
Payload: {iss, aud, iat, exp, sub}
Cached: Yes (expires 60 seconds before actual expiry)
```

**HMAC (Hash-based Message Authentication Code):**
```
Purpose: Verify request integrity
Algorithm: SHA-256
Input: METHOD + PATH + TIMESTAMP + BODY
Secret: Shared between Dept A and Dept B
```

**Combined Protection:**
1. JWT proves "this request is from Dept A"
2. HMAC proves "this request hasn't been tampered with"
3. Timestamp prevents replay attacks
4. Both must be valid for request to succeed

**Attack Prevention:**

| Attack Type | Prevention |
|-------------|------------|
| Man-in-the-middle | HTTPS + HMAC signature |
| Replay attack | Timestamp validation |
| Request tampering | HMAC signature fails |
| Impersonation | JWT validation fails |
| Token theft | Short TTL + HTTPS only |

### 3. Download Security

**Multi-Layer Protection:**

1. **Authentication**: User must be logged in
2. **Authorization**: Verify order belongs to user
3. **Order Status**: Must be "completed"
4. **Proxying**: File streamed through Dept A
5. **URL Hiding**: Dept B URLs never exposed
6. **Time Limits**: Download URLs expire

**Download Flow:**
```
User → DownloadController
  ↓
Verify user_id matches order.user_id
  ↓
Verify order.status === 'completed'
  ↓
Request secure URL from Dept B
  ↓
Stream file through Dept A
  ↓
User receives file
```

**Why Proxying:**
- Users never see Dept B file URLs
- Prevents URL sharing
- Enables download tracking
- Allows access control enforcement
- Dept B URLs can be short-lived

### 4. Logging & Traceability

**All API calls logged:**
```php
Log::info('Commerce API Request', [
    'method' => $method,
    'endpoint' => $endpoint,
    'timestamp' => $timestamp,
]);
```

**Logged events:**
- API requests (method, endpoint, timestamp)
- API responses (status, success/failure)
- API errors (status, error message, trace)
- Checkout initiations (book_id, user_id)
- Order completions (order_id, user_id)
- Download attempts (order_id, user_id, filename)
- Webhook receipts (event, order_id)
- Unauthorized access attempts

**Log location:**
```
storage/logs/laravel.log
```

**Search patterns:**
```bash
# API requests
grep "Commerce API Request" storage/logs/laravel.log

# Errors
grep "Commerce API Error" storage/logs/laravel.log

# Webhooks
grep "Commerce webhook" storage/logs/laravel.log

# Downloads
grep "Download initiated" storage/logs/laravel.log
```

### 5. Error Handling Strategy

**Graceful Degradation:**

| Scenario | Handling |
|----------|----------|
| API timeout | Retry 3 times, then show error message |
| API unavailable | Show cached data if available, else error |
| Invalid response | Log error, show generic message to user |
| Checkout fails | Close modal, show error, allow retry |
| Download fails | Log error, show retry button |
| Webhook invalid | Return 401, log warning |

**User-Facing Errors:**
- Never expose technical details
- Show actionable messages
- Provide retry options
- Log full details for debugging

**Example:**
```php
// Internal log
Log::error('Commerce API Error', [
    'endpoint' => '/api/v1/books',
    'status' => 500,
    'body' => 'Internal Server Error',
    'trace' => '...'
]);

// User sees
"Unable to load books at this time. Please try again later."
```

### 6. Rate Limiting

**Recommended (not implemented in base code):**

Add to `app/Http/Kernel.php`:
```php
'commerce' => [
    'throttle:60,1', // 60 requests per minute
    'auth',
],
```

Apply to routes:
```php
Route::group(['middleware' => ['auth', 'commerce']], function () {
    // Commerce routes
});
```

### 7. Audit Trail

**BookOrder model provides:**
- Who purchased what
- When purchases occurred
- Order status history
- Amount paid

**Query examples:**
```php
// User's purchase history
BookOrder::where('user_id', $userId)
    ->completed()
    ->orderBy('completed_at', 'desc')
    ->get();

// Recent purchases
BookOrder::completed()
    ->where('completed_at', '>=', now()->subDays(7))
    ->get();

// Failed orders
BookOrder::where('status', 'failed')
    ->with('user')
    ->get();
```

---

## Installation Commands

```bash
# 1. Install JWT library
composer require firebase/php-jwt

# 2. Run migrations
php artisan migrate

# 3. Clear caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# 4. Configure .env (add commerce variables)

# 5. Test API connection
php artisan tinker
>>> $api = app(\App\Services\CommerceApiClient::class);
>>> $api->getBooks();
```

---

## Production Deployment Checklist

- [ ] Install `firebase/php-jwt` via Composer
- [ ] Run migrations
- [ ] Configure production API credentials in `.env`
- [ ] Test API connectivity
- [ ] Configure webhook URL in Dept B
- [ ] Test webhook signature verification
- [ ] Test complete checkout flow
- [ ] Test download proxy with large files
- [ ] Verify JWT token caching
- [ ] Set up monitoring for API errors
- [ ] Configure log rotation
- [ ] Test error scenarios
- [ ] Review security headers
- [ ] Enable HTTPS only
- [ ] Test rate limiting (if implemented)

---

## Summary

This implementation adds complete e-commerce functionality to Department A's existing Laravel website while maintaining security, user experience, and separation of concerns. All business logic, pricing, and payment processing remain in Department B, while Department A provides a seamless user interface that never requires users to leave the site.
