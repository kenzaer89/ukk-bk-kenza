<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ParentStudentSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('parent_student')->truncate();

        $parent = User::where('role','parent')->first();
        $students = User::where('role','student')->take(3)->get();

        foreach($students as $student){
            DB::table('parent_student')->insert([
                'parent_id' => $parent->id,
                'student_id' => $student->id,
                'relation_type' => 'Orang Tua'
            ]);
        }
    }
}
