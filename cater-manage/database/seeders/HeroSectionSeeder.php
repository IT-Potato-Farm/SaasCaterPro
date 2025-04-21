<?php

namespace Database\Seeders;

use App\Models\HeroSection;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class HeroSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HeroSection::create([
            'background_image' => 'images/sectionhero.jpg',
            'title' => trim(preg_replace('/\s+/', ' ', 'SAAS')),
            'subtitle' => trim(preg_replace('/\s+/', ' ', 'CATERING AND FOOD SERVICES')),
            'description' => trim(preg_replace('/\s+/', ' ', 'Offers an exquisite goodness taste of Halal Cuisine')),
        ]);

        
    }
}
