<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'first_name' => 'John Emman',
                'last_name'  => 'Juaquera',
                'email'      => 'jjohnemman@gmail.com',
                'password'   => Hash::make('Johnemman1'),
                'mobile'     => '09158500364',
                'role'       => 'admin',
                'email_verified_at' => now(),
            ],
            [
                'first_name' => 'Kaoruko',
                'last_name'  => 'Waguri',
                'email'      => 'jjuaquera2@gmail.com',
                'password'   => Hash::make('Johnemman1'),
                'mobile'     => '09158500361',
                'role'       => 'customer',
                'email_verified_at' => now(),
            ],
            [
                'first_name' => 'Quu',
                'last_name'  => 'Shukra',
                'email'      => 'johnemmanjuaquera07@gmail.com',
                'password'   => Hash::make('Johnemman1'),
                'mobile'     => '09175678901',
                'role'       => 'customer',
                'email_verified_at' => now(),
            ]
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']], // Avoid duplicates by email
                $user
            );
        }
    
    }
}
