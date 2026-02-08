<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\NewBookAdded;
use App\Services\CommerceApiClient;
use App\Services\TestCommerceApiClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class AdminBookController extends Controller
{
    private CommerceApiClient|TestCommerceApiClient $commerceApi;

    public function __construct()
    {
        $this->middleware(['auth', 'adminAuth']);
        $this->commerceApi = $this->createCommerceApiClient();
    }

    /**
     * Create commerce API client - uses test client when real API is unavailable
     */
    private function createCommerceApiClient(): CommerceApiClient|TestCommerceApiClient
    {
        try {
            $client = new CommerceApiClient();
            
            $testResponse = $client->getBooks(['limit' => 1]);
            
            if (!$testResponse['success']) {
                Log::info('AdminBookController: Real commerce API not available, using test client');
                return new TestCommerceApiClient();
            }
            
            return $client;
        } catch (\Exception $e) {
            Log::info('AdminBookController: Commerce API connection failed, using test client', [
                'error' => $e->getMessage()
            ]);
            return new TestCommerceApiClient();
        }
    }

    /**
     * Display all books (admin view)
     */
    public function index(Request $request)
    {
        $filters = $request->only(['category', 'search', 'sort']);
        
        $response = $this->commerceApi->getBooks($filters);
        
        if (!$response['success']) {
            return view('admin.books.index', [
                'books' => [],
                'error' => 'Unable to load books. ' . ($response['error'] ?? 'Unknown error'),
            ]);
        }

        return view('admin.books.index', [
            'books' => $response['data']['books'] ?? [],
            'pagination' => $response['data']['pagination'] ?? null,
            'filters' => $filters,
        ]);
    }

    /**
     * Show form to create new book
     */
    public function create()
    {
        return view('admin.books.create');
    }

    /**
     * Store new book
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'nullable|string|max:100',
            'language' => 'nullable|string|max:50',
            'pages' => 'nullable|integer|min:1',
            'format' => 'nullable|string|max:50',
        ]);

        $data = [
            'title' => $validated['title'],
            'author' => $validated['author'],
            'description' => $validated['description'],
            'price' => (float) $validated['price'],
            'details' => [
                'category' => $validated['category'] ?? 'General',
                'language' => $validated['language'] ?? 'English',
                'pages' => (int) ($validated['pages'] ?? 0),
                'format' => $validated['format'] ?? 'Paperback',
            ],
        ];

        $response = $this->commerceApi->createBook($data);

        if (!$response['success']) {
            Log::error('Failed to create book', ['error' => $response['error'] ?? 'Unknown error']);
            return back()->with('error', 'Failed to create book. ' . ($response['error'] ?? ''))->withInput();
        }

        // Send notifications to all users about the new book
        $newBook = $response['data'] ?? $data;
        $newBook['details'] = $data['details'];
        
        try {
            // Get all users who want to receive email notifications
            $users = User::where('email_notifications', true)->get();
            
            if ($users->isNotEmpty()) {
                Notification::send($users, new NewBookAdded($newBook, $data['details']));
                Log::info('New book notification sent to ' . $users->count() . ' users');
            }

            // Mark book as notified to prevent duplicate notifications from scheduled command
            $bookId = $newBook['id'] ?? uniqid('book_');
            DB::table('notified_books')->updateOrInsert(
                ['book_id' => $bookId],
                [
                    'title' => $newBook['title'],
                    'author' => $newBook['author'],
                    'notified_at' => now(),
                    'email_sent' => true,
                    'notification_sent' => true,
                ]
            );
        } catch (\Exception $e) {
            Log::error('Failed to send new book notifications', ['error' => $e->getMessage()]);
        }

        return redirect()->route('admin.books.index')
            ->with('success', 'Book created successfully! Notifications have been sent to all users.');
    }

    /**
     * Show form to edit book
     */
    public function edit(string $id)
    {
        $response = $this->commerceApi->getBook($id);
        
        if (!$response['success']) {
            return redirect()->route('admin.books.index')
                ->with('error', 'Book not found.');
        }

        return view('admin.books.edit', [
            'book' => $response['data'],
        ]);
    }

    /**
     * Update book
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'nullable|string|max:100',
            'language' => 'nullable|string|max:50',
            'pages' => 'nullable|integer|min:1',
            'format' => 'nullable|string|max:50',
        ]);

        $data = [
            'title' => $validated['title'],
            'author' => $validated['author'],
            'description' => $validated['description'],
            'price' => (float) $validated['price'],
            'details' => [
                'category' => $validated['category'] ?? 'General',
                'language' => $validated['language'] ?? 'English',
                'pages' => (int) ($validated['pages'] ?? 0),
                'format' => $validated['format'] ?? 'Paperback',
            ],
        ];

        $response = $this->commerceApi->updateBook($id, $data);

        if (!$response['success']) {
            Log::error('Failed to update book', ['id' => $id, 'error' => $response['error'] ?? 'Unknown error']);
            return back()->with('error', 'Failed to update book. ' . ($response['error'] ?? ''))->withInput();
        }

        return redirect()->route('admin.books.index')
            ->with('success', 'Book updated successfully!');
    }

    /**
     * Delete book
     */
    public function destroy(string $id)
    {
        $response = $this->commerceApi->deleteBook($id);

        if (!$response['success']) {
            Log::error('Failed to delete book', ['id' => $id, 'error' => $response['error'] ?? 'Unknown error']);
            return back()->with('error', 'Failed to delete book. ' . ($response['error'] ?? ''));
        }

        return redirect()->route('admin.books.index')
            ->with('success', 'Book deleted successfully!');
    }

    /**
     * Show book details
     */
    public function show(string $id)
    {
        $response = $this->commerceApi->getBook($id);
        
        if (!$response['success']) {
            return redirect()->route('admin.books.index')
                ->with('error', 'Book not found.');
        }

        return view('admin.books.show', [
            'book' => $response['data'],
        ]);
    }

    /**
     * View orders for a book
     */
    public function orders(Request $request, string $bookId)
    {
        $response = $this->commerceApi->getBookOrders($bookId);
        
        if (!$response['success']) {
            return back()->with('error', 'Unable to load orders.');
        }

        return view('admin.books.orders', [
            'bookId' => $bookId,
            'orders' => $response['data']['orders'] ?? [],
        ]);
    }
}

