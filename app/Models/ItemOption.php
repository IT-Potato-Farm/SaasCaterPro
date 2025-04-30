<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemOption extends Model
{
    /** @use HasFactory<\Database\Factories\ItemOptionFactory> */
    use HasFactory;

    protected $fillable = [ 'type', 'image', 'description', 'category_id'];

    // pivot into item_item_option
    public function items()
    {
        return $this->belongsToMany(Item::class, 'item_item_option',  'item_option_id', 'item_id');
    }

    public function packageItemOptions()
    {
        return $this->hasMany(PackageItemOption::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
