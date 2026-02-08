<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'user_id',
        'title',
        'description',
        'event_date',
        'location',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}