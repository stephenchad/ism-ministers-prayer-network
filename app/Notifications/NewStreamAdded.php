<?php

namespace App\Notifications;

use App\Models\Stream;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class NewStreamAdded extends Notification implements ShouldBroadcast
{
    use Queueable;

    protected $stream;

    public function __construct(Stream $stream)
    {
        $this->stream = $stream;
    }

    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray(object $notifiable): array
    {
        $message = $this->stream->type == 'live'
            ? 'A new live stream is starting soon: "' . $this->stream->title . '"'
            : 'A new recorded stream is available: "' . $this->stream->title . '"';

        return [
            'stream_id' => $this->stream->id,
            'stream_title' => $this->stream->title,
            'message' => $message,
            'url' => route('stream'),
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        $message = $this->stream->type == 'live'
            ? 'A new live stream is starting soon: "' . $this->stream->title . '"'
            : 'A new recorded stream is available: "' . $this->stream->title . '"';

        return new BroadcastMessage([
            'stream_id' => $this->stream->id,
            'stream_title' => $this->stream->title,
            'message' => $message,
            'url' => route('stream'),
        ]);
    }
}
