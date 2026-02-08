<?php

namespace App\Notifications;

use App\Models\Group;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewGroupCreated extends Notification implements ShouldBroadcast
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
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'group_id' => $this->group->id,
            'group_name' => $this->group->title,
            'message' => 'A new prayer group has been created: "' . $this->group->title . '". Check it out!',
            'url' => route('groups.index'), // Or a direct link to the group
        ];
    }

    /**
     * Get the broadcastable representation of the notification.
     */
    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'group_id' => $this->group->id,
            'group_name' => $this->group->title,
            'message' => 'A new prayer group has been created: "' . $this->group->title . '". Check it out!',
            'url' => route('groups.index'),
        ]);
    }
}