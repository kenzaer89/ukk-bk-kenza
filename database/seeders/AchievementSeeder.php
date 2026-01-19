<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Achievement;
use App\Models\User;

class AchievementSeeder extends Seeder
{
    public function run(): void
    {
        Achievement::truncate();

        $student = User::where('role','student')->first();

        if ($student) {
            Achievement::create([
                'student_id' => $student->id,
                'name' => 'Juara 1 Lomba Matematika',
                'level' => 'school',
                'point' => 10,
                'achievement_date' => now()
            ]);
        }
    }
}
