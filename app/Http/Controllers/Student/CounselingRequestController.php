<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\CounselingSession;
use App\Models\Topic;
use Illuminate\Http\Request;

class CounselingRequestController extends Controller
{
    public function index()
    {
        $requests = CounselingSession::where('student_id', auth()->id())
                                    ->with('counselor')
                                    ->latest()
                                    ->paginate(10);
        
        return view('student.counseling_requests.index', compact('requests'));
    }

    public function create()
    {
        $topics = Topic::orderBy('name')->get();
        return view('student.counseling_requests.create', compact('topics'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'request_reason' => 'required|string|max:500',
            'topic_ids' => 'required|array|min:1',
            'topic_ids.*' => 'exists:topics,id',
        ]);

        // Catat sesi dengan status 'requested'
        $session = CounselingSession::create([
            'student_id' => auth()->id(),
            'session_type' => 'individual', 
            'request_reason' => $request->request_reason,
            'session_date' => now()->toDateString(), // Tanggal awal, akan diupdate Guru BK
            'status' => 'requested',
        ]);
        
        // Kaitkan topik
        $session->topics()->attach($request->topic_ids);

        return redirect()->route('student.counseling_requests.index')
                         ->with('success', 'Permintaan konseling berhasil diajukan. Guru BK akan segera menjadwalkannya.');
    }
    
    // Siswa hanya bisa membatalkan permintaan yang berstatus 'requested'
    public function cancel(CounselingSession $session)
    {
        if ($session->student_id !== auth()->id() || $session->status !== 'requested') {
            return redirect()->back()->with('error', 'Anda hanya dapat membatalkan permintaan yang berstatus pending.');
        }

        $session->update(['status' => 'cancelled']);
        
        return redirect()->back()->with('success', 'Permintaan konseling berhasil dibatalkan.');
    }
}