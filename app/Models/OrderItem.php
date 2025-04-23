<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'item_reference_id', 'item_type', 'quantity', 'price', 'variant', 'selected_options', 'included_utilities'
    ];
    protected $casts = [
        'selected_options' => 'array',
        'included_utilities' => 'array',
    ];
    public function itemable()
    {
        return $this->morphTo(null, 'item_type', 'item_reference_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
