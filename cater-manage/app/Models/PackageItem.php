<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PackageItem extends Model
{
    use HasFactory;

    protected $fillable = ['package_id', 'menu_item_id'];

    public function package(){
        return $this->belongsTo(Package::class);
    }
    public function menuItem()
    {
        return $this->belongsTo(MenuItem::class);
    }
}
