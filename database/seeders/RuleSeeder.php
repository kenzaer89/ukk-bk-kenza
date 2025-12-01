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

        // Isi data baru dengan jenis pelanggaran dan poin
        Rule::create([
            'name' => 'Terlambat',
            'description' => 'Datang terlambat ke sekolah',
            'category' => 'Kedisiplinan',
            'points' => -10
        ]);
        
        Rule::create([
            'name' => 'Bolos',
            'description' => 'Tidak masuk tanpa keterangan',
            'category' => 'Kehadiran',
            'points' => -20
        ]);
        
        Rule::create([
            'name' => 'Merokok',
            'description' => 'Merokok di lingkungan sekolah',
            'category' => 'Pelanggaran Berat',
            'points' => -20
        ]);
        
        Rule::create([
            'name' => 'Hamil',
            'description' => 'Hamil di luar nikah',
            'category' => 'Pelanggaran Sangat Berat',
            'points' => -50
        ]);
        
        Rule::create([
            'name' => 'Tawuran',
            'description' => 'Terlibat perkelahian/tawuran',
            'category' => 'Pelanggaran Sangat Berat',
            'points' => -50
        ]);
        
        Rule::create([
            'name' => 'Memakai Obat-obat Terlarang',
            'description' => 'Menggunakan narkoba atau obat-obatan terlarang',
            'category' => 'Pelanggaran Sangat Berat',
            'points' => -50
        ]);
    }
}