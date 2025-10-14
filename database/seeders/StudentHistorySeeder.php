<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StudentHistory;
use App\Models\User;

class StudentHistorySeeder extends Seeder
{
    public function run(): void
    {
        StudentHistory::truncate();

        $student = User::where('role','student')->first();

        StudentHistory::create([
            'student_id' => $student->id,
            'type' => 'counseling',
            'description' => 'Mengikuti konseling akademik',
            'event_date' => now()
        ]);
    }
}
