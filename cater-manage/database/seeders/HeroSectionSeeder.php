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
            'title' => 'SAAS',
            'subtitle' => 'CATERING AND FOOD SERVICES',
            'description' => 'Offers an exquisite goodness taste of Halal Cuisine',
        ]);
    }
}
