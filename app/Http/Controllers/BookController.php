<?php

namespace App\Http\Controllers;

use App\Services\CommerceApiClient;
use App\Services\TestCommerceApiClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{
    private ?CommerceApiClient $commerceApi;
    private ?TestCommerceApiClient $testCommerceApi;

    public function __construct(
        ?CommerceApiClient $commerceApi = null,
        ?TestCommerceApiClient $testCommerceApi = null
    ) {
        $this->commerceApi = $commerceApi;
        $this->testCommerceApi = $testCommerceApi;
        
        // If dependencies are null, create them on demand
        if ($this->commerceApi === null || $this->testCommerceApi === null) {
            $this->testCommerceApi = new TestCommerceApiClient();
        }
    }

    /**
     * Create commerce API client - uses test client when real API is unavailable
     */
    private function createCommerceApiClient(): CommerceApiClient|TestCommerceApiClient
    {
        try {
            // Try to create real commerce API client
            $client = new CommerceApiClient();
            
            // Test if the real API is accessible and has books
            $testResponse = $client->getBooks(['limit' => 1]);
            
            if (!$testResponse['success'] || empty($testResponse['data']['books'])) {
                Log::info('BookController: Real commerce API not available or empty, using test client');
                return new TestCommerceApiClient();
            }
            
            return $client;
        } catch (\Exception $e) {
            Log::info('BookController: Commerce API connection failed, using test client', [
                'error' => $e->getMessage()
            ]);
            return new TestCommerceApiClient();
        }
    }

    /**
     * Public method to browse books (no auth required)
     */
    public function browse(Request $request)
    {
        $filters = $request->only(['category', 'search', 'sort']);
        
        Log::info('BookController browse(): Starting', ['filters' => $filters]);
        
        $commerceApi = $this->createCommerceApiClient();
        Log::info('BookController browse(): Commerce API created', ['class' => get_class($commerceApi)]);
        
        $response = $commerceApi->getBooks($filters);
        Log::info('BookController browse(): getBooks response', [
            'success' => $response['success'] ?? false,
            'book_count' => count($response['data']['books'] ?? [])
        ]);
        
        $usingTestBooks = $commerceApi instanceof TestCommerceApiClient;

        if (!$response['success']) {
            Log::error('Failed to fetch books', ['error' => $response['error'] ?? 'Unknown error']);
            
            return view('front.books.index', [
                'books' => [],
                'error' => 'Unable to load books at this time. Please try again later.',
                'usingTestBooks' => $usingTestBooks,
            ]);
        }

        // Filter out book ID 1
        $books = collect($response['data']['books'] ?? [])->filter(function($book) {
            return ($book['id'] ?? 0) != 1;
        })->values()->all();

        return view('front.books.index', [
            'books' => $books,
            'pagination' => $response['data']['pagination'] ?? null,
            'filters' => $filters,
            'usingTestBooks' => $usingTestBooks,
        ]);
    }

    /**
     * Public method to view book details (no auth required)
     */
    public function view(string $id)
    {
        Log::info('BookController view(): Starting', ['id' => $id]);
        
        try {
            $commerceApi = $this->createCommerceApiClient();
            Log::info('BookController view(): Commerce API created', ['class' => get_class($commerceApi)]);
            
            $response = $commerceApi->getBook($id);
            Log::info('BookController view(): getBook response', ['success' => $response['success'] ?? false]);
            
            $usingTestBook = $commerceApi instanceof TestCommerceApiClient;

            if (!$response['success']) {
                Log::warning('BookController view(): Book not found', ['id' => $id]);
                abort(404, 'Book not found');
            }

            $book = $response['data'];
            Log::info('BookController view(): Book found', ['title' => $book['title'] ?? 'unknown']);

            // Check if user already owns this book (only if authenticated)
            $alreadyOwned = false;
            if (auth()->check()) {
                try {
                    $userOrders = $commerceApi->getUserOrders(auth()->id());
                    
                    if ($userOrders['success']) {
                        $ownedBookIds = collect($userOrders['data']['orders'] ?? [])
                            ->where('status', 'completed')
                            ->pluck('book_id')
                            ->toArray();
                        
                        $alreadyOwned = in_array($id, $ownedBookIds);
                    }
                } catch (\Exception $e) {
                    Log::info('BookController: Could not check ownership', ['error' => $e->getMessage()]);
                }
            }

            Log::info('BookController view(): Rendering view');
            return view('front.books.show', [
                'book' => $book,
                'alreadyOwned' => $alreadyOwned,
                'usingTestBook' => $usingTestBook,
            ]);
        } catch (\Exception $e) {
            Log::error('BookController view(): Exception', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            throw $e;
        }
    }

    /**
     * Display listing of available books (requires auth for purchase)
     */
    public function index(Request $request)
    {
        $filters = $request->only(['category', 'search', 'sort']);
        
        $commerceApi = $this->createCommerceApiClient();
        $response = $commerceApi->getBooks($filters);
        $usingTestBooks = $commerceApi instanceof TestCommerceApiClient;

        if (!$response['success']) {
            Log::error('Failed to fetch books', ['error' => $response['error'] ?? 'Unknown error']);
            
            return view('front.books.index', [
                'books' => [],
                'error' => 'Unable to load books at this time. Please try again later.',
                'usingTestBooks' => $usingTestBooks,
            ]);
        }

        // Filter out book ID 1
        $books = collect($response['data']['books'] ?? [])->filter(function($book) {
            return ($book['id'] ?? 0) != 1;
        })->values()->all();

        return view('front.books.index', [
            'books' => $books,
            'pagination' => $response['data']['pagination'] ?? null,
            'filters' => $filters,
            'usingTestBooks' => $usingTestBooks,
        ]);
    }

    /**
     * Display single book details (requires auth for purchase)
     */
    public function show(string $id)
    {
        $commerceApi = $this->createCommerceApiClient();
        $response = $commerceApi->getBook($id);
        $usingTestBook = $commerceApi instanceof TestCommerceApiClient;

        if (!$response['success']) {
            abort(404, 'Book not found');
        }

        $book = $response['data'];

        // Check if user already owns this book
        $alreadyOwned = false;
        if (auth()->check()) {
            try {
                $userOrders = $this->commerceApi->getUserOrders(auth()->id());
                
                if ($userOrders['success']) {
                    $ownedBookIds = collect($userOrders['data']['orders'] ?? [])
                        ->where('status', 'completed')
                        ->pluck('book_id')
                        ->toArray();
                    
                    $alreadyOwned = in_array($id, $ownedBookIds);
                }
            } catch (\Exception $e) {
                // Commerce API not available
            }
        }

        return view('front.books.show', [
            'book' => $book,
            'alreadyOwned' => $alreadyOwned,
            'usingTestBook' => $usingTestBook,
        ]);
    }

    /**
     * Display user's purchased books
     */
    public function myBooks()
    {
        $commerceApi = $this->createCommerceApiClient();
        
        if (auth()->check()) {
            try {
                $response = $commerceApi->getUserOrders(auth()->id());
                
                if (!$response['success']) {
                    return view('front.books.my-books', [
                        'orders' => [],
                        'error' => 'Unable to load your books at this time.',
                    ]);
                }

                $orders = collect($response['data']['orders'] ?? [])
                    ->where('status', 'completed')
                    ->sortByDesc('purchased_at');

                return view('front.books.my-books', [
                    'orders' => $orders,
                ]);
            } catch (\Exception $e) {
                return view('front.books.my-books', [
                    'orders' => [],
                    'error' => 'Unable to load your books at this time.',
                ]);
            }
        }

        return view('front.books.my-books', [
            'orders' => [],
        ]);
    }
}
