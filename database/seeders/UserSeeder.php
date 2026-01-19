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
            ]
        );

    }
}
