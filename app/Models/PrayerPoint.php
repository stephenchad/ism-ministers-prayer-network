<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrayerPoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'status',
        'title_es',
        'title_fr',
        'title_zh',
        'title_ar',
        'content_es',
        'content_fr',
        'content_zh',
        'content_ar',
        'language'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
