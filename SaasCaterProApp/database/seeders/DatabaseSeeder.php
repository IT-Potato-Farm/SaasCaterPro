<?php

namespace Database\Seeders;

use App\Models\listing;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(5)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        listing::factory(6)->create();
        

        // listing::create([
        //     'title' => 'Laravel Senior Developer',
        //     'tags'  => 'laravel, javascript',
        //     'company' => 'Acme Corp',
        //     'location' => 'Boston, MA',
        //     'email' => 'email1@gmail.com',
        //     'website' => 'https://www.acme.com',
        //     'description' => 'lorem impsum dolor sit amet consectetur'
        // ]);

        // listing::create([
        //     'title' => 'Full-Stack Developer',
        //     'tags'  => 'laravel, backend, api',
        //     'company' => 'Stark Industries',
        //     'location' => 'New York, NY',
        //     'email' => 'email2@gmail.com',
        //     'website' => 'https://www.starkindustries.com',
        //     'description' => 'lorem impsum dolor sit amet consectetur'
        // ]);

    }
}
