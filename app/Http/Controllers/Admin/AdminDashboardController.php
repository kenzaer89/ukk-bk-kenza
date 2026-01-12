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
            'total_sessions' => CounselingSession::count(),
            'total_schedules' => CounselingSchedule::count(),
            'pending_requests' => CounselingRequest::where('status', 'pending')->count(),
            'total_violations' => Violation::count(),
            'total_achievements' => Achievement::count(),
            'total_classes' => SchoolClass::count(),
        ];

        // Recent Activities
        $recentRequests = CounselingRequest::with('student')
            ->where('status', 'pending')
            ->latest()
            ->limit(5)
            ->get();

        $upcomingSchedules = CounselingSchedule::with(['student', 'teacher'])
            ->where('status', 'scheduled') // Only show scheduled sessions
            ->whereDate('scheduled_date', '>=', now())
            ->orderBy('scheduled_date')
            ->limit(5)
            ->get();

        $recentViolations = Violation::latest()
            ->limit(5)
            ->get();

        $recentAchievements = Achievement::latest()
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
        
        $recentRequests = CounselingRequest::with('student')
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
                    'student_email' => $request->student->email,
                    'reason' => $request->reason,
                    'requested_at' => $request->requested_at->diffForHumans(),
                    'created_at' => $request->created_at->toIso8601String(),
                ];
            })
        ]);
    }
}
