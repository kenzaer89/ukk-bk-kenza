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
        $pid = session('user.id');
        $children = ParentStudent::where('parent_id',$pid)->with('student')->get();

        $data = [];
        foreach($children as $child){
            $data[] = [
                'student'=>$child->student,
                'violations'=>Violation::where('student_id',$child->student_id)->latest('occurred_at')->limit(3)->get(),
                'sessions'=>CounselingSession::whereHas('schedule', fn($q)=>$q->where('student_id',$child->student_id))
                              ->latest('session_date')->limit(3)->get()
            ];
        }

        return view('parent.dashboard', compact('data'));
    }
}
