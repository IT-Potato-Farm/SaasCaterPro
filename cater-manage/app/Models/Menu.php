<?php

namespace App\Models;

use App\Models\MenuItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;
    protected $primaryKey = 'id'; 

    protected $fillable = ['name', 'description'] ;

    public function menuItems(){
        return $this->hasMany(MenuItem::class, 'menu_id');
    }
}
