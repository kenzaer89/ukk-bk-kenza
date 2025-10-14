<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MonthlyReport;
use App\Models\User;

class MonthlyReportSeeder extends Seeder
{
    public function run(): void
    {
        MonthlyReport::truncate();

        $teacher = User::where('role','guru_bk')->first();

        MonthlyReport::create([
            'teacher_id' => $teacher->id,
            'month' => now()->month,
            'year' => now()->year,
            'summary' => 'Laporan bulanan BK'
        ]);
    }
}

