<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CartItem extends Model
{
    use HasFactory;


    protected $fillable = ['cart_id', 'menu_item_id', 'package_id', 'quantity', 'variant', 'selected_options', 'included_utilities'];

    protected $casts = [
        'selected_options' => 'array',
        'included_utilities' => 'array',
    ];
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }


    public function menuItem()
    {
        return $this->belongsTo(MenuItem::class);
    }
    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
