<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create student user
        User::updateOrCreate(
            ['email' => 'kenza@gmail.com'],
            [
                'name' => 'Kenza Erend Putratama',
                'password' => Hash::make('password'),
                'role' => 'student',
                'class_id' => 13,
                'absen' => '19',
                'specialization' => 'RPL',
                'points' => 100,
            ]
        );

        // Create admin user
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin BK',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Create guru_bk user
        User::updateOrCreate(
            ['email' => 'gurubk@gmail.com'],
            [
                'name' => 'Guru BK',
                'password' => Hash::make('password'),
                'role' => 'guru_bk',
            ]
        );

        echo "Test users created successfully!\n";
        echo "Student: kenza@gmail.com / password\n";
        echo "Admin: admin@gmail.com / password\n";
        echo "Guru BK: gurubk@gmail.com / password\n";
    }
}
