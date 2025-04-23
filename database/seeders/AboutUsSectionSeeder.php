<?php

namespace Database\Seeders;

use App\Models\AboutUsSection;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AboutUsSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AboutUsSection::create([
            'title' => 'About Us',
            'description' => preg_replace('/\s+/', ' ', trim(
                'Welcome to SaasCaterPro, your premier choice for exquisite food catering services. 
                With a passion for flavors and a commitment to excellence, we specialize in crafting delicious, 
                high-quality meals tailored to your events. Whether it\'s a wedding, corporate gathering, 
                or private party, our team ensures an unforgettable dining experience. 
                Let us bring the perfect taste to your special occasions!'
            )),
            'background_image' => null, // You can set a default if you want e.g. 'uploads/about-us/default.jpg'
        ]);
    }
}
