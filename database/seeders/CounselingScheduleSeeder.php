<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CounselingSchedule;
use App\Models\CounselingRequest;
use App\Models\User;
use Carbon\Carbon;

class CounselingScheduleSeeder extends Seeder
{
    public function run(): void
    {
        // Nonaktifkan foreign key checks sementara untuk hindari error TRUNCATE
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        CounselingSchedule::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Ambil data yang dibutuhkan
        $request = CounselingRequest::first();
        $teacher = User::where('role', 'guru_bk')->first();
        $student = User::where('role', 'student')->first();

        // Pastikan data ada
        if (!$request || !$teacher || !$student) {
            $this->command->warn('⚠️ Data guru_bk, student, atau counseling_request belum tersedia. Seeder dilewati.');
            return;
        }

        // Buat jadwal konseling (Mendatang)
        CounselingSchedule::create([
            'counseling_request_id' => $request->id,
            'student_id' => $student->id,
            'teacher_id' => $teacher->id,
            'scheduled_date' => Carbon::now()->addDays(2)->toDateString(),
            'start_time' => '09:00:00',
            'end_time' => '10:00:00',
            'status' => 'scheduled',
            'student_notes' => 'Persiapan konseling akademik',
            'admin_notes' => 'Dijadwalkan oleh guru BK',
        ]);

        // Buat jadwal konseling (Riwayat / Selesai)
        CounselingSchedule::create([
            'counseling_request_id' => $request->id,
            'student_id' => $student->id,
            'teacher_id' => $teacher->id,
            'scheduled_date' => Carbon::now()->subDays(5)->toDateString(),
            'start_time' => '10:00:00',
            'end_time' => '11:00:00',
            'status' => 'completed',
            'student_notes' => 'Konseling masalah belajar',
            'admin_notes' => 'Sesi selesai dengan baik',
        ]);
    }
}
