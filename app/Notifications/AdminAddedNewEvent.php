<?php

namespace App\Notifications;

use App\Models\Event;
use App\Models\Group;
use App\Models\GroupEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class AdminAddedNewEvent extends Notification implements ShouldBroadcast
{
      use Queueable;

      protected $group;
      protected $event;

      /**
       * Create a new notification instance.
       */
      public function __construct(Group $group, Event|GroupEvent $event)
      {
            $this->group = $group;
            $this->event = $event;
      }

      /**
       * Get the notification's delivery channels.
       *
       * @return array<int, string>
       */
      public function via(object $notifiable): array
      {
            return ['database', 'mail', 'broadcast'];
      }

      /**
       * Get the mail representation of the notification.
       */
      public function toMail(object $notifiable): MailMessage
      {
            $groupUrl = route('account.group.show', $this->group->id);

            return (new MailMessage)
                  ->subject('New Event in Your Group: ' . $this->group->title)
                  ->greeting('Hello ' . $notifiable->name . ',')
                  ->line('A new event has been added to your group, "' . $this->group->title . '".')
                  ->line('**Event:** ' . $this->event->title)
                  ->line('**Date:** ' . \Carbon\Carbon::parse($this->event->event_date)->format('M d, Y, h:i A'))
                  ->action('View Group Details', $groupUrl)
                  ->line('We look forward to seeing you there!');
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
                  'message' => 'A new event "' . $this->event->title . '" was added to your group: ' . $this->group->title,
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
                  'group_id' => $this->group->id,
                  'group_name' => $this->group->title,
                  'event_title' => $this->event->title,
                  'message' => 'A new event "' . $this->event->title . '" was added to your group: ' . $this->group->title,
                  'url' => route('account.group.show', $this->group->id),
            ]);
      }
}