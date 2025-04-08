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
            'section_name' => 'footer',
            'title' => 'Saas - Catering and Food Services',
        ]);
    }
}

// php artisan db:seed --class=HomepageContentSeeder