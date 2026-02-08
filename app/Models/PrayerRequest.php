<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrayerRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'prayer_type',
        'prayer_request',
        'status',
        'language'
    ];
}
