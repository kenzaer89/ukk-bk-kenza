<?php

namespace App\Http\Controllers\ParentRole;

use App\Http\Controllers\Controller;
use App\Models\ParentStudent;
use App\Models\Violation;
use App\Models\CounselingSession;

class ParentDashboardController extends Controller
{
    public function index()
    {
        $pid = \Illuminate\Support\Facades\Auth::id();
        $children = ParentStudent::where('parent_id',$pid)->with('student')->get();

        $data = [];
        foreach($children as $child){
            $data[] = [
                'student'=>$child->student,
                'violations'=>Violation::where('student_id',$child->student_id)
                    ->with(['rule', 'student.schoolClass', 'teacher'])
                    ->latest('violation_date')
                    ->limit(3)
                    ->get(),
                'achievements'=>\App\Models\Achievement::where('student_id',$child->student_id)
                    ->with(['student.schoolClass', 'teacher'])
                    ->latest('achievement_date')
                    ->limit(3)
                    ->get(),
                'sessions'=>CounselingSession::whereHas('schedule', fn($q)=>$q->where('student_id',$child->student_id))
                    ->with(['student.schoolClass', 'counselor', 'schedule'])
                    ->latest('session_date')
                    ->limit(3)
                    ->get()
            ];
        }

        return view('parent.dashboard', compact('data'));
    }
}
