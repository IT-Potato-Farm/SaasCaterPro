<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PrivacyPolicy extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'content', 'last_updated', 'sections',
    ];

    protected $casts = [
        'sections' => 'array', 
    ];
}
