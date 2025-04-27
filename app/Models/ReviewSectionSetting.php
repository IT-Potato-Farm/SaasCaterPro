<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewSectionSetting extends Model
{
    protected $fillable = ['title', 'featured_reviews', 'max_display'];

    protected $casts = [
        'featured_reviews' => 'array', 
    ];
}
