<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rule;
use Illuminate\Support\Facades\Schema;

class RuleSeeder extends Seeder
{
    public function run(): void
    {
        // Nonaktifkan constraint foreign key sementara (praktik yang baik)
        Schema::disableForeignKeyConstraints();

        // Kosongkan tabel tanpa error
        Rule::truncate();

        // Aktifkan lagi setelah truncate
        Schema::enableForeignKeyConstraints();

        // Isi data baru
        // BARIS INI AKAN BERHASIL karena kita sudah nonaktifkan $timestamps di Model Rule
        Rule::create(['name' => 'Terlambat', 'description' => 'Datang terlambat ke sekolah', 'points' => 5]);
        Rule::create(['name' => 'Bolos', 'description' => 'Tidak masuk tanpa keterangan', 'points' => 10]);
    }
}