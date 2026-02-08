<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteStat extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'label',
        'value',
        'icon',
        'description',
        'page',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Get stats for a specific page
     */
    public static function getForPage($page = 'home')
    {
        return static::where('page', $page)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Get a stat by its key
     */
    public static function getByKey($key)
    {
        return static::where('key', $key)
            ->where('is_active', true)
            ->first();
    }
}
