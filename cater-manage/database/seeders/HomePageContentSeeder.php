<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HomePageContentSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('home_page_content')->insert([
            'section_name' => 'navbar',
            'title' => 'SaasCaterPro',
            'image' => 'saaslogo.png', // Use a path or URL for the logo image
            'background_color' => '#000000',
            'text_color' => '#FF3939',
            'button_text_1_color' => '#ffffff',
            'button_color_1' => '#FF9339',
            'button_text_2_color' => '#ffffff',
            'button_color_2' => '#FF3939',
        ]);
    }
}
