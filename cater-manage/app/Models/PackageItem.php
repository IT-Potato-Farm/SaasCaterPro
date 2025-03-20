<?php

namespace App\Models;

use App\Models\PackageFoodItemOption;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PackageItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'package_id',
        'name',
        'description',
        
    ];

    public function package(){
        return $this->belongsTo(Package::class);
    }
    public function options()
    {
        return $this->hasMany(PackageFoodItemOption::class, 'package_food_item_id');
    }
}
