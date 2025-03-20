<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PackageFoodItemOption extends Model
{
    use HasFactory;
    protected $fillable = [
        'package_food_item_id',
        'type',
        'description',
        'image',
    ];

    public function packageItem()
    {
        return $this->belongsTo(PackageItem::class);
    }
}
