<?php

namespace App\Notifications;

use App\Models\PrayerResource;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class NewPrayerResourceAdded extends Notification implements ShouldBroadcast
{
      use Queueable;

      protected $resource;

      public function __construct(PrayerResource $resource)
      {
            $this->resource = $resource;
      }

      public function via(object $notifiable): array
      {
            return ['database', 'broadcast'];
      }

      public function toArray(object $notifiable): array
      {
            return [
                  'resource_id' => $this->resource->id,
                  'resource_title' => $this->resource->title,
                  'message' => 'A new prayer resource is available: "' . $this->resource->title . '"',
                  'url' => route('prayer.resources'),
            ];
      }

      public function toBroadcast(object $notifiable): BroadcastMessage
      {
            return new BroadcastMessage([
                  'resource_id' => $this->resource->id,
                  'resource_title' => $this->resource->title,
                  'message' => 'A new prayer resource is available: "' . $this->resource->title . '"',
                  'url' => route('prayer.resources'),
            ]);
      }
}