<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class BirthdayNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $user;

    /**
     * Create a new notification instance.
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Happy Birthday!')
                    ->greeting('Happy Birthday, ' . $this->user->name . '!')
                    ->line('We wish you a wonderful day filled with joy and blessings.')
                    ->line('Thank you for being a valued member of our community.')
                    ->action('Visit Our Website', url('/'))
                    ->line('Have a great day!');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable)
    {
        return [
            'message' => 'Today is ' . $this->user->name . '\'s birthday. Send your wishes!',
            'url' => url('/account/profile/' . $this->user->id),
        ];
    }
}
