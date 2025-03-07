<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'item_reference_id', 'item_type', 'quantity', 'price'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
