<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\CounselingRequest;
use App\Models\User;

class CounselingRequestSeeder extends Seeder
{
    public function run(): void
    {
        // Nonaktifkan foreign key check sementara
        Schema::disableForeignKeyConstraints();

        // Kosongkan tabel tanpa melanggar FK
        DB::table('counseling_requests')->delete();

        // Aktifkan kembali FK
        Schema::enableForeignKeyConstraints();

        // Ambil 1 siswa dan 1 guru BK
        $student = User::where('role', 'student')->first();
        $teacher = User::where('role', 'guru_bk')->first();

        if ($student && $teacher) {
            CounselingRequest::create([
                'student_id' => $student->id,
                'teacher_id' => $teacher->id,
                'reason' => 'Konseling Akademik',
                'status' => 'pending'
            ]);
        }
    }
}
