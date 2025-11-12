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
        $user = Auth::user();

        // --- Ringkasan ---
        $totalSchedules = CounselingSchedule::where('student_id', $user->id)->count();
        $totalSessions = CounselingSession::whereHas('schedule', fn($q) => $q->where('student_id', $user->id))->count();
        $totalViolations = Violation::where('student_id', $user->id)->count();
        $totalAchievements = Achievement::where('student_id', $user->id)->count();

        // --- Jadwal & Sesi ---
        $upcomingSchedules = CounselingSchedule::where('student_id', $user->id)
            ->whereDate('scheduled_date', '>=', now())
            ->orderBy('scheduled_date', 'asc')
            ->limit(5)
            ->get();

        $recentSessions = CounselingSession::whereHas('schedule', fn($q) => $q->where('student_id', $user->id))
            ->orderBy('session_date', 'desc')
            ->limit(5)
            ->get();

        // --- Pelanggaran & Prestasi ---
        $recentViolations = Violation::where('student_id', $user->id)
            ->latest()->limit(5)->get();

        $recentAchievements = Achievement::where('student_id', $user->id)
            ->latest()->limit(5)->get();

        // --- Permintaan Konseling ---
        $recentRequests = CounselingRequest::where('student_id', $user->id)
            ->latest()->limit(5)->get();

        // --- Data Chart ---
        $sessionsChart = CounselingSession::selectRaw('MONTH(session_date) as month, COUNT(*) as total')
            ->whereHas('schedule', fn($q) => $q->where('student_id', $user->id))
            ->groupBy('month')->pluck('total', 'month')->toArray();

        $violationsChart = Violation::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->where('student_id', $user->id)
            ->groupBy('month')->pluck('total', 'month')->toArray();

        $months = collect(range(1, 12))->map(fn($m) => Carbon::create()->month($m)->translatedFormat('F'));

        return view('student.dashboard', compact(
            'user',
            'totalSchedules',
            'totalSessions',
            'totalViolations',
            'totalAchievements',
            'upcomingSchedules',
            'recentSessions',
            'recentViolations',
            'recentAchievements',
            'recentRequests',
            'months',
            'sessionsChart',
            'violationsChart'
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
}
