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
        return redirect()->route('admin.schedules.index', ['status' => 'completed']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $schedule_id = $request->query('schedule_id');
        $schedule = null;
        
        if ($schedule_id) {
            $schedule = \App\Models\CounselingSchedule::with(['student.schoolClass', 'teacher', 'topic'])->find($schedule_id);
        }
        
        $topics = Topic::where('is_custom', false)->orderBy('name')->get();
        $counselors = User::where('role', 'guru_bk')->orderBy('name')->get();
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
            'location' => 'required|string|max:191',
            'notes' => 'required|string',
            'status' => ['required', Rule::in(['requested', 'scheduled', 'completed', 'cancelled'])],
            'follow_up_required' => 'nullable|boolean',
            'topic_id' => 'nullable|exists:topics,id',
            'custom_topic' => 'nullable|string|max:255',
        ]);

        // Hanya boleh pilih 1: dari daftar ATAU custom
        $topicId = null;

        if ($request->filled('topic_id') && empty($request->custom_topic)) {
            // Gunakan topik dari daftar yang ada
            $topicId = $request->topic_id;
        } elseif ($request->filled('custom_topic') && empty($request->topic_id)) {
            // Buat atau gunakan topik custom
            $customName = trim($request->custom_topic);
            $topic = Topic::whereRaw('LOWER(name) = ?', [mb_strtolower($customName)])->first();
            if (!$topic) {
                $topic = Topic::create([
                    'name' => $customName,
                    'description' => 'Topik custom dibuat oleh admin.',
                    'is_custom' => true
                ]);
            }
            $topicId = $topic->id;
        } else {
            return redirect()->back()->withInput()->withErrors(['topic_id' => 'Pilih salah satu: topik dari daftar ATAU topik custom, tidak boleh keduanya atau kosong.']);
        }

        $session = CounselingSession::create($request->except('topic_id', 'custom_topic', 'status'));
        // Pastikan status di-set explicit (karena create di atas mungkin skip status jika tidak di-$fillable atau semacamnya, meski harusnya aman)
        // Kita update lagi untuk memastikan jika ada logic lain atau sekadar rapi:
        $session->update(['status' => $request->status]);

        $session->topics()->sync([$topicId]);

        // Update status jadwal jika ada
        if ($session->schedule_id && in_array($request->status, ['completed', 'cancelled'])) {
            $session->schedule()->update(['status' => $request->status]);
        }

        $statusTab = ($request->status === 'cancelled') ? 'cancelled' : 'completed';
        return redirect()->route('admin.schedules.index', ['status' => $statusTab])
                         ->with('success', 'Sesi konseling berhasil dicatat.');
    }

    /**
     * Menampilkan detail dan form untuk menjadwalkan/menangani sesi.
     */
    public function edit(CounselingSession $counselingSession)
    {
        $session = $counselingSession; // Alias untuk compatibility dengan view
        $session->load(['student.schoolClass', 'counselor', 'topics']);
        $topics = Topic::where('is_custom', false)->orderBy('name')->get();
        // Hanya Guru BK yang dapat menjadi konselor
        $counselors = User::where('role', 'guru_bk')->orderBy('name')->get();
        
        return view('admin.counseling_sessions.edit', compact('session', 'topics', 'counselors'));
    }

    /**
     * Memperbarui/menangani sesi konseling.
     */
    public function update(Request $request, CounselingSession $counselingSession)
    {
        $session = $counselingSession; // Alias
        
        $request->validate([
            'counselor_id' => 'required|exists:users,id',
            'session_type' => ['required', Rule::in(['individual', 'group', 'referral'])],
            'session_date' => 'nullable|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'location' => 'required|string|max:191',
            'notes' => 'required|string',
            'status' => ['required', Rule::in(['requested', 'scheduled', 'completed', 'cancelled'])],
            'follow_up_required' => 'nullable|boolean',
            'topic_id' => 'nullable|exists:topics,id',
            'custom_topic' => 'nullable|string|max:255',
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
            'follow_up_required', 
        ]));
        
        // 2. Sinkronisasi topik (hanya 1 topik: dari daftar ATAU custom)
        $topicId = null;

        if ($request->filled('topic_id') && empty($request->custom_topic)) {
            $topicId = $request->topic_id;
        } elseif ($request->filled('custom_topic') && empty($request->topic_id)) {
            $customName = trim($request->custom_topic);
            $topic = Topic::whereRaw('LOWER(name) = ?', [mb_strtolower($customName)])->first();
            if (!$topic) {
                $topic = Topic::create([
                    'name' => $customName,
                    'description' => 'Topik custom dibuat oleh admin.',
                    'is_custom' => true
                ]);
            }
            $topicId = $topic->id;
        } else {
            return redirect()->back()->withInput()->withErrors(['topic_id' => 'Pilih salah satu: topik dari daftar ATAU topik custom, tidak boleh keduanya atau kosong.']);
        }
        $session->topics()->sync([$topicId]);
        
        // 3. Update status jadwal jika ada (untuk kemudahan pelacakan)
        if ($session->schedule_id && in_array($request->status, ['completed', 'cancelled'])) {
            $session->schedule()->update(['status' => $request->status]);
        }
        
        $statusTab = ($request->status === 'cancelled') ? 'cancelled' : 'completed';
        return redirect()->route('admin.schedules.index', ['status' => $statusTab])
                         ->with('success', 'Sesi konseling berhasil diperbarui dan status telah ditangani.');
    }
}