<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Violation;
use App\Models\User;
use App\Models\Rule;

class ViolationSeeder extends Seeder
{
    public function run(): void
    {
        Violation::truncate();

        $student = User::where('role','student')->first();
        $rule = Rule::first();

        Violation::create([
            'student_id' => $student->id,
            'rule_id' => $rule->id,
            'violation_date' => now(),
            'notes' => 'Siswa terlambat masuk kelas'
        ]);
    }
}
