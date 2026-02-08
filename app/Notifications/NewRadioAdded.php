<?php

namespace App\Notifications;

use App\Models\Radio;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class NewRadioAdded extends Notification implements ShouldBroadcast
{
      use Queueable;

      protected $radio;

      public function __construct(Radio $radio)
      {
            $this->radio = $radio;
      }

      public function via(object $notifiable): array
      {
            return ['database', 'broadcast'];
      }

      public function toArray(object $notifiable): array
      {
            return [
                  'radio_id' => $this->radio->id,
                  'radio_name' => $this->radio->name,
                  'message' => 'A new radio station has been added: "' . $this->radio->name . '". Tune in now!',
                  'url' => route('radio'),
            ];
      }

      public function toBroadcast(object $notifiable): BroadcastMessage
      {
            return new BroadcastMessage([
                  'radio_id' => $this->radio->id,
                  'radio_name' => $this->radio->name,
                  'message' => 'A new radio station has been added: "' . $this->radio->name . '". Tune in now!',
                  'url' => route('radio'),
            ]);
      }
}