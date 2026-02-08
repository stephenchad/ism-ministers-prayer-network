<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorshipMusic extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'artist',
        'description',
        'music_type',
        'file_path',
        'file_size',
        'duration',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];
}