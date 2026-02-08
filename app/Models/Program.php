<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'details',
        'schedule',
        'location',
        'icon',
        'color',
        'image',
        'status'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($program) {
            $program->slug = Str::slug($program->title);
        });
    }
}
