<?php

namespace App\Http\Controllers\Wali;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Violation;
use App\Models\CounselingSchedule;

class WaliDashboardController extends Controller
{
    public function index()
    {
        $waliId = session('user.id');
        $class = SchoolClass::where('wali_kelas_id',$waliId)->with('students')->first();

        $violations = Violation::whereIn('student_id', $class?->students->pluck('id') ?? [])->count();
        $schedules = CounselingSchedule::whereIn('student_id', $class?->students->pluck('id') ?? [])->count();

        return view('wali.dashboard', compact('class','violations','schedules'));
    }
}
