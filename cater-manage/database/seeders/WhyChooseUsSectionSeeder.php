<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WhyChooseUsSection;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class WhyChooseUsSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WhyChooseUsSection::create([
            'title' => trim(preg_replace('/\s+/', ' ', 'WHY CHOOSE US')),
            'subtitle' => trim(preg_replace('/\s+/', ' ', 'The all-in-one solution for effortless order tracking and customer engagement services in Zamboanga City')),
            'description' => trim(preg_replace('/\s+/', ' ', 'We are more than just your typical catering company at Saas. We are committed to turning your visions into reality.
                Our goal is to help create an incomparable experience by going above and beyond through our food offerings,
                service, and styling that is tailored to your taste and budget without skimping on quality.'))
        ]);
    }
}
