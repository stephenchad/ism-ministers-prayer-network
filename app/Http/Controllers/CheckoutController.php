<?php

namespace App\Http\Controllers;

use App\Services\CommerceApiClient;
use App\Services\TestCommerceApiClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    private CommerceApiClient|TestCommerceApiClient $commerceApi;

    public function __construct()
    {
        $this->middleware('auth');
        $this->commerceApi = $this->createCommerceApiClient();
    }

    /**
     * Create commerce API client - uses test client when real API is unavailable
     */
    private function createCommerceApiClient(): CommerceApiClient|TestCommerceApiClient
    {
        try {
            // Try to create real commerce API client
            $client = new CommerceApiClient();
            Log::info('CheckoutController: Created CommerceApiClient');
            
            // Test if the real API is accessible
            $testResponse = $client->getBooks(['limit' => 1]);
            Log::info('CheckoutController: getBooks response', [
                'success' => $testResponse['success'] ?? false,
                'status' => $testResponse['status'] ?? 0,
                'error' => $testResponse['error'] ?? null,
            ]);
            
            // Check if the API is actually working
            if (!$testResponse['success'] || ($testResponse['status'] ?? 0) >= 400) {
                Log::info('CheckoutController: Real commerce API not available (status: ' . ($testResponse['status'] ?? 0) . '), using test client');
                return new TestCommerceApiClient();
            }
            
            Log::info('CheckoutController: Using real CommerceApiClient');
            return $client;
        } catch (\Exception $e) {
            Log::info('CheckoutController: Commerce API connection failed, using test client', [
                'error' => $e->getMessage()
            ]);
            return new TestCommerceApiClient();
        }
    }

    /**
     * Initiate checkout process
     */
    public function create(Request $request)
    {
        $request->validate([
            'book_id' => 'required|string',
        ]);

        $bookId = $request->input('book_id');
        
        Log::info('CheckoutController: Initiating checkout', ['book_id' => $bookId, 'user_id' => auth()->id()]);
        
        // Check if commerce API is available
        if (!$this->commerceApi) {
            Log::error('CheckoutController: Commerce API not available');
            return response()->json([
                'success' => false,
                'message' => 'Commerce service is not available. Please try again later.',
            ], 503);
        }
        
        // Get book details first
        $bookResponse = $this->commerceApi->getBook($bookId);
        
        if (!$bookResponse['success']) {
            return response()->json([
                'success' => false,
                'message' => 'Book not found',
            ], 404);
        }

        $book = $bookResponse['data'];

        // Create checkout session
        $metadata = [
            'user_email' => auth()->user()->email,
            'user_name' => auth()->user()->name,
        ];

        $checkoutResponse = $this->commerceApi->createCheckout(
            $bookId,
            auth()->id(),
            $metadata
        );

        if (!$checkoutResponse['success']) {
            Log::error('Checkout creation failed', [
                'book_id' => $bookId,
                'user_id' => auth()->id(),
                'error' => $checkoutResponse['error'],
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to initiate checkout. Please try again.',
            ], 500);
        }

        $checkoutData = $checkoutResponse['data'];

        // Store session info for verification
        Session::put('checkout_session', [
            'session_id' => $checkoutData['session_id'],
            'order_id' => $checkoutData['order_id'],
            'book_id' => $bookId,
            'book_title' => $book['title'],
            'created_at' => now()->toIso8601String(),
        ]);

        return response()->json([
            'success' => true,
            'checkout_url' => $checkoutData['checkout_url'],
            'session_id' => $checkoutData['session_id'],
            'order_id' => $checkoutData['order_id'],
        ]);
    }

    /**
     * Check order status (polling endpoint)
     */
    public function status(Request $request)
    {
        $request->validate([
            'order_id' => 'required|string',
        ]);

        $orderId = $request->input('order_id');
        
        // Verify this order belongs to current user's session
        $sessionData = Session::get('checkout_session');
        
        if (!$sessionData || $sessionData['order_id'] !== $orderId) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid order',
            ], 403);
        }

        // For test orders, only complete if explicitly marked
        if (strpos($orderId, 'test_order_') === 0) {
            // Check if test order is marked as completed
            if (isset($sessionData['test_completed']) && $sessionData['test_completed']) {
                return response()->json([
                    'success' => true,
                    'status' => 'completed',
                    'order' => [
                        'order_id' => $orderId,
                        'status' => 'completed',
                        'book_id' => $sessionData['book_id'],
                        'purchased_at' => now()->toIso8601String(),
                    ],
                ]);
            }
            // Return pending status (waiting for user to complete in iframe)
            return response()->json([
                'success' => true,
                'status' => 'pending',
                'order' => [
                    'order_id' => $orderId,
                    'status' => 'pending',
                    'book_id' => $sessionData['book_id'],
                ],
            ]);
        }

        $response = $this->commerceApi->getOrder($orderId);

        if (!$response['success']) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to check order status',
            ], 500);
        }

        $order = $response['data'];

        return response()->json([
            'success' => true,
            'status' => $order['status'],
            'order' => $order,
        ]);
    }

    /**
     * Handle successful checkout return
     */
    public function returnUrl(Request $request)
    {
        $sessionData = Session::get('checkout_session');
        
        if (!$sessionData) {
            return redirect()->route('books.index')
                ->with('error', 'Invalid checkout session');
        }

        $orderId = $sessionData['order_id'];
        
        // For test orders, simulate completed purchase
        if (isset($sessionData['test_completed']) && $sessionData['test_completed']) {
            Session::forget('checkout_session');
            
            return redirect()->route('books.my-books')
                ->with('success', 'Test purchase completed! In production, this would complete the payment.');
        }
        
        // Verify order status for real orders
        $response = $this->commerceApi->getOrder($orderId);

        if ($response['success'] && $response['data']['status'] === 'completed') {
            Session::forget('checkout_session');
            
            return redirect()->route('books.my-books')
                ->with('success', 'Purchase completed! Your book is now available.');
        }

        return redirect()->route('books.show', ['id' => $sessionData['book_id']])
            ->with('info', 'Payment is being processed. Please check back shortly.');
    }

    /**
     * Handle cancelled checkout
     */
    public function cancelUrl(Request $request)
    {
        $sessionData = Session::get('checkout_session');
        Session::forget('checkout_session');

        $bookId = $sessionData['book_id'] ?? null;

        if ($bookId) {
            return redirect()->route('books.show', ['id' => $bookId])
                ->with('info', 'Checkout was cancelled.');
        }

        return redirect()->route('books.index')
            ->with('info', 'Checkout was cancelled.');
    }

    /**
     * Handle test checkout (for development/testing)
     */
    public function testCheckout(Request $request, string $sessionId)
    {
        $sessionData = Session::get('checkout_session');
        
        if (!$sessionData || $sessionData['session_id'] !== $sessionId) {
            return '<h1>Invalid Session</h1><p>Test checkout session not found.</p>';
        }
        
        $orderId = $sessionData['order_id'] ?? 'test_order_' . uniqid();
        $bookTitle = $sessionData['book_title'] ?? 'Digital Book';
        $checkoutUrl = route('commerce.checkout.test', ['session_id' => $sessionId]);
        
        $html = <<<HTML
<!DOCTYPE html>
<html>
<head>
    <title>Test Checkout</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 40px; background: #f5f5f5; }
        .container { max-width: 500px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); text-align: center; }
        h1 { color: #333; margin-bottom: 20px; }
        .book-title { font-size: 18px; color: #667eea; margin-bottom: 20px; }
        .price { font-size: 24px; color: #28a745; font-weight: bold; margin-bottom: 30px; }
        .btn { display: inline-block; padding: 15px 30px; background: #667eea; color: white; text-decoration: none; border-radius: 5px; margin: 5px; cursor: pointer; border: none; font-size: 16px; }
        .btn-success { background: #28a745; }
        .btn-secondary { background: #6c757d; }
        .btn:hover { opacity: 0.9; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Test Checkout</h1>
        <p class="book-title">Book: {$bookTitle}</p>
        <p class="price">$15.99</p>
        <p>This is a <strong>test checkout</strong> for development purposes.</p>
        <p style="color: #666; font-size: 14px;">Session ID: {$sessionId}</p>
        <hr style="margin: 20px 0;">
        <form method="POST" action="{$checkoutUrl}" target="_parent">
            <input type="hidden" name="action" value="complete">
            <input type="hidden" name="_token" value="{$request->session()->token()}">
            <button type="submit" class="btn btn-success">Complete Test Purchase</button>
        </form>
        <form method="POST" action="{$checkoutUrl}" target="_parent">
            <input type="hidden" name="action" value="cancel">
            <input type="hidden" name="_token" value="{$request->session()->token()}">
            <button type="submit" class="btn btn-secondary">Cancel</button>
        </form>
    </div>
</body>
</html>
HTML;
        
        if ($request->get('action') === 'complete') {
            // Mark test order as completed
            Session::put('checkout_session', [
                'session_id' => $sessionId,
                'order_id' => $orderId,
                'book_id' => $sessionData['book_id'],
                'book_title' => $sessionData['book_title'],
                'created_at' => now()->toIso8601String(),
                'test_completed' => true,
            ]);
            
            return redirect()->route('commerce.checkout.return');
        }
        
        if ($request->get('action') === 'cancel') {
            return redirect()->route('commerce.checkout.cancel');
        }
        
        return $html;
    }

    /**
     * Handle webhook from Department B
     */
    public function webhook(Request $request)
    {
        $payload = $request->getContent();
        $signature = $request->header('X-Signature');
        $timestamp = $request->header('X-Timestamp');

        // Verify webhook signature
        if (!$this->commerceApi->verifyWebhookSignature($payload, $signature, $timestamp)) {
            Log::warning('Invalid webhook signature', [
                'signature' => $signature,
                'timestamp' => $timestamp,
            ]);

            return response()->json(['error' => 'Invalid signature'], 401);
        }

        $data = json_decode($payload, true);

        Log::info('Commerce webhook received', [
            'event' => $data['event'] ?? 'unknown',
            'order_id' => $data['order_id'] ?? null,
        ]);

        // Handle different webhook events
        switch ($data['event'] ?? null) {
            case 'order.completed':
                $this->handleOrderCompleted($data);
                break;
            
            case 'order.failed':
                $this->handleOrderFailed($data);
                break;
            
            default:
                Log::info('Unhandled webhook event', ['event' => $data['event'] ?? 'unknown']);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Handle order completed webhook
     */
    private function handleOrderCompleted(array $data): void
    {
        $orderId = $data['order_id'] ?? null;
        $userId = $data['user_id'] ?? null;

        if (!$orderId || !$userId) {
            return;
        }

        Log::info('Order completed', [
            'order_id' => $orderId,
            'user_id' => $userId,
        ]);

        // Optional: Send notification to user
        // Optional: Update local cache/records
    }

    /**
     * Handle order failed webhook
     */
    private function handleOrderFailed(array $data): void
    {
        $orderId = $data['order_id'] ?? null;
        $reason = $data['reason'] ?? 'Unknown';

        Log::warning('Order failed', [
            'order_id' => $orderId,
            'reason' => $reason,
        ]);
    }
}
