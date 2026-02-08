<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\BulkUpload;

class BulkUploadCompleted extends Notification implements ShouldQueue
{
      use Queueable;

      protected $bulkUpload;

      /**
       * Create a new notification instance.
       */
      public function __construct(BulkUpload $bulkUpload)
      {
            $this->bulkUpload = $bulkUpload;
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
                  ->subject('Bulk Upload Completed')
                  ->line('A bulk upload has been completed successfully.')
                  ->line('File: ' . $this->bulkUpload->file_name)
                  ->line('Model Type: ' . $this->bulkUpload->model_type)
                  ->line('Uploaded by: ' . $this->bulkUpload->uploader->name)
                  ->action('View Details', route('admin.bulk-uploads.show', $this->bulkUpload->id))
                  ->line('Thank you for using the bulk upload system!');
      }

      /**
       * Get the array representation of the notification.
       *
       * @return array<string, mixed>
       */
      public function toArray(object $notifiable): array
      {
            return [
                  'message' => 'A bulk upload has been completed.',
                  'url' => route('admin.bulk-uploads.show', $this->bulkUpload->id),
                  'bulk_upload_id' => $this->bulkUpload->id,
                  'file_name' => $this->bulkUpload->file_name,
                  'model_type' => $this->bulkUpload->model_type,
                  'uploaded_by' => $this->bulkUpload->uploader->name,
            ];
      }
}
