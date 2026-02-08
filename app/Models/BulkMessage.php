<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BulkMessage extends Model
{
      use HasFactory;

      protected $fillable = [
            'type',
            'subject',
            'message',
            'recipients',
            'total_recipients',
            'sent_count',
            'failed_count',
            'failed_recipients',
            'sent_at',
            'sent_by',
      ];

      protected $casts = [
            'recipients' => 'array',
            'failed_recipients' => 'array',
            'sent_at' => 'datetime',
      ];

      public function sender()
      {
            return $this->belongsTo(User::class, 'sent_by');
      }
}
