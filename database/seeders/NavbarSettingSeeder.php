<?php

namespace Database\Seeders;

use App\Models\NavbarSetting;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NavbarSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NavbarSetting::create([
            'logo' => 'images/saaslogo.png', // default logo path
            'title' => 'SaasCaterPro',
        ]);
    }
}
