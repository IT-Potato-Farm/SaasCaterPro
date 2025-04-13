<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id'];

    // sa isang cart maraming items
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // HELPER METHOD PARA KUNIN AGAD I
    public function hasPackageItem()
    {
        return $this->orderItems->contains(function ($cartItem) {
            return $cartItem->itemable instanceof \App\Models\Package;
        });
    }
}
