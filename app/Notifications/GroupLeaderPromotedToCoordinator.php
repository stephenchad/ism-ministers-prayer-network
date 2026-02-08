<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class GroupLeaderPromotedToCoordinator extends Notification implements ShouldBroadcast
{
    use Queueable;

    protected $promotedUser;
    protected $title;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $promotedUser, string $title)
    {
        $this->promotedUser = $promotedUser;
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
                    ->subject('Group Leader Promoted to ' . $this->title)
                    ->greeting('Hello ' . $notifiable->name . ',')
                    ->line($this->promotedUser->name . ' has been promoted to ' . $this->title . '.')
                    ->line('Congratulations to ' . $this->promotedUser->name . ' for their leadership achievements!')
                    ->action('View Profile', route('account.profile'))
                    ->line('Thank you for being part of our community!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => $this->promotedUser->name . ' has been promoted to ' . $this->title,
            'promoted_user_name' => $this->promotedUser->name,
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
            'message' => $this->promotedUser->name . ' has been promoted to ' . $this->title,
            'promoted_user_name' => $this->promotedUser->name,
            'title' => $this->title,
            'url' => route('account.profile'),
        ]);
    }
}
