<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    //
    protected $fillable = [
        'menu_id',
        'category_id',
        'name',
        'description',
        
        'image',
        'status'
    ];

   
    public function category(){
        return $this->belongsTo(Category::class);
    }

}
