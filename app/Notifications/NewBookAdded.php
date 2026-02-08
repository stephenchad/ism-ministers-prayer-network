<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NewBookAdded extends Notification implements ShouldQueue
{
    use Queueable;

    protected $book;
    protected $bookDetails;

    /**
     * Create a new notification instance.
     */
    public function __construct(array $book, array $bookDetails = [])
    {
        $this->book = $book;
        $this->bookDetails = $bookDetails;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['mail', 'database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        $title = $this->book['title'] ?? 'New Book';
        $author = $this->book['author'] ?? 'Unknown Author';
        $price = isset($this->book['price']) ? '$' . number_format($this->book['price'], 2) : '';

        return (new MailMessage)
            ->subject('New Book Available: ' . $title)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('A new book has been added to our collection.')
            ->line("📖 **" . $title . "** by " . $author)
            ->line($price)
            ->line($this->book['description'] ?? '')
            ->action('Browse Books', route('books.index'))
            ->line('Thank you for being a valued member of our community!');
    }

    /**
     * Get the broadcast representation of the notification.
     */
    public function toBroadcast($notifiable): BroadcastMessage
    {
        $title = $this->book['title'] ?? 'New Book';

        return new BroadcastMessage([
            'book_id' => $this->book['id'] ?? null,
            'book_title' => $title,
            'message' => '📚 New book available: "' . $title . '"',
            'url' => route('books.index'),
        ]);
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable)
    {
        $title = $this->book['title'] ?? 'New Book';

        return [
            'book_id' => $this->book['id'] ?? null,
            'book_title' => $title,
            'book_author' => $this->book['author'] ?? null,
            'book_price' => $this->book['price'] ?? null,
            'message' => '📚 New book available: "' . $title . '"',
            'url' => route('books.index'),
        ];
    }
}
