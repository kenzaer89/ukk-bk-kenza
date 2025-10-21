<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin Utama (tidak boleh hilang)
        User::firstOrCreate(
            ['email' => 'admin@bk.test'],
            [
                'name' => 'Admin Sekolah',
                'role' => 'admin',
                'password' => Hash::make('password'),
            ]
        );

        // Guru BK (jika belum ada)
        User::firstOrCreate(
            ['email' => 'guru_bk@bk.test'],
            [
                'name' => 'Guru BK',
                'role' => 'guru_bk',
                'password' => Hash::make('password'),
            ]
        );

        // Tambah siswa jika belum ada sama sekali
        if (User::where('role', 'student')->count() == 0) {
            User::factory(10)->create(['role' => 'student']);
        }

        // Tambah orang tua
        if (User::where('role', 'parent')->count() == 0) {
            User::factory(5)->create(['role' => 'parent']);
        }

        // Tambah wali kelas
        if (User::where('role', 'wali_kelas')->count() == 0) {
            User::factory(3)->create(['role' => 'wali_kelas']);
        }
    }
}
