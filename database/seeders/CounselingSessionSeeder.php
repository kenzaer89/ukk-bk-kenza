<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CounselingSession;
use App\Models\CounselingSchedule;
use Carbon\Carbon;

class CounselingSessionSeeder extends Seeder
{
    public function run(): void
    {
        // Nonaktifkan FK check sementara
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        CounselingSession::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $schedule = CounselingSchedule::first();

        if (!$schedule) {
            $this->command->warn('⚠️ Tidak ada counseling schedule, lewati CounselingSessionSeeder.');
            return;
        }

        CounselingSession::create([
            'schedule_id' => $schedule->id,
            'session_date' => Carbon::now()->addDays(3)->toDateString(),
            'teacher_notes' => 'Siswa perlu meningkatkan fokus belajar.',
            'recommendations' => 'Berikan dukungan tambahan dari wali kelas dan orang tua.',
        ]);
    }
}
