<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    /** @use HasFactory<\Database\Factories\ItemFactory> */
    use HasFactory;
    protected $fillable = ['name', 'description'];

    public function itemOptions()
    {
        return $this->belongsToMany(ItemOption::class, 'item_item_option', 'item_id', 'item_option_id');
    }

    public function packages()
    {
        return $this->belongsToMany(Package::class, 'package_items', 'item_id', 'package_id');
    }
    public function packageItems()
    {
        return $this->hasMany(PackageItem::class);
    }
    
}
