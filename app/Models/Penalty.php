<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penalty extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'amount',
        'reason',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
