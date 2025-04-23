<?php

namespace App\Models;

use App\Models\PackageFoodItemOption;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PackageItem extends Model
{
    use HasFactory;

    protected $fillable = ['package_id', 'item_id'];

    public function package(){
        return $this->belongsTo(Package::class);
    }
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
    public function options()
    {
        return $this->hasMany(PackageItemOption::class, 'package_item_id');
    }
}
