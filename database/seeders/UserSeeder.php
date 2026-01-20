<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin Utama
        User::firstOrCreate(
            ['email' => 'adminbk@gmail.com'],
            [
                'name' => 'Admin BK',
                'role' => 'admin',
                'password' => Hash::make('password'),
                'phone' => '081122334455',
                'email_verified_at' => now(),
            ]
        );

        // Guru BK
        User::firstOrCreate(
            ['email' => 'gurubk@gmail.com'],
            [
                'name' => 'Guru BK',
                'role' => 'guru_bk',
                'password' => Hash::make('password'),
                'phone' => '082233445566',
                'email_verified_at' => now(),
            ]
        );

    }
}
