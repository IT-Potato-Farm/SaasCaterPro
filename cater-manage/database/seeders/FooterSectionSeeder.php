<?php

namespace Database\Seeders;

use App\Models\FooterSection;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FooterSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FooterSection::create([
            'company_name' => preg_replace('/\s+/', ' ', trim('Saas - Catering and Food Services')),
            'description' => preg_replace('/\s+/', ' ', trim('Premium catering services in Zamboanga City')),
            'phone' => preg_replace('/\s+/', '', trim('0954 317 1208')),
            'facebook' => trim('https://www.facebook.com/profile.php?id=61557186841557'),
            'address' => preg_replace('/\s+/', ' ', trim('015 Ayer Village Zamboanga City')),
            
            'logo' => trim('images/saaslogo.png'),
            'copyright' => preg_replace('/\s+/', ' ', trim('© 2025 Saas Catering Services. All rights reserved.')),
        ]);
    }
}
