<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PackageUtility extends Model
{
    use HasFactory;

    protected $table = 'package_utilities';

    protected $fillable = ['package_id', 'utility_id'];

    // eacjh util belongs to package.
    public function package()
    {
        return $this->belongsTo(Package::class);
    }
    public function utility()
    {
        return $this->belongsTo(Utility::class);
    }
}
