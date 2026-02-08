<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class PromotedToCoordinator extends Notification implements ShouldBroadcast
{
    use Queueable;

    protected $user;
    protected $title;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $user, string $title)
    {
        $this->user = $user;
        $this->title = $title;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Congratulations! You are now a ' . $this->title)
                    ->greeting('Hello ' . $notifiable->name . ',')
                    ->line('You have been promoted to ' . $this->title . '.')
                    ->line('Thank you for your leadership and commitment to our community!')
                    ->action('View Profile', route('account.profile'))
                    ->line('Keep up the great work!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'You have been promoted to ' . $this->title,
            'title' => $this->title,
            'url' => route('account.profile'),
        ];
    }

    /**
     * Get the broadcastable representation of the notification.
     *
     * @param  object  $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'message' => 'You have been promoted to ' . $this->title,
            'title' => $this->title,
            'url' => route('account.profile'),
        ]);
    }
}
