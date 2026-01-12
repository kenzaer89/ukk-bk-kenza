<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CounselingSession;
use App\Models\CounselingSchedule;
use App\Models\Topic;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SessionController extends Controller
{
    /**
     * Menampilkan daftar semua sesi konseling yang telah selesai. (READ - Index)
     */
    public function index()
    {
        $sessions = CounselingSession::with('schedule')
                        ->latest('session_date')
                        ->paginate(10);
        
        return view('admin.sessions.index', compact('sessions'));
    }

    /**
     * Menampilkan form untuk mencatat sesi berdasarkan jadwal. (CREATE - Form)
     */
    public function create(Request $request)
    {
        // Harus ada schedule_id yang dilewatkan
        $scheduleId = $request->query('schedule_id');
        
        if (!$scheduleId) {
            // Arahkan kembali ke jadwal jika tidak ada ID
            return redirect()->route('admin.schedules.index')->with('error', 'Pilih jadwal konseling terlebih dahulu untuk mencatat sesi.');
        }

        $schedule = CounselingSchedule::with('student', 'teacher')->findOrFail($scheduleId);
        
        // Pastikan jadwal belum memiliki sesi terkait
        if ($schedule->session) {
            return redirect()->route('admin.sessions.show', $schedule->session)
                             ->with('info', 'Sesi untuk jadwal ini sudah dicatat. Anda diarahkan ke detail sesi.');
        }

        $topics = Topic::where('is_custom', false)->orderBy('name')->get();

        return view('admin.sessions.create', compact('schedule', 'topics'));
    }

    /**
     * Menyimpan data sesi konseling baru. (CREATE - Store)
     */
    public function store(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:counseling_schedules,id',
            'session_date' => 'required|date',
            'teacher_notes' => 'required|string',
            'recommendations' => 'nullable|string',
            'follow_up_date' => 'nullable|date|after_or_equal:session_date',
            'topic_ids' => 'required|array',
            'topic_ids.*' => 'exists:topics,id',
        ]);

        $schedule = CounselingSchedule::findOrFail($request->schedule_id);
        
        // Cek duplikasi (walaupun sudah dicek di create, ini pengamanan)
        if ($schedule->session) {
            return redirect()->back()->with('error', 'Sesi untuk jadwal ini sudah dicatat.');
        }

        // 1. Buat Sesi Konseling
        $session = CounselingSession::create([
            'schedule_id' => $request->schedule_id,
            'session_date' => $request->session_date,
            'teacher_notes' => $request->teacher_notes,
            'recommendations' => $request->recommendations,
            'follow_up_date' => $request->follow_up_date,
            'status' => 'completed', 
        ]);
        
        // 2. Sinkronisasi Topik (Many-to-Many)
        $session->topics()->sync($request->topic_ids);
        
        // 3. (Opsional) Update status di tabel lain, misalnya log student_histories

        return redirect()->route('admin.sessions.index')
                         ->with('success', 'Sesi konseling berhasil dicatat dan diselesaikan.');
    }

    /**
     * Menampilkan detail sesi konseling. (READ - Show)
     */
    public function show(CounselingSession $session)
    {
        $session->load('schedule.student', 'schedule.teacher', 'topics');
        
        return view('admin.sessions.show', compact('session'));
    }

    // Metode 'edit' dan 'update' untuk memungkinkan Guru BK mengoreksi catatan sesi.
    public function edit(CounselingSession $session)
    {
        $topics = Topic::where('is_custom', false)->orderBy('name')->get();
        // Ambil ID topik yang sudah terpilih untuk pre-select di form
        $selectedTopics = $session->topics->pluck('id')->toArray();

        return view('admin.sessions.edit', compact('session', 'topics', 'selectedTopics'));
    }

    public function update(Request $request, CounselingSession $session)
    {
        $request->validate([
            'teacher_notes' => 'required|string',
            'recommendations' => 'nullable|string',
            'follow_up_date' => 'nullable|date|after_or_equal:session_date',
            'topic_ids' => 'required|array',
            'topic_ids.*' => 'exists:topics,id',
        ]);

        $session->update($request->except('schedule_id', 'session_date')); // session_date dan schedule_id tidak boleh diubah
        $session->topics()->sync($request->topic_ids);

        return redirect()->route('admin.sessions.show', $session)
                         ->with('success', 'Sesi konseling berhasil diperbarui.');
    }
    
    // Metode 'destroy' (jarang digunakan untuk data historis seperti sesi)
    public function destroy(CounselingSession $session)
    {
        // Hapus relasi Many-to-Many terlebih dahulu
        $session->topics()->detach();
        
        // Hapus sesi
        $session->delete();

        return redirect()->route('admin.sessions.index')
                         ->with('success', 'Sesi konseling berhasil dihapus.');
    }
}