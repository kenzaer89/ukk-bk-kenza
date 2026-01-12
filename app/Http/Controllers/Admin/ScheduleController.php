<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CounselingSchedule;
use App\Models\CounselingRequest;
use App\Models\User;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    /**
     * Menampilkan daftar semua jadwal konseling. (READ - Index)
     */
    public function index(Request $request)
    {
        $query = CounselingSchedule::with(['student', 'teacher', 'counselingRequest', 'topic', 'session']);

        // Filter by status if provided
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $schedules = $query->latest('scheduled_date')
                        ->latest('start_time')
                        ->latest()
                        ->paginate(10);
        
        // Count for stats
        $counts = [
            'all' => CounselingSchedule::count(),
            'scheduled' => CounselingSchedule::where('status', 'scheduled')->count(),
            'completed' => CounselingSchedule::where('status', 'completed')->count(),
            'cancelled' => CounselingSchedule::where('status', 'cancelled')->count(),
        ];
        
        return view('admin.schedules.index', compact('schedules', 'counts'));
    }

    /**
     * Menampilkan form untuk membuat jadwal baru. (CREATE - Form)
     */
    public function create(Request $request)
    {
        $students = User::where('role', 'student')->with('schoolClass')->orderBy('name')->get(); 
        $teachers = User::where('role', 'guru_bk')->orderBy('name')->get();
        $topics = Topic::where('is_custom', false)->orderBy('name')->get();
        
        // Cek apakah ada request_id yang dilewatkan (dari persetujuan permintaan)
        $requestId = $request->query('request_id');
        $requestData = null;
        if ($requestId) {
            $requestData = CounselingRequest::with(['student', 'topic'])->find($requestId);
            if (!$requestData || $requestData->status !== 'pending') {
                return redirect()->route('admin.schedules.index')->with('error', 'Permintaan tidak valid atau sudah diproses.');
            }
        }
        
        return view('admin.schedules.create', compact('students', 'teachers', 'requestData', 'topics'));
    }

    /**
     * Menyimpan jadwal baru ke database. (CREATE - Store)
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'teacher_id' => 'required|exists:users,id',
            'topic_id' => 'required|string', // Bisa 'custom' atau ID numerik
            'custom_topic' => 'nullable|string|max:255',
            'scheduled_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'location' => 'required|string|max:255',
            'counseling_request_id' => 'nullable|exists:counseling_requests,id',
        ], [
            'end_time.after' => 'Waktu selesai harus lebih besar dari waktu mulai.',
            'student_id.required' => 'Wajib memilih siswa.',
            'teacher_id.required' => 'Wajib memilih guru BK.',
            'topic_id.required' => 'Wajib memilih topik konseling.',
            'scheduled_date.required' => 'Wajib mengisi tanggal sesi.',
            'start_time.required' => 'Wajib mengisi waktu mulai.',
            'end_time.required' => 'Wajib mengisi waktu selesai.',
            'location.required' => 'Wajib mengisi lokasi sesi.',
        ]);
        
        // Logic Topik: Gunakan topik yang ada atau buat baru
        $topicId = null;
        if ($request->topic_id === 'custom' && $request->filled('custom_topic')) {
            $customName = trim($request->custom_topic);
            $topic = Topic::whereRaw('LOWER(name) = ?', [mb_strtolower($customName)])->first();
            if (!$topic) {
                $topic = Topic::create([
                    'name' => $customName,
                    'description' => 'Topik custom dibuat saat penjadwalan.',
                    'is_custom' => true
                ]);
            }
            $topicId = $topic->id;
        } else {
            $topicId = $request->topic_id;
        }
        
        // 1. Simpan Jadwal Konseling
        $schedule = CounselingSchedule::create([
            'student_id' => $request->student_id,
            'teacher_id' => $request->teacher_id,
            'topic_id' => $topicId,
            'scheduled_date' => $request->scheduled_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'location' => $request->location,
            'counseling_request_id' => $request->counseling_request_id,
            'status' => 'scheduled',
        ]);

        // 2. Update status CounselingRequest (jika ada)
        if ($request->counseling_request_id) {
            $req = CounselingRequest::find($request->counseling_request_id);
            if ($req && $req->status === 'pending') {
                $req->update(['status' => 'approved', 'teacher_id' => $request->teacher_id]);
            }
        }

        // 3. Notifikasi ke Siswa
        \App\Models\Notification::create([
            'user_id' => $request->student_id,
            'message' => 'Jadwal konseling baru telah dibuat untuk Anda pada ' . $request->scheduled_date . ' pukul ' . $request->start_time,
            'status' => 'unread',
        ]);

        return redirect()->route('admin.schedules.index')
                         ->with('success', 'Jadwal konseling berhasil dibuat.');
    }

    /**
     * Menampilkan form untuk mengedit jadwal. (UPDATE - Form)
     */
    public function edit(CounselingSchedule $schedule)
    {
        $students = User::where('role', 'student')->with('schoolClass')->orderBy('name')->get();
        $teachers = User::where('role', 'guru_bk')->orderBy('name')->get();
        $topics = Topic::where('is_custom', false)->orderBy('name')->get();
        
        return view('admin.schedules.edit', compact('schedule', 'students', 'teachers', 'topics'));
    }

    /**
     * Memperbarui data jadwal di database. (UPDATE - Store)
     */
    public function update(Request $request, CounselingSchedule $schedule)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'teacher_id' => 'required|exists:users,id',
            'topic_id' => 'required|string',
            'custom_topic' => 'nullable|string|max:255',
            'scheduled_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'location' => 'required|string|max:255',
        ], [
            'end_time.after' => 'Waktu selesai harus lebih besar dari waktu mulai.',
            'student_id.required' => 'Wajib memilih siswa.',
            'teacher_id.required' => 'Wajib memilih guru BK.',
            'topic_id.required' => 'Wajib memilih topik konseling.',
            'scheduled_date.required' => 'Wajib mengisi tanggal sesi.',
            'start_time.required' => 'Wajib mengisi waktu mulai.',
            'end_time.required' => 'Wajib mengisi waktu selesai.',
            'location.required' => 'Wajib mengisi lokasi sesi.',
        ]);

        // Logic Topik
        $topicId = null;
        if ($request->topic_id === 'custom' && $request->filled('custom_topic')) {
            $customName = trim($request->custom_topic);
            $topic = Topic::whereRaw('LOWER(name) = ?', [mb_strtolower($customName)])->first();
            if (!$topic) {
                $topic = Topic::create([
                    'name' => $customName,
                    'description' => 'Topik custom dibuat saat pembaruan jadwal.',
                    'is_custom' => true
                ]);
            }
            $topicId = $topic->id;
        } else {
            $topicId = $request->topic_id;
        }

        $schedule->update([
            'student_id' => $request->student_id,
            'teacher_id' => $request->teacher_id,
            'topic_id' => $topicId,
            'scheduled_date' => $request->scheduled_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'location' => $request->location,
        ]);

        return redirect()->route('admin.schedules.index')
                         ->with('success', 'Jadwal konseling berhasil diperbarui.');
    }

    /**
     * Menghapus jadwal dari database. (DELETE)
     */
    public function destroy(CounselingSchedule $schedule)
    {
        // Jika status SELESAI, kita izinkan Hapus Permanen (termasuk sesinya)
    if ($schedule->status === 'completed') {
        if ($schedule->session) {
            $schedule->session->delete();
        }
        $schedule->delete();
        return redirect()->route('admin.schedules.index')->with('success', 'Data sesi konseling berhasil dihapus permanen.');
    }

    // Jika status sudah DIBATALKAN, kita izinkan Hapus Permanen catatan tersebut
    if ($schedule->status === 'cancelled') {
        $schedule->delete();
        return redirect()->route('admin.schedules.index')->with('success', 'Catatan jadwal yang dibatalkan telah dihapus dari sistem.');
    }

    // Pencegahan pembatalan jika sudah ada draf sesi
    if ($schedule->session) {
        return redirect()->back()->with('error', 'Jadwal tidak dapat dibatalkan karena sudah memiliki Sesi Konseling. Silakan hapus sesi terlebih dahulu.');
    }
    
    // Ubah status jadwal menjadi DIBATALKAN (bukan menghapus langsung agar siswa tahu)
    $schedule->update(['status' => 'cancelled']);
    
    // Sinkronisasi ke CounselingRequest ditangani oleh Boot model CounselingSchedule yang telah kita buat
    
    return redirect()->route('admin.schedules.index')
                     ->with('success', 'Jadwal konseling berhasil dibatalkan. Status pada portal siswa juga berubah menjadi Dibatalkan.');
}
}