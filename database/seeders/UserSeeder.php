<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin Utama (System Admin)
        User::firstOrCreate(
            ['email' => 'admin@bk.test'],
            [
                'name' => 'System Administrator',
                'role' => 'admin',
                'password' => Hash::make('password'),
            ]
        );

        // Daftar Guru BK
        $guruBK = [
            ['name' => 'Bu Prapti', 'email' => 'prapti@bk.test'],
            ['name' => 'Bu Eka', 'email' => 'eka@bk.test'],
            ['name' => 'Bu Pur', 'email' => 'pur@bk.test'],
        ];

        foreach ($guruBK as $guru) {
            User::firstOrCreate(
                ['email' => $guru['email']],
                [
                    'name' => $guru['name'],
                    'role' => 'guru_bk',
                    'password' => Hash::make('password'),
                ]
            );
        }

        // Tambah 1 akun siswa default supaya bisa login
        User::firstOrCreate(
            ['email' => 'siswa@bk.test'],
            [
                'name' => 'Siswa Contoh',
                'role' => 'student',
                'password' => Hash::make('password'),
            ]
        );

        // Tambah 1 akun orang tua default
        User::firstOrCreate(
            ['email' => 'orangtua@bk.test'],
            [
                'name' => 'Orang Tua Contoh',
                'role' => 'parent',
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
