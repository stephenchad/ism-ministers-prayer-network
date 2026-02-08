<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RadioSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'radio_id',
        'day_of_week',
        'start_time',
        'end_time',
        'program_name',
        'host_name',
        'description'
    ];

    public function radio()
    {
        return $this->belongsTo(Radio::class);
    }
}