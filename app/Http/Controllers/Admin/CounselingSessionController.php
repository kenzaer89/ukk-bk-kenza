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
     * Menampilkan detail dan form untuk menjadwalkan/menangani sesi.
     */
    public function edit(CounselingSession $session)
    {
        $session->load(['student.studentClass', 'counselor', 'topics']);
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