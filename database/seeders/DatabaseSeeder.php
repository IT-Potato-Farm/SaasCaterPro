<?php

namespace Database\Seeders;

use App\Models\BookingSetting;
use App\Models\NavbarSetting;
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
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            UserSeeder::class,
        ]);
        $this->call(UserSeeder::class);
        $this->call(BookingSettingSeeder::class);
        $this->call(HeroSectionSeeder::class);
        $this->call(WhyChooseUsSectionSeeder::class);
        $this->call(AboutUsSectionSeeder::class);
        $this->call(FooterSectionSeeder::class);
        $this->call(PrivacyPolicySeeder::class);
        $this->call(NavbarSettingSeeder::class);
    }
}
