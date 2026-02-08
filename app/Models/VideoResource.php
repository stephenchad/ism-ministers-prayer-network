<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoResource extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'video_url',
        'video_file',
        'video_type',
        'duration',
        'thumbnail',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];
}
