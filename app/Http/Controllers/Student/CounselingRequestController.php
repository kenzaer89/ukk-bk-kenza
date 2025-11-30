<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\CounselingRequest;
use App\Models\Topic;
use Illuminate\Http\Request;

class CounselingRequestController extends Controller
{
    public function index()
    {
        $requests = CounselingRequest::where('student_id', auth()->id())
                                    ->with('teacher')
                                    ->latest()
                                    ->paginate(10);
        
        return view('student.counseling_requests.index', compact('requests'));
    }

    public function create()
    {
        return view('student.counseling_requests.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        CounselingRequest::create([
            'student_id' => auth()->id(),
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        return redirect()->route('student.counseling_requests.index')
                         ->with('success', 'Permintaan konseling berhasil diajukan. Guru BK akan segera menindaklanjuti.');
    }
    
    public function cancel(CounselingRequest $counseling_request)
    {
        if ($counseling_request->student_id !== auth()->id() || $counseling_request->status !== 'pending') {
            return redirect()->back()->with('error', 'Anda hanya dapat membatalkan permintaan yang berstatus pending.');
        }

        $counseling_request->update(['status' => 'rejected']);
        
        return redirect()->back()->with('success', 'Permintaan konseling berhasil dibatalkan.');
    }
}