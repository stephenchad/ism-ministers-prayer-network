<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StreamParticipant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'country',
        'gender',
        'participants_count',
        'stream_id',
        'submitted_at',
    ];

    public function stream()
    {
        return $this->belongsTo(Stream::class);
    }
}
