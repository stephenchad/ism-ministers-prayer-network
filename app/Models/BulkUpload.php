<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BulkUpload extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_name',
        'model_type',
        'status',
        'uploaded_by',
        'error_log',
    ];

    protected $casts = [
        'error_log' => 'array',
    ];

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
