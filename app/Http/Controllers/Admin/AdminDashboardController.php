<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\CounselingSchedule;
use App\Models\CounselingSession;
use App\Models\Violation;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalStudents = User::where('role', 'student')->count();
        $totalSessions = CounselingSession::count();
        $totalViolations = Violation::count();
        $upcoming = CounselingSchedule::with(['student', 'teacher'])
                    ->whereDate('scheduled_date', '>=', now())
                    ->orderBy('scheduled_date')
                    ->limit(6)->get();

        return view('admin.dashboard', compact('totalStudents', 'totalSessions', 'totalViolations', 'upcoming'));
    }
}
