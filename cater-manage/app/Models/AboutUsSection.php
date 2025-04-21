<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AboutUsSection extends Model
{
    use HasFactory;
    protected $fillable = ['background_image', 'title', 'description'];
}
