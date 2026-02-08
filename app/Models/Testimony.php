<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimony extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'location',
        'category',
        'title',
        'testimony',
        'allow_publish'
    ];
}
