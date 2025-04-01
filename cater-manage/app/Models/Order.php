<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total',
        'status',
        'event_type',
        'event_date_start',
        'event_date_end',
        'event_address',
        'total_guests',
        'concerns',
        'event_start_time',
        'event_start_end'
    ];
    public function scopePendingForUser($query, $userId) {
        return $query->where('user_id', $userId)
                    ->where('status', 'pending');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getPaidAttribute()
    {
        return $this->status === 'paid';
    }
}
