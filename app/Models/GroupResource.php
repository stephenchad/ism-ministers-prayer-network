<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupResource extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'title',
        'link',
        'description',
        'user_id',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
