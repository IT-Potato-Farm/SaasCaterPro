<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price_per_person',
        'min_pax',
        'image',
        'status',
    ];
    public function packageItems()
    {
        return $this->hasMany(PackageItem::class, 'package_id');
    }
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function utilities()
    {
        return $this->belongsToMany(Utility::class, 'package_utilities')->withTimestamps();
    }
}
