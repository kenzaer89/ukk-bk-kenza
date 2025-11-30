<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SchoolClass;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classes = [
            // XII TPM 1-4
            ['name' => 'XII TPM 1', 'jurusan' => 'TPM'],
            ['name' => 'XII TPM 2', 'jurusan' => 'TPM'],
            ['name' => 'XII TPM 3', 'jurusan' => 'TPM'],
            ['name' => 'XII TPM 4', 'jurusan' => 'TPM'],
            
            // XII TKR 1-8
            ['name' => 'XII TKR 1', 'jurusan' => 'TKR'],
            ['name' => 'XII TKR 2', 'jurusan' => 'TKR'],
            ['name' => 'XII TKR 3', 'jurusan' => 'TKR'],
            ['name' => 'XII TKR 4', 'jurusan' => 'TKR'],
            ['name' => 'XII TKR 5', 'jurusan' => 'TKR'],
            ['name' => 'XII TKR 6', 'jurusan' => 'TKR'],
            ['name' => 'XII TKR 7', 'jurusan' => 'TKR'],
            ['name' => 'XII TKR 8', 'jurusan' => 'TKR'],

            // XII RPL
            ['name' => 'XII RPL', 'jurusan' => 'RPL'],

            // XII TITL 1-2
            ['name' => 'XII TITL 1', 'jurusan' => 'TITL'],
            ['name' => 'XII TITL 2', 'jurusan' => 'TITL'],
        ];

        foreach ($classes as $class) {
            SchoolClass::updateOrCreate(
                ['name' => $class['name']],
                ['jurusan' => $class['jurusan']]
            );
        }
    }
}
