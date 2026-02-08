<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

/**
 * Test/Mock Commerce API Client
 * Mimics the exact API structure and response format of CommerceApiClient
 * for development and testing purposes
 */
class TestCommerceApiClient
{
    /**
     * Generate SVG book cover as data URI
     */
    private function generateBookCover(string $title, string $author, string $bgColor): string
    {
        $title = htmlspecialchars($title, ENT_XML1, 'UTF-8');
        $author = htmlspecialchars($author, ENT_XML1, 'UTF-8');
        
        // Truncate title if too long
        if (strlen($title) > 25) {
            $title = substr($title, 0, 22) . '...';
        }
        
        $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="400" height="600" viewBox="0 0 400 600">
  <defs>
    <linearGradient id="grad" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" style="stop-color:#{$bgColor};stop-opacity:1" />
      <stop offset="100%" style="stop-color:#{$bgColor};stop-opacity:0.8" />
    </linearGradient>
    <pattern id="pattern" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
      <circle cx="10" cy="10" r="1" fill="white" opacity="0.1"/>
    </pattern>
  </defs>
  <rect width="400" height="600" fill="url(#grad)"/>
  <rect width="400" height="600" fill="url(#pattern)"/>
  <rect x="20" y="20" width="360" height="560" fill="none" stroke="white" stroke-width="2" opacity="0.3" rx="5"/>
  <g transform="translate(200, 200)">
    <circle cx="0" cy="0" r="60" fill="none" stroke="white" stroke-width="3" opacity="0.5"/>
    <text x="0" y="10" text-anchor="middle" fill="white" font-family="Arial, sans-serif" font-size="60" font-weight="bold">PRAY</text>
  </g>
  <text x="200" y="380" text-anchor="middle" fill="white" font-family="Arial, sans-serif" font-size="24" font-weight="bold">{$title}</text>
  <text x="200" y="420" text-anchor="middle" fill="white" font-family="Arial, sans-serif" font-size="16" opacity="0.9">by {$author}</text>
  <text x="200" y="550" text-anchor="middle" fill="white" font-family="Arial, sans-serif" font-size="14" opacity="0.7">ISM Ministers Prayer Network</text>
</svg>
SVG;
        
        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }

    /**
     * Test books data - all by Pastor Chris Oyakhilome
     */
    private function getTestBooksData(): array
    {
        $books = [
            [
                'id' => '1',
                'title' => 'The Power of Prayer',
                'author' => 'Pastor Chris Oyakhilome',
                'description' => 'A comprehensive guide to understanding and practicing effective prayer. Learn the principles that will transform your prayer life and bring you closer to God. This book reveals the secret to unanswered prayers and how to pray effectively.',
                'price' => 15.99,
                'bg_color' => '667eea',
            ],
            [
                'id' => '2',
                'title' => 'The Unchanging Nature of God',
                'author' => 'Pastor Chris Oyakhilome',
                'description' => 'Discover the faithfulness of God and His unchanging nature in a changing world. Learn how to anchor your faith on the solid rock who never changes.',
                'price' => 12.99,
                'bg_color' => '764ba2',
            ],
            [
                'id' => '3',
                'title' => 'Understanding the Anointing',
                'author' => 'Pastor Chris Oyakhilome',
                'description' => 'A deeper understanding of the Holy Spirit anointing and how it operates in the life of a believer. Learn to walk in the power of the Holy Spirit daily.',
                'price' => 18.50,
                'bg_color' => '5a67d8',
            ],
            [
                'id' => '4',
                'title' => 'The Place of the Word',
                'author' => 'Pastor Chris Oyakhilome',
                'description' => 'Practical tools and strategies for making the Bible the foundation of your daily life. Learn how to study, meditate, and apply God\'s word effectively.',
                'price' => 14.99,
                'bg_color' => '6b46c1',
            ],
            [
                'id' => '5',
                'title' => 'Prosperity: The Untold Story',
                'author' => 'Pastor Chris Oyakhilome',
                'description' => 'Explore biblical principles for prosperity and learn how to walk in divine favor and financial blessing. Discover the heart of God for your prosperity.',
                'price' => 22.00,
                'bg_color' => '553c9a',
            ],
            [
                'id' => '6',
                'title' => 'Divine Healing',
                'author' => 'Pastor Chris Oyakhilome',
                'description' => 'Understanding and receiving divine healing. Learn how to walk in divine health and the healing power of Jesus Christ.',
                'price' => 19.99,
                'bg_color' => '4c51bf',
            ],
        ];

        // Add cover_image to each book
        foreach ($books as &$book) {
            $book['cover_image'] = $this->generateBookCover(
                $book['title'],
                $book['author'],
                $book['bg_color']
            );
            $book['details'] = [
                'pages' => 250,
                'format' => 'Paperback',
                'language' => 'English',
            ];
            $book['created_at'] = '2024-01-15T10:00:00Z';
            $book['updated_at'] = '2024-01-15T10:00:00Z';
        }

        return $books;
    }

    /**
     * Get all available books (mimics CommerceApiClient::getBooks)
     */
    public function getBooks(array $filters = []): array
    {
        Log::info('TestCommerceApiClient: Fetching books with filters', $filters);

        $books = $this->getTestBooksData();

        // Apply search filter
        if (!empty($filters['search'])) {
            $search = strtolower($filters['search']);
            $books = array_filter($books, function($book) use ($search) {
                return strpos(strtolower($book['title']), $search) !== false ||
                       strpos(strtolower($book['author']), $search) !== false;
            });
        }

        // Apply limit
        $limit = $filters['limit'] ?? null;
        if ($limit && is_numeric($limit)) {
            $books = array_slice($books, 0, (int)$limit);
        }

        // Pagination simulation
        $page = $filters['page'] ?? 1;
        $perPage = $filters['per_page'] ?? 10;
        $total = count($books);
        $totalPages = ceil($total / $perPage);
        $offset = ($page - 1) * $perPage;
        $paginatedBooks = array_slice($books, $offset, $perPage);

        Log::info('TestCommerceApiClient: Successfully fetched books', [
            'total' => $total,
            'page' => $page,
            'per_page' => $perPage,
        ]);

        return [
            'success' => true,
            'data' => [
                'books' => array_values($paginatedBooks),
                'pagination' => [
                    'current_page' => $page,
                    'per_page' => $perPage,
                    'total' => $total,
                    'total_pages' => $totalPages,
                    'has_more' => $page < $totalPages,
                ],
            ],
            'status' => 200,
        ];
    }

    /**
     * Get single book details (mimics CommerceApiClient::getBook)
     */
    public function getBook(string $bookId): array
    {
        Log::info('TestCommerceApiClient: Fetching book', ['id' => $bookId]);

        $books = $this->getTestBooksData();
        
        foreach ($books as $book) {
            if ($book['id'] == $bookId) {
                Log::info('TestCommerceApiClient: Book found', ['id' => $bookId]);
                return [
                    'success' => true,
                    'data' => $book,
                    'status' => 200,
                ];
            }
        }

        Log::warning('TestCommerceApiClient: Book not found', ['id' => $bookId]);
        return [
            'success' => false,
            'error' => 'Book not found',
            'status' => 404,
        ];
    }

    /**
     * Create checkout session (mimics CommerceApiClient::createCheckout)
     */
    public function createCheckout(string $bookId, int $userId, array $metadata = []): array
    {
        Log::info('TestCommerceApiClient: Creating checkout', [
            'book_id' => $bookId,
            'user_id' => $userId,
        ]);

        $checkoutId = 'test_checkout_' . uniqid();
        
        return [
            'success' => true,
            'data' => [
                'session_id' => $checkoutId,
                'order_id' => 'test_order_' . uniqid(),
                'checkout_id' => $checkoutId,
                'book_id' => $bookId,
                'user_id' => $userId,
                'amount' => 15.99,
                'currency' => 'USD',
                'status' => 'pending',
                'checkout_url' => route('commerce.checkout.test', ['session_id' => $checkoutId]),
                'created_at' => date('c'),
            ],
            'status' => 200,
        ];
    }

    /**
     * Get order status (mimics CommerceApiClient::getOrder)
     */
    public function getOrder(string $orderId): array
    {
        Log::info('TestCommerceApiClient: Fetching order', ['order_id' => $orderId]);

        return [
            'success' => true,
            'data' => [
                'order_id' => $orderId,
                'status' => 'completed',
                'book_id' => '1',
                'user_id' => 1,
                'amount' => 15.99,
                'currency' => 'USD',
                'purchased_at' => date('c'),
            ],
            'status' => 200,
        ];
    }

    /**
     * Get secure download URL (mimics CommerceApiClient::getDownloadUrl)
     */
    public function getDownloadUrl(string $orderId): array
    {
        Log::info('TestCommerceApiClient: Generating download URL', ['order_id' => $orderId]);

        return [
            'success' => true,
            'data' => [
                'download_url' => 'https://test-commerce.example.com/download/' . $orderId,
                'expires_at' => date('c', strtotime('+24 hours')),
            ],
            'status' => 200,
        ];
    }

    /**
     * Get user's purchase history (mimics CommerceApiClient::getUserOrders)
     */
    public function getUserOrders(int $userId): array
    {
        Log::info('TestCommerceApiClient: Fetching user orders', ['user_id' => $userId]);

        return [
            'success' => true,
            'data' => [
                'orders' => [],
            ],
            'status' => 200,
        ];
    }

    /**
     * Create new book (admin - test mode)
     */
    public function createBook(array $data): array
    {
        Log::info('TestCommerceApiClient: Creating book', $data);

        $bookId = (string) (count($this->getTestBooksData()) + 1);
        
        return [
            'success' => true,
            'data' => array_merge($data, [
                'id' => $bookId,
                'created_at' => date('c'),
                'updated_at' => date('c'),
            ]),
            'status' => 201,
        ];
    }

    /**
     * Update book (admin - test mode)
     */
    public function updateBook(string $bookId, array $data): array
    {
        Log::info('TestCommerceApiClient: Updating book', ['id' => $bookId, 'data' => $data]);

        return [
            'success' => true,
            'data' => array_merge([
                'id' => $bookId,
                'updated_at' => date('c'),
            ], $data),
            'status' => 200,
        ];
    }

    /**
     * Delete book (admin - test mode)
     */
    public function deleteBook(string $bookId): array
    {
        Log::info('TestCommerceApiClient: Deleting book', ['id' => $bookId]);

        return [
            'success' => true,
            'data' => [
                'message' => 'Book deleted successfully',
            ],
            'status' => 200,
        ];
    }

    /**
     * Get orders for a specific book (admin - test mode)
     */
    public function getBookOrders(string $bookId): array
    {
        Log::info('TestCommerceApiClient: Fetching book orders', ['book_id' => $bookId]);

        return [
            'success' => true,
            'data' => [
                'orders' => [],
            ],
            'status' => 200,
        ];
    }
}
