<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemOption extends Model
{
    /** @use HasFactory<\Database\Factories\ItemOptionFactory> */
    use HasFactory;

    protected $fillable = ['item_id', 'type', 'image', 'description'];

    
    public function items()
    {
        return $this->belongsToMany(Item::class, 'item_item_option',  'item_option_id', 'item_id');
    }

    public function packageItemOptions()
    {
        return $this->hasMany(PackageItemOption::class);
    }
}
