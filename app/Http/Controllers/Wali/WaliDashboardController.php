<?php

namespace App\Http\Controllers\Wali;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Violation;
use App\Models\CounselingSchedule;
use App\Models\CounselingSession;
use App\Models\Achievement;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class WaliDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // 1. Temukan Kelas yang diampu - Pastikan relasi ke students diload
        $class = SchoolClass::where('wali_kelas_id', $user->id)->with('students')->first();

        if (!$class) {
            return view('wali.dashboard', ['class' => null]);
        }
        
        $studentIds = $class->students->pluck('id');

        // 2. Statistik
        $stats = [
            'total_students' => $class->students->count(),
            'total_violations' => Violation::whereIn('student_id', $studentIds)->count(),
            'total_achievements' => Achievement::whereIn('student_id', $studentIds)->count(),
            'total_sessions' => CounselingSession::whereIn('student_id', $studentIds)->where('status', 'completed')->count(),
        ];

        // 3. Aktivitas Terbaru Kelas
        $recentViolations = Violation::with(['student', 'rule'])
            ->whereIn('student_id', $studentIds)
            ->latest()
            ->limit(5)
            ->get();

        $recentAchievements = Achievement::with('student')
            ->whereIn('student_id', $studentIds)
            ->latest()
            ->limit(5)
            ->get();

        $recentSessions = CounselingSession::with(['student', 'counselor'])
            ->whereIn('student_id', $studentIds)
            ->where('status', 'completed')
            ->latest()
            ->limit(5)
            ->get();

        // 4. Data Siswa untuk Monitoring Poin
        $students = $class->students->sortBy('points');

        return view('wali.dashboard', compact('class', 'stats', 'recentViolations', 'recentAchievements', 'recentSessions', 'students'));
    }

    public function monitoring()
    {
        $user = Auth::user();
        $class = SchoolClass::where('wali_kelas_id', $user->id)->with('students')->first();

        if (!$class) {
            return view('wali.monitoring', ['class' => null]);
        }

        $students = $class->students->sortBy('points');

        return view('wali.monitoring', compact('class', 'students'));
    }

    public function studentDetail(User $student)
    {
        $user = Auth::user();
        
        // Pastikan siswa berada di kelas yang diampu oleh wali kelas ini
        if ($student->class_id !== SchoolClass::where('wali_kelas_id', $user->id)->first()?->id) {
            abort(403, 'Anda tidak memiliki akses ke data siswa ini.');
        }

        $student->load([
            'schoolClass',
            'violations.rule',
            'achievements',
            'sessions' => function($query) {
                $query->where('status', 'completed')->with('counselor')->latest();
            }
        ]);

        return view('wali.student_show', compact('student'));
    }
}
