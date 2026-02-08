<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Radio extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'stream_url',
        'genre',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function schedules()
    {
        return $this->hasMany(RadioSchedule::class);
    }
}
