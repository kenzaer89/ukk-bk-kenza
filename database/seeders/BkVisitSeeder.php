<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BkVisit;
use App\Models\User;

class BkVisitSeeder extends Seeder
{
    public function run(): void
    {
        BkVisit::truncate();

        $student = User::where('role','student')->first();
        $teacher = User::where('role','guru_bk')->first();

        if ($student && $teacher) {
            BkVisit::create([
                'visit_date' => now(),
                'reason' => 'Konseling rutin',
                'student_id' => $student->id,
                'teacher_id' => $teacher->id
            ]);
        }
    }
}
