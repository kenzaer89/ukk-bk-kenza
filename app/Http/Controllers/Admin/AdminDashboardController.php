<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\CounselingSchedule;
use App\Models\CounselingSession;
use App\Models\CounselingRequest;
use App\Models\Violation;
use App\Models\Achievement;
use App\Models\SchoolClass;
use App\Models\Rule;
use App\Models\Topic;



class AdminDashboardController extends Controller
{
    public function index()
    {
        // Statistics
        $stats = [
            'total_students' => User::where('role', 'student')->count(),
            'total_teachers' => User::whereIn('role', ['guru_bk', 'wali_kelas'])->count(),
            'total_sessions' => CounselingSession::whereHas('schedule', function($q){ $q->where('is_visible_to_admin', true); })->count(),
            'total_schedules' => CounselingSchedule::where('is_visible_to_admin', true)->count(),
            'pending_requests' => CounselingRequest::where('is_visible_to_admin', true)->where('status', 'pending')->count(),
            'total_violations' => Violation::where('is_visible_to_admin', true)->count(),
            'total_achievements' => Achievement::where('is_visible_to_admin', true)->count(),
            'total_classes' => SchoolClass::count(),
            'pending_approvals' => User::where('is_approved', false)->count(),
        ];

        // For Admin: User Approvals
        $pendingApprovals = [];
        if (auth()->user()->role === 'admin') {
            $pendingApprovals = User::where('is_approved', false)
                ->latest()
                ->limit(5)
                ->get();
        }

        // Recent Activities (Guru BK)
        $recentRequests = CounselingRequest::with('student')
            ->where('is_visible_to_admin', true)
            ->where('status', 'pending')
            ->latest()
            ->limit(5)
            ->get();

        $upcomingSchedules = CounselingSchedule::with(['student', 'teacher'])
            ->where('is_visible_to_admin', true)
            ->where('status', 'scheduled')
            ->whereNull('counseling_request_id')
            ->whereDate('scheduled_date', '>=', now())
            ->orderBy('scheduled_date')
            ->limit(5)
            ->get();

        $recentViolations = Violation::where('is_visible_to_admin', true)
            ->latest()
            ->limit(5)
            ->get();

        $recentAchievements = Achievement::where('is_visible_to_admin', true)
            ->latest()
            ->limit(5)
            ->get();

        // Quick Stats
        $studentsThisMonth = User::where('role', 'student')
            ->whereMonth('created_at', now()->month)
            ->count();

        $sessionsThisMonth = CounselingSession::whereMonth('session_date', now()->month)
            ->count();

        return view('admin.dashboard', compact(
            'stats',
            'pendingApprovals',
            'recentRequests',
            'upcomingSchedules',
            'recentViolations',
            'recentAchievements',
            'studentsThisMonth',
            'sessionsThisMonth'
        ));
    }

    public function checkNewRequests()
    {
        $pendingCount = CounselingRequest::where('status', 'pending')->count();
        
        $recentRequests = CounselingRequest::with(['student.schoolClass'])
            ->where('status', 'pending')
            ->latest()
            ->limit(5)
            ->get();

        return response()->json([
            'count' => $pendingCount,
            'requests' => $recentRequests->map(function($request) {
                return [
                    'id' => $request->id,
                    'student_name' => $request->student->name,
                    'student_email' => $request->student->email, // Add fallback empty string if null? handled in js
                    'student_class' => $request->student->schoolClass ? $request->student->schoolClass->name : 'Tanpa Kelas',
                    'student_absen' => $request->student->absen ?? '-',
                    'student_jurusan' => $request->student->schoolClass ? $request->student->schoolClass->jurusan : ($request->student->specialization ?? '-'),
                    'reason' => $request->reason,
                    'requested_at' => $request->requested_at->diffForHumans(),
                    'created_at' => $request->created_at->toIso8601String(),
                ];
            })
        ]);
    }
}
