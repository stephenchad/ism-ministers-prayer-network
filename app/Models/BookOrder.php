<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_id',
        'book_id',
        'status',
        'amount',
        'completed_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'completed_at' => 'datetime',
    ];

    /**
     * Get the user that owns the order
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for completed orders
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope for pending orders
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
