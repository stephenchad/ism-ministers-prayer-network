<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stream extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'stream_url',
        'format',
        'type',
        'is_active',
        'scheduled_at'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'scheduled_at' => 'datetime'
    ];
}
