<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    use HasFactory;
    protected $primaryKey = 'id'; 

    protected $fillable = ['name', 'description'] ;

    public function itemOptions()
    {
        return $this->hasMany(ItemOption::class);
    }
}
