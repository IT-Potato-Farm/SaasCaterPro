<?php

namespace Database\Seeders;

use App\Models\BookingSetting;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BookingSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BookingSetting::firstOrCreate([
            'id' => 1,
        ], [
            'service_start_time' => '08:00:00',
            'service_end_time' => '20:00:00',
            'events_per_day' => 2,
            'blocked_dates' => [],
        ]);
    }
}
