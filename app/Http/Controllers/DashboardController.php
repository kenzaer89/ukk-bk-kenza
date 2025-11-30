<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ClassModel;
use App\Models\Violation;
use App\Models\Achievement; // PERBAIKAN: Ganti Models\Achievement menjadi App\Models\Achievement
use App\Models\MonthlyReport;
use App\Models\CounselingSession;
use App\Models\CounselingSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Menentukan dashboard mana yang akan ditampilkan berdasarkan role user.
     */
    public function index()
    {
        $user = Auth::user();
        $role = $user->role;

        switch ($role) {
            case 'admin':
                return $this->adminDashboard();
            case 'guru_bk':
                return $this->guruBkDashboard();
            case 'wali_kelas':
                return $this->waliKelasDashboard();
            case 'student':
                return $this->studentDashboard();
            case 'parent':
                return $this->parentDashboard();
            default:
                return view('dashboard.default');
        }
    }

    /**
     * Logika untuk Dashboard Administrator: Ringkasan Global.
     */
    private function adminDashboard()
    {
        $totalUsers = User::count();
        $totalClasses = ClassModel::count();
        $totalViolations = Violation::count();
        $totalAchievements = Achievement::count();

        // Top 5 Pelanggaran (Sepanjang Masa)
        $topViolations = Violation::select('rules.name', DB::raw('COUNT(violations.id) as count'))
            ->join('rules', 'violations.rule_id', '=', 'rules.id')
            ->groupBy('rules.name')
            ->orderByDesc('count')
            ->take(5)
            ->get();

        // Top 5 Siswa Poin Terendah
        $topViolatingStudents = User::where('role', 'student')
            ->orderBy('total_points', 'asc')
            ->take(5)
            ->get();
        
        $stats = compact('totalUsers', 'totalClasses', 'totalViolations', 'totalAchievements', 'topViolations', 'topViolatingStudents');
        
        return view('dashboard.admin', $stats);
    }
    
    /**
     * Logika untuk Dashboard Guru BK: Fokus Operasional Bulanan.
     */
    private function guruBkDashboard()
    {
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth()->toDateString();
        $endOfMonth = $now->copy()->endOfMonth()->toDateString();

        $userId = Auth::id();

        $violationsThisMonth = Violation::whereBetween('violation_date', [$startOfMonth, $endOfMonth])->count();
        $sessionsThisMonth = CounselingSession::whereBetween('session_date', [$startOfMonth, $endOfMonth])->count();
        
        // Laporan Bulanan yang masih berstatus Draf oleh guru BK ini
        $pendingReports = MonthlyReport::where('teacher_id', $userId)
            ->where('status', 'draft')
            ->count();
            
        // Pelanggaran yang statusnya 'pending'
        $pendingViolations = Violation::where('status', 'pending')->count(); 

        // Top 3 Siswa Pelanggar Bulan Ini
        $topViolatingStudents = Violation::select('student_id')
            ->selectRaw('SUM(rules.points) as total_points_deducted')
            ->whereBetween('violation_date', [$startOfMonth, $endOfMonth])
            ->join('rules', 'violations.rule_id', '=', 'rules.id')
            ->groupBy('student_id')
            ->orderByDesc('total_points_deducted')
            ->take(3)
            ->with(['student' => function($q) { 
                $q->with('schoolClass'); 
            }]) 
            ->get();
            
        $stats = compact('violationsThisMonth', 'sessionsThisMonth', 'pendingReports', 'pendingViolations', 'topViolatingStudents');

        return view('dashboard.guru_bk', $stats);
    }
    
    /**
     * Logika untuk Dashboard Wali Kelas
     */
    private function waliKelasDashboard()
    {
        $waliKelas = Auth::user();
        
        // 1. Temukan Kelas yang diampu
        $myClass = ClassModel::where('wali_kelas_id', $waliKelas->id)->first();

        if (!$myClass) {
            return view('dashboard.wali_kelas', ['myClass' => null]);
        }
        
        // 2. Ambil Siswa di Kelas Tersebut
        $students = User::where('class_id', $myClass->id)
                        ->where('role', 'student')
                        ->orderBy('total_points', 'asc')
                        ->get();
                        
        // 3. Hitung Statistik Kelas
        $topViolatingStudentsInClass = $students->take(5);

        // 4. Hitung Pelanggaran & Prestasi Kelas Bulan Ini
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth()->toDateString();
        $endOfMonth = $now->copy()->endOfMonth()->toDateString();
        
        $classViolationsCount = Violation::whereIn('student_id', $students->pluck('id'))
                                        ->whereBetween('violation_date', [$startOfMonth, $endOfMonth])
                                        ->count();
                                        
        $classAchievementsCount = Achievement::whereIn('student_id', $students->pluck('id'))
                                            ->whereBetween('achievement_date', [$startOfMonth, $endOfMonth])
                                            ->count();

        $stats = compact('myClass', 'students', 'topViolatingStudentsInClass', 'classViolationsCount', 'classAchievementsCount');
        
        return view('dashboard.wali_kelas', $stats);
    }

    /**
     * Logika untuk Dashboard Siswa
     */
    private function studentDashboard()
{
    $student = Auth::user();
    
    // PERBAIKAN: Gunakan with() untuk eager loading, atau load() secara terpisah
    $student->load('schoolClass');
    // ATAU gunakan eager loading dari awal:
    // $student = Auth::user()->load('studentClass');

    // Riwayat Pelanggaran Terbaru
    $latestViolations = Violation::where('student_id', $student->id)
                                ->with('rule')
                                ->latest('violation_date')
                                ->take(5)
                                ->get();

    // Riwayat Prestasi Terbaru
    $latestAchievements = Achievement::where('student_id', $student->id)
                                    ->latest('achievement_date')
                                    ->take(5)
                                    ->get();

    // Jadwal Konseling Mendatang
    $upcomingSessions = CounselingSchedule::where('student_id', $student->id)
                                        ->where('scheduled_date', '>=', now())
                                        ->orderBy('scheduled_date', 'asc')
                                        ->take(5)
                                        ->get();

    // Total Poin Siswa
    $totalPoints = $student->total_points ?? 100;

    $stats = compact('student', 'totalPoints', 'latestViolations', 'latestAchievements', 'upcomingSessions');

    return view('dashboard.student', $stats);
}
    /**
     * Logika untuk Dashboard Orang Tua: Fokus pada data anak.
     */
    private function parentDashboard()
    {
        $parent = Auth::user();
        
        // Asumsi: Relasi parent_student ada di database untuk mendapatkan anak
        $children = User::select('users.*', 'parent_student.relation_type')
                        ->join('parent_student', 'users.id', '=', 'parent_student.student_id')
                        ->where('parent_student.parent_id', $parent->id)
                        ->where('users.role', 'student')
                        ->with('schoolClass')
                        ->get();
        
        $childrenIds = $children->pluck('id');

        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth()->toDateString();
        $endOfMonth = $now->copy()->endOfMonth()->toDateString();

        // Total Pelanggaran & Prestasi Bulan Ini (untuk semua anak)
        $violationsThisMonth = Violation::whereIn('student_id', $childrenIds)
                                        ->whereBetween('violation_date', [$startOfMonth, $endOfMonth])
                                        ->count();
                                        
        $achievementsThisMonth = Achievement::whereIn('student_id', $childrenIds)
                                            ->whereBetween('achievement_date', [$startOfMonth, $endOfMonth])
                                            ->count();

        // Ambil 5 Aktivitas Terbaru (Gabungan Pelanggaran dan Prestasi)
        $latestActivities = collect();
        if ($childrenIds->isNotEmpty()) {
            // Ambil 3 Pelanggaran terbaru
            $latestViolations = Violation::whereIn('student_id', $childrenIds)
                                        ->with(['student', 'rule'])
                                        ->latest('violation_date')
                                        ->take(3)
                                        ->get()
                                        ->map(function($v) {
                                            return [
                                                'type' => 'Pelanggaran', 
                                                'date' => $v->violation_date, 
                                                'description' => $v->rule->name, 
                                                'student' => $v->student->name
                                            ];
                                        });
                                        
            // Ambil 3 Prestasi terbaru
            $latestAchievements = Achievement::whereIn('student_id', $childrenIds)
                                            ->with('student')
                                            ->latest('achievement_date')
                                            ->take(3)
                                            ->get()
                                            ->map(function($a) {
                                                return [
                                                    'type' => 'Prestasi', 
                                                    'date' => $a->achievement_date, 
                                                    'description' => $a->name, 
                                                    'student' => $a->student->name
                                                ];
                                            });
            
            // Gabungkan, urutkan berdasarkan tanggal, dan ambil 5 teratas
            $latestActivities = $latestViolations->merge($latestAchievements)
                                                 ->sortByDesc('date')
                                                 ->take(5);
        }

        $stats = compact('children', 'violationsThisMonth', 'achievementsThisMonth', 'latestActivities');
        
        return view('dashboard.parent', $stats);
    }
}