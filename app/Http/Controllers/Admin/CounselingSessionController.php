<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CounselingSession;
use App\Models\User;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CounselingSessionController extends Controller
{
    /**
     * Menampilkan daftar semua sesi/permintaan konseling.
     */
    public function index()
    {
        $sessions = CounselingSession::with(['student', 'counselor'])
                                     ->latest()
                                     ->paginate(15);
        
        return view('admin.counseling_sessions.index', compact('sessions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $schedule_id = $request->query('schedule_id');
        $schedule = null;
        
        if ($schedule_id) {
            $schedule = \App\Models\CounselingSchedule::with('student', 'teacher')->find($schedule_id);
        }
        
        $topics = Topic::orderBy('name')->get();
        $counselors = User::whereIn('role', ['guru_bk', 'admin'])->orderBy('name')->get();
        $students = User::where('role', 'student')->with('schoolClass')->orderBy('name')->get();
        
        return view('admin.counseling_sessions.create', compact('schedule', 'topics', 'counselors', 'students'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'counselor_id' => 'required|exists:users,id',
            'schedule_id' => 'nullable|exists:counseling_schedules,id',
            'session_type' => ['required', Rule::in(['individual', 'group', 'referral'])],
            'session_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'location' => 'nullable|string|max:191',
            'notes' => 'nullable|string',
            'status' => ['required', Rule::in(['requested', 'scheduled', 'completed', 'cancelled'])],
            'follow_up_required' => 'nullable|boolean',
            'topic_ids' => 'required|array|min:1',
            'topic_ids.*' => 'exists:topics,id',
        ]);

        $session = CounselingSession::create($request->all());
        $session->topics()->sync($request->topic_ids);

        return redirect()->route('admin.counseling_sessions.index')
                         ->with('success', 'Sesi konseling berhasil dicatat.');
    }

    /**
     * Menampilkan detail dan form untuk menjadwalkan/menangani sesi.
     */
    public function edit(CounselingSession $session)
    {
        $session->load(['student.schoolClass', 'counselor', 'topics']);
        $topics = Topic::orderBy('name')->get();
        // Hanya Guru BK dan Admin yang dapat menjadi konselor
        $counselors = User::where('role', 'guru_bk')->orWhere('role', 'admin')->orderBy('name')->get();
        
        return view('admin.counseling_sessions.edit', compact('session', 'topics', 'counselors'));
    }

    /**
     * Memperbarui/menangani sesi konseling.
     */
    public function update(Request $request, CounselingSession $session)
    {
        $request->validate([
            'counselor_id' => 'required|exists:users,id',
            'session_type' => ['required', Rule::in(['individual', 'group', 'referral'])],
            'session_date' => 'nullable|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'location' => 'nullable|string|max:191',
            'notes' => 'nullable|string',
            'status' => ['required', Rule::in(['requested', 'scheduled', 'completed', 'cancelled'])],
            'follow_up_required' => 'nullable|boolean',
            'topic_ids' => 'required|array|min:1',
            'topic_ids.*' => 'exists:topics,id',
        ]);
        
        // 1. Update data sesi
        $session->update($request->only([
            'counselor_id',
            'session_type',
            'session_date',
            'start_time',
            'end_time',
            'location',
            'notes',
            'status',
            // Pastikan checkbox follow_up_required terisi (jika tidak ada di request, default ke 0)
            'follow_up_required', 
        ]));
        
        // 2. Sinkronisasi topik
        $session->topics()->sync($request->topic_ids);
        
        return redirect()->route('admin.counseling_sessions.index')
                         ->with('success', 'Sesi konseling berhasil diperbarui dan status telah ditangani.');
    }
}