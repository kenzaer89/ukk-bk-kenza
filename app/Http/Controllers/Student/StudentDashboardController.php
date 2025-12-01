<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CounselingSchedule;
use App\Models\CounselingSession;
use App\Models\CounselingRequest;
use App\Models\Violation;
use App\Models\Achievement;
use Carbon\Carbon;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user()->load('schoolClass');

        // --- Jadwal & Sesi ---
        $upcomingSessions = CounselingSchedule::with('teacher')
            ->where('student_id', $user->id)
            ->whereDate('scheduled_date', '>=', now())
            ->orderBy('scheduled_date', 'asc')
            ->limit(5)
            ->get();

        $recentSessions = CounselingSession::with('counselor')
            ->where('student_id', $user->id)
            ->where('status', 'completed')
            ->orderBy('session_date', 'desc')
            ->limit(5)
            ->get();

        // --- Pelanggaran & Prestasi ---
        $recentViolations = Violation::with('rule')
            ->where('student_id', $user->id)
            ->latest()
            ->limit(5)
            ->get();

        $recentAchievements = Achievement::where('student_id', $user->id)
            ->latest()->limit(5)->get();

        // --- Permintaan Konseling ---
        $recentRequests = CounselingRequest::where('student_id', $user->id)
            ->latest()->limit(5)->get();

        // --- Statistics ---
        $stats = [
            'scheduled_sessions' => CounselingSchedule::where('student_id', $user->id)->count(),
            'pending_requests' => CounselingRequest::where('student_id', $user->id)->where('status', 'pending')->count(),
            'violations' => Violation::where('student_id', $user->id)->count(),
            'achievements' => Achievement::where('student_id', $user->id)->count(),
        ];

        return view('student.dashboard', compact(
            'user',
            'stats',
            'upcomingSessions',
            'recentSessions',
            'recentViolations',
            'recentAchievements',
            'recentRequests'
        ));
    }

    public function storeRequest(Request $request)
    {
        $request->validate([
            'topic' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        CounselingRequest::create([
            'student_id' => Auth::id(),
            'topic' => $request->topic,
            'description' => $request->description,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Permintaan konseling berhasil diajukan!');
    }

    public function violations()
    {
        $violations = Violation::with('rule')
            ->where('student_id', Auth::id())
            ->latest('violation_date')
            ->paginate(10);

        return view('student.violations.index', compact('violations'));
    }

    public function achievements()
    {
        $achievements = Achievement::where('student_id', Auth::id())
            ->latest('achievement_date')
            ->paginate(10);

        return view('student.achievements.index', compact('achievements'));
    }
}
