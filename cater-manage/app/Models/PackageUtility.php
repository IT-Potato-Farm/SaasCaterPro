<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PackageUtility extends Model
{
    use HasFactory;

    protected $fillable = [
        'package_id',
        'name',
        'description',
        'quantity',
        'image',
    ];

    // eacjh util belongs to package.
    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
