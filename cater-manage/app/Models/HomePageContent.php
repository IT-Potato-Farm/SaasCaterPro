<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomePageContent extends Model
{
    protected $table = 'home_page_content';

    protected $fillable = [
        'section_name',
        'title',
        'heading',
        'description',
        'image',
        'background_color',
        'text_color',
        'button_text_1_color',
        'button_color_1',
        'button_text_2_color',
        'button_color_2',
    ];
}
