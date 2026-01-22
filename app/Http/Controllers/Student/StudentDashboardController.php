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
            ->where(function($query) {
                // Only show if status is scheduled AND no completed/cancelled session exists
                $query->where('status', 'scheduled')
                      ->whereDoesntHave('session', function($q) {
                          $q->whereIn('status', ['completed', 'cancelled']);
                      });
            })
            ->orderBy('scheduled_date', 'asc')
            ->limit(3)
            ->get();

        $recentSessions = CounselingSession::with('counselor')
            ->where('student_id', $user->id)
            ->where('status', 'completed')
            ->orderBy('session_date', 'desc')
            ->limit(3)
            ->get();

        // --- Pelanggaran & Prestasi ---
        $recentViolations = Violation::with('rule')
            ->where('student_id', $user->id)
            ->where('status', 'resolved')
            ->latest()
            ->limit(3)
            ->get();

        $recentAchievements = Achievement::where('student_id', $user->id)
            ->latest()->limit(3)->get();

        // --- Permintaan Konseling ---
        $recentRequests = CounselingRequest::where('student_id', $user->id)
            ->latest()->limit(5)->get();

        // --- Statistics ---
        $stats = [
            'scheduled_sessions' => CounselingSchedule::where('student_id', $user->id)
                ->where('status', 'scheduled')
                ->whereDate('scheduled_date', '>=', now())
                ->count(),
            'pending_requests' => CounselingRequest::where('student_id', $user->id)->where('status', 'pending')->count(),
            'violations' => Violation::where('student_id', $user->id)->where('status', 'resolved')->count(),
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
            ->where('status', 'resolved')
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

    public function schedules(Request $request)
    {
        $status = $request->status;
        $query = CounselingSchedule::with(['teacher', 'session', 'topic', 'counselingRequest'])
            ->where('student_id', Auth::id());
        
        // Apply status filter
        if ($status && in_array($status, ['scheduled', 'completed', 'cancelled'])) {
            if ($status === 'scheduled') {
                // Terjadwal: status = scheduled and date in future
                $query->where('status', 'scheduled')
                      ->whereDate('scheduled_date', '>=', now());
            } elseif ($status === 'completed') {
                // Selesai: has session with completed status
                $query->whereHas('session', function($q) {
                    $q->where('status', 'completed');
                });
            } elseif ($status === 'cancelled') {
                // Dibatalkan: status = cancelled OR session status = cancelled
                $query->where(function($q) {
                    $q->where('status', 'cancelled')
                      ->orWhereHas('session', function($sq) {
                          $sq->where('status', 'cancelled');
                      });
                });
            }
        }
        
        $schedules = $query->latest('scheduled_date')
                          ->latest('start_time')
                          ->latest()
                          ->paginate(10);
        
        // Calculate counts for each status
        $counts = [
            'all' => CounselingSchedule::where('student_id', Auth::id())->count(),
            'scheduled' => CounselingSchedule::where('student_id', Auth::id())
                ->where('status', 'scheduled')
                ->whereDate('scheduled_date', '>=', now())
                ->count(),
            'completed' => CounselingSchedule::where('student_id', Auth::id())
                ->whereHas('session', function($q) {
                    $q->where('status', 'completed');
                })
                ->count(),
            'cancelled' => CounselingSchedule::where('student_id', Auth::id())
                ->where(function($q) {
                    $q->where('status', 'cancelled')
                      ->orWhereHas('session', function($sq) {
                          $sq->where('status', 'cancelled');
                      });
                })
                ->count(),
        ];

        return view('student.schedules.index', compact('schedules', 'counts'));
    }
}
