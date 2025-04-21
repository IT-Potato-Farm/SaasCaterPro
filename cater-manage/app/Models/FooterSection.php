<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FooterSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'description',
        'phone',
        'facebook',
        'address',
        
        'logo',
        'copyright',
    ];
}
