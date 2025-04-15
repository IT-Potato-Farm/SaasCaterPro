<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingSetting extends Model
{
    protected $fillable = [
        'service_start_time',
        'service_end_time',
        'events_per_day',
        'blocked_dates',
    ];

    protected $casts = [
        'blocked_dates' => 'array',
    ];
}
