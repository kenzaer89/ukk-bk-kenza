<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Nonaktifkan FK sementara agar truncate tidak error
        Schema::disableForeignKeyConstraints();
        User::truncate();
        Schema::enableForeignKeyConstraints();

        // 🧑‍🏫 Admin / Guru BK
        User::factory()->create([
            'name' => 'Guru BK',
            'email' => 'guru_bk@bk.test',
            'role' => 'guru_bk',
            'password' => bcrypt('password'),
        ]);

        // 👨‍💼 Admin sekolah (opsional)
        User::factory()->create([
            'name' => 'Admin Sekolah',
            'email' => 'admin@bk.test',
            'role' => 'admin',
            'password' => bcrypt('password'),
        ]);

        // 🎓 Beberapa siswa
        User::factory(10)->create([
            'role' => 'student',
        ]);

        // 👨‍👩‍👧 Beberapa orang tua
        User::factory(5)->create([
            'role' => 'parent',
        ]);

        // 🧑‍🏫 Beberapa wali kelas
        User::factory(3)->create([
            'role' => 'wali_kelas',
        ]);
    }
}
