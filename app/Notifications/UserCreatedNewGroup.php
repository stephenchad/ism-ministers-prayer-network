<?php

namespace App\Notifications;

use App\Models\Group;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class UserCreatedNewGroup extends Notification implements ShouldBroadcast
{
    use Queueable;

    public $group;
    public $creator;

    /**
     * Create a new notification instance.
     */
    public function __construct(Group $group, User $creator)
    {
        $this->group = $group;
        $this->creator = $creator;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $message = 'User "' . $this->creator->name . '" has created a new group: "' . $this->group->title . '".';

        return [
            'group_id' => $this->group->id,
            'group_name' => $this->group->title,
            'creator_name' => $this->creator->name,
            'message' => $message,
            'url' => route('admin.groups.show', $this->group->id),
        ];
    }

    /**
     * Get the broadcastable representation of the notification.
     */
    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        $message = 'User "' . $this->creator->name . '" has created a new group: "' . $this->group->title . '".';

        return new BroadcastMessage([
            'group_id' => $this->group->id,
            'group_name' => $this->group->title,
            'creator_name' => $this->creator->name,
            'message' => $message,
            'url' => route('admin.groups.show', $this->group->id),
        ]);
    }
}
