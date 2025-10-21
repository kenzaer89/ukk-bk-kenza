<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\CounselingRequest;
use App\Models\CounselingSchedule;
use App\Models\CounselingSession;
use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $id = Auth::id(); // ← PENTING: gunakan Auth sekarang

        $requests = CounselingRequest::where('id_user', $id)
                    ->latest()->limit(5)->get();

        $upcoming = CounselingSchedule::where('student_id', $id)
                    ->whereDate('scheduled_date', '>=', now())
                    ->orderBy('scheduled_date','asc')
                    ->limit(5)->get();

        $sessions = CounselingSession::whereHas('schedule', function ($q) use ($id) {
                        $q->where('student_id', $id);
                    })
                    ->latest('session_date')
                    ->limit(5)->get();

        return view('student.dashboard', compact('requests', 'upcoming', 'sessions'));
    }
}
