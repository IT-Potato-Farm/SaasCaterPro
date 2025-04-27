<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ReviewSectionSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ReviewSectionSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ReviewSectionSetting::create([
            'title' => 'What Our Customers Say'
        ]);
    }
}
