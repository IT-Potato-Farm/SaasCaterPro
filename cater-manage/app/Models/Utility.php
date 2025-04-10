<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Utility extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'image', 'quantity'];

    public function packages()
    {
        return $this->belongsToMany(Package::class, 'package_utilities')->withTimestamps();
    }
}
