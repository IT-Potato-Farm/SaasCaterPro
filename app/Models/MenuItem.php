<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    //
    protected $fillable = [
        'menu_id',
        'category_id',
        'name',
        'description',
        'image',
        'status',
        'pricing'
    ];
    protected $casts = [
        'pricing' => 'array', //  converts JSON to an array
    ];
    public function getPriceForVariant($variant)
    {
        return $this->pricing[$variant] ?? 0;
    }
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
