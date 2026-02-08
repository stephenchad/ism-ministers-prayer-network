<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

class NewReferralNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $newUser;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $newUser)
    {
        $this->newUser = $newUser;
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
                    ->subject('New Referral Signup')
                    ->line('Congratulations! A new user has signed up using your referral link.')
                    ->line('New user: ' . $this->newUser->name . ' (' . $this->newUser->email . ')')
                    ->action('View Referrals', route('account.profile') . '#referrals-section')
                    ->line('Thank you for helping grow our community!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'A new user has signed up using your referral link!',
            'url' => route('account.profile') . '#referrals-section',
            'new_user_name' => $this->newUser->name,
            'new_user_email' => $this->newUser->email,
        ];
    }
}
