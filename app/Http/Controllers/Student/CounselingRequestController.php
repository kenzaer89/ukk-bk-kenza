<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\CounselingRequest;
use App\Models\Notification as AppNotification;
use App\Models\User;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CounselingRequestController extends Controller
{
    public function index()
    {
        $requests = CounselingRequest::where('student_id', Auth::id())
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

        $counselingRequest = CounselingRequest::create([
            'student_id' => Auth::id(),
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        // Notify admins and BK teachers about this new request
        $admins = User::whereIn('role', ['admin', 'guru_bk'])->get();
        foreach ($admins as $admin) {
            AppNotification::create([
                'user_id' => $admin->id,
                'message' => "Permintaan konseling baru dari " . Auth::user()->name,
                'status' => 'unread',
            ]);
        }

        return redirect()->route('student.counseling_requests.index')
                         ->with('success', 'Permintaan konseling berhasil diajukan. Guru BK akan segera menindaklanjuti.');
    }
    
    public function cancel(CounselingRequest $counseling_request)
    {
        if ($counseling_request->student_id !== Auth::id() || $counseling_request->status !== 'pending') {
            return redirect()->back()->with('error', 'Anda hanya dapat membatalkan permintaan yang berstatus pending.');
        }

        $counseling_request->update(['status' => 'rejected']);
        
        return redirect()->back()->with('success', 'Permintaan konseling berhasil dibatalkan.');
    }
}