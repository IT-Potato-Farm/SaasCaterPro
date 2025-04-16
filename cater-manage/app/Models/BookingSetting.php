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
        'rest_time',
    ];
    

    protected $casts = [
        'blocked_dates' => 'array',
    ];
    public function getFormattedServiceStartTimeAttribute()
    {
        return date('H:i', strtotime($this->service_start_time));
    }

    public function getFormattedServiceEndTimeAttribute()
    {
        return date('H:i', strtotime($this->service_end_time));
    }

    public function getDisplayServiceStartTimeAttribute()
    {
        return date('g:i A', strtotime($this->service_start_time));
    }

    public function getDisplayServiceEndTimeAttribute()
    {
        return date('g:i A', strtotime($this->service_end_time));
    }
}
