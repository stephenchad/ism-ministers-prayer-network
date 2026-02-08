<?php

namespace App\Notifications;

use App\Models\Group;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class PromotedToGroupLeader extends Notification implements ShouldBroadcast
{
    use Queueable;

    protected $group;

    /**
     * Create a new notification instance.
     */
    public function __construct(Group $group)
    {
        $this->group = $group;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // We'll start with just database notifications.
        // You could add 'mail' here later if you want to send emails. // Now we add 'mail'
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $groupUrl = route('account.group.show', $this->group->id);

        return (new MailMessage)
                    ->subject('Congratulations! You are now a Group Leader')
                    ->greeting('Hello ' . $notifiable->name . ',')
                    ->line('You have been promoted to a leader in the group: "' . $this->group->title . '".')
                    ->line('You can now help manage the group members and other activities.')
                    ->action('View Group', $groupUrl)
                    ->line('Thank you for your commitment to our community!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'group_id' => $this->group->id,
            'group_name' => $this->group->title,
            'message' => 'You have been promoted to a leader in the group: ' . $this->group->title,
            'url' => route('account.group.show', $this->group->id),
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
            'group_name' => $this->group->title,
            'message' => 'You have been promoted to a leader in the group: ' . $this->group->title,
            'url' => route('account.group.show', $this->group->id),
        ]);
    }
}
