<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\NewBookAdded;
use App\Services\CommerceApiClient;
use App\Services\TestCommerceApiClient;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class CheckNewBooks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'books:check-new {--api-client= : Force specific API client (commerce|test)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for new books from the Commerce API and send notifications';

    private CommerceApiClient|TestCommerceApiClient $commerceApi;

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Checking for new books from Commerce API...');

        $this->commerceApi = $this->createCommerceApiClient();

        // Get all books from the API
        $response = $this->commerceApi->getBooks(['limit' => 100]);

        if (!$response['success']) {
            $this->error('Failed to fetch books from API: ' . ($response['error'] ?? 'Unknown error'));
            return Command::FAILURE;
        }

        $books = $response['data']['books'] ?? [];
        $this->info('Found ' . count($books) . ' books from API');

        $newBooksCount = 0;
        $notifiedCount = 0;

        foreach ($books as $book) {
            $bookId = $book['id'] ?? null;

            if (!$bookId) {
                continue;
            }

            // Check if this book has already been notified
            $alreadyNotified = DB::table('notified_books')
                ->where('book_id', $bookId)
                ->exists();

            if ($alreadyNotified) {
                continue;
            }

            // New book found! Send notifications
            $this->info("New book found: {$book['title']} by {$book['author']}");

            try {
                // Get all users who want to receive email notifications
                $users = User::where('email_notifications', true)->get();

                if ($users->isNotEmpty()) {
                    Notification::send($users, new NewBookAdded($book, $book['details'] ?? []));
                    $notifiedCount += $users->count();
                    $this->info("  - Sent notifications to {$users->count()} users");
                }

                // Mark book as notified
                DB::table('notified_books')->insert([
                    'book_id' => $bookId,
                    'title' => $book['title'] ?? 'Unknown',
                    'author' => $book['author'] ?? 'Unknown',
                    'notified_at' => now(),
                    'email_sent' => true,
                    'notification_sent' => true,
                ]);

                $newBooksCount++;
            } catch (\Exception $e) {
                Log::error('Failed to send notification for book', [
                    'book_id' => $bookId,
                    'error' => $e->getMessage(),
                ]);
                $this->error("  - Failed to send notification: {$e->getMessage()}");
            }
        }

        $this->info("Summary:");
        $this->info("  - New books found: {$newBooksCount}");
        $this->info("  - Notifications sent: {$notifiedCount}");

        return Command::SUCCESS;
    }

    /**
     * Create commerce API client.
     */
    private function createCommerceApiClient(): CommerceApiClient|TestCommerceApiClient
    {
        $forceClient = $this->option('api-client');

        if ($forceClient === 'test') {
            return new TestCommerceApiClient();
        }

        if ($forceClient === 'commerce') {
            return new CommerceApiClient();
        }

        try {
            $client = new CommerceApiClient();
            
            $testResponse = $client->getBooks(['limit' => 1]);
            
            if (!$testResponse['success']) {
                Log::info('CheckNewBooks: Real commerce API not available, using test client');
                return new TestCommerceApiClient();
            }
            
            return $client;
        } catch (\Exception $e) {
            Log::info('CheckNewBooks: Commerce API connection failed, using test client', [
                'error' => $e->getMessage()
            ]);
            return new TestCommerceApiClient();
        }
    }
}
