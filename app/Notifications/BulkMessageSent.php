<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\BulkMessage;

class BulkMessageSent extends Notification implements ShouldQueue
{
      use Queueable;

      protected $bulkMessage;

      /**
       * Create a new notification instance.
       */
      public function __construct(BulkMessage $bulkMessage)
      {
            $this->bulkMessage = $bulkMessage;
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
                  ->subject('Bulk Message Sent')
                  ->line('A bulk message has been sent successfully.')
                  ->line('Type: ' . $this->bulkMessage->type)
                  ->line('Subject: ' . $this->bulkMessage->subject)
                  ->line('Recipients: ' . $this->bulkMessage->total_recipients)
                  ->line('Sent by: ' . $this->bulkMessage->sender->name)
                  ->action('View Details', route('admin.bulk-messages.show', $this->bulkMessage->id))
                  ->line('Thank you for using the bulk messaging system!');
      }

      /**
       * Get the array representation of the notification.
       *
       * @return array<string, mixed>
       */
      public function toArray(object $notifiable): array
      {
            return [
                  'message' => 'A bulk message has been sent.',
                  'url' => route('admin.bulk-messages.show', $this->bulkMessage->id),
                  'bulk_message_id' => $this->bulkMessage->id,
                  'type' => $this->bulkMessage->type,
                  'subject' => $this->bulkMessage->subject,
                  'total_recipients' => $this->bulkMessage->total_recipients,
                  'sent_by' => $this->bulkMessage->sender->name,
            ];
      }
}
