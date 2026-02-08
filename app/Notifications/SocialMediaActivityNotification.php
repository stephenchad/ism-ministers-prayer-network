<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class SocialMediaActivityNotification extends Notification implements ShouldBroadcast
{
      use Queueable;

      public $user;
      public $provider;
      public $activityType;

      /**
       * Create a new notification instance.
       */
      public function __construct(User $user, string $provider, string $activityType)
      {
            $this->user = $user;
            $this->provider = $provider;
            $this->activityType = $activityType;
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
            $message = 'User "' . $this->user->name . '" has logged in using ' . ucfirst($this->provider) . '.';

            if ($this->activityType === 'share') {
                  $message = 'User "' . $this->user->name . '" has shared content on ' . ucfirst($this->provider) . '.';
            }

            return [
                  'user_id' => $this->user->id,
                  'user_name' => $this->user->name,
                  'provider' => $this->provider,
                  'activity_type' => $this->activityType,
                  'message' => $message,
                  'url' => route('admin.users.edit', $this->user->id),
            ];
      }

      /**
       * Get the broadcastable representation of the notification.
       */
      public function toBroadcast(object $notifiable): BroadcastMessage
      {
            $message = 'User "' . $this->user->name . '" has logged in using ' . ucfirst($this->provider) . '.';

            if ($this->activityType === 'share') {
                  $message = 'User "' . $this->user->name . '" has shared content on ' . ucfirst($this->provider) . '.';
            }

            return new BroadcastMessage([
                  'user_id' => $this->user->id,
                  'user_name' => $this->user->name,
                  'provider' => $this->provider,
                  'activity_type' => $this->activityType,
                  'message' => $message,
                  'url' => route('admin.users.edit', $this->user->id),
            ]);
      }
}
