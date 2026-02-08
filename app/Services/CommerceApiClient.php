<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Firebase\JWT\JWT;

class CommerceApiClient
{
    private string $baseUrl;
    private string $apiKey;
    private string $apiSecret;
    private string $jwtIssuer;
    private string $jwtAudience;
    private int $jwtTtl;
    private int $timeout;
    private int $retryAttempts;

    public function __construct()
    {
        $config = config('services.commerce');
        
        $this->baseUrl = rtrim($config['api_url'] ?? '', '/');
        $this->apiKey = $config['api_key'] ?? '';
        $this->apiSecret = $config['api_secret'] ?? '';
        $this->jwtIssuer = $config['jwt_issuer'] ?? 'department-a';
        $this->jwtAudience = $config['jwt_audience'] ?? 'department-b';
        $this->jwtTtl = $config['jwt_ttl'] ?? 3600;
        $this->timeout = $config['timeout'] ?? 30;
        $this->retryAttempts = $config['retry_attempts'] ?? 3;
    }

    /**
     * Generate JWT token for machine-to-machine authentication
     */
    private function generateJwt(): string
    {
        $cacheKey = 'commerce_jwt_token';
        
        return Cache::remember($cacheKey, $this->jwtTtl - 60, function () {
            $now = time();
            
            $payload = [
                'iss' => $this->jwtIssuer,
                'aud' => $this->jwtAudience,
                'iat' => $now,
                'exp' => $now + $this->jwtTtl,
                'sub' => $this->apiKey,
            ];

            return JWT::encode($payload, $this->apiSecret, 'HS256');
        });
    }

    /**
     * Generate HMAC signature for request
     */
    private function generateHmac(string $method, string $path, string $timestamp, string $body = ''): string
    {
        $message = strtoupper($method) . "\n" . $path . "\n" . $timestamp . "\n" . $body;
        return hash_hmac('sha256', $message, $this->apiSecret);
    }

    /**
     * Make authenticated request to Commerce API
     */
    private function request(string $method, string $endpoint, array $data = [], array $options = []): array
    {
        $url = $this->baseUrl . $endpoint;
        $timestamp = (string) time();
        $body = !empty($data) ? json_encode($data) : '';
        
        $jwt = $this->generateJwt();
        $hmac = $this->generateHmac($method, $endpoint, $timestamp, $body);

        $headers = [
            'Authorization' => 'Bearer ' . $jwt,
            'X-Signature' => $hmac,
            'X-Timestamp' => $timestamp,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        Log::info('Commerce API Request', [
            'method' => $method,
            'endpoint' => $endpoint,
            'timestamp' => $timestamp,
        ]);

        try {
            $response = Http::withHeaders($headers)
                ->timeout($this->timeout)
                ->retry($this->retryAttempts, 100)
                ->{strtolower($method)}($url, $data);

            if ($response->successful()) {
                Log::info('Commerce API Success', [
                    'endpoint' => $endpoint,
                    'status' => $response->status(),
                ]);
                
                return [
                    'success' => true,
                    'data' => $response->json(),
                    'status' => $response->status(),
                ];
            }

            Log::error('Commerce API Error', [
                'endpoint' => $endpoint,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return [
                'success' => false,
                'error' => $response->json()['message'] ?? 'API request failed',
                'status' => $response->status(),
            ];

        } catch (\Exception $e) {
            Log::error('Commerce API Exception', [
                'endpoint' => $endpoint,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'error' => 'Connection error: ' . $e->getMessage(),
                'status' => 500,
            ];
        }
    }

    /**
     * Get all available books
     */
    public function getBooks(array $filters = []): array
    {
        $query = http_build_query($filters);
        $endpoint = '/api/v1/books' . ($query ? '?' . $query : '');
        
        return $this->request('GET', $endpoint);
    }

    /**
     * Get single book details
     */
    public function getBook(string $bookId): array
    {
        return $this->request('GET', "/api/v1/books/{$bookId}");
    }

    /**
     * Create checkout session
     */
    public function createCheckout(string $bookId, int $userId, array $metadata = []): array
    {
        $data = [
            'book_id' => $bookId,
            'user_id' => $userId,
            'return_url' => route('commerce.checkout.return'),
            'cancel_url' => route('commerce.checkout.cancel'),
            'webhook_url' => route('commerce.webhook'),
            'metadata' => $metadata,
        ];

        return $this->request('POST', '/api/v1/checkout', $data);
    }

    /**
     * Get order status
     */
    public function getOrder(string $orderId): array
    {
        return $this->request('GET', "/api/v1/orders/{$orderId}");
    }

    /**
     * Get secure download URL for purchased book
     */
    public function getDownloadUrl(string $orderId): array
    {
        return $this->request('GET', "/api/v1/orders/{$orderId}/download");
    }

    /**
     * Verify webhook signature
     */
    public function verifyWebhookSignature(string $payload, string $signature, string $timestamp): bool
    {
        $expectedSignature = $this->generateHmac('POST', '/webhook', $timestamp, $payload);
        
        return hash_equals($expectedSignature, $signature);
    }

    /**
     * Get user's purchase history
     */
    public function getUserOrders(int $userId): array
    {
        return $this->request('GET', "/api/v1/users/{$userId}/orders");
    }

    /**
     * Create new book (admin)
     */
    public function createBook(array $data): array
    {
        return $this->request('POST', '/api/v1/admin/books', $data);
    }

    /**
     * Update book (admin)
     */
    public function updateBook(string $bookId, array $data): array
    {
        return $this->request('PUT', "/api/v1/admin/books/{$bookId}", $data);
    }

    /**
     * Delete book (admin)
     */
    public function deleteBook(string $bookId): array
    {
        return $this->request('DELETE', "/api/v1/admin/books/{$bookId}");
    }

    /**
     * Get orders for a specific book (admin)
     */
    public function getBookOrders(string $bookId): array
    {
        return $this->request('GET', "/api/v1/admin/books/{$bookId}/orders");
    }
}
