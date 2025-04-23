<?php

namespace Database\Seeders;

use App\Models\PrivacyPolicy;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PrivacyPolicySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PrivacyPolicy::create([
            'title' => 'Privacy Policy',
            'content' => '<p>This is our privacy policy content.</p>',
            'last_updated' => now()->format('Y-m-d'),
            'sections' => json_encode([
                'data_collection' => 'We collect your data responsibly.',
                'usage' => 'We use your data to improve our service.',
            ]),
        ]);
    }
}
