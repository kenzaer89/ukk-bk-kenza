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
        $query = CounselingSchedule::with(['student', 'teacher', 'counselingRequest', 'topic', 'session'])
            ->where('is_visible_to_admin', true)
            ->whereNull('counseling_request_id');

        // Filter by status if provided
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by search if provided
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('student', function($sq) use ($search) {
                    $sq->where('name', 'like', "%{$search}%");
                })->orWhere('teacher_name', 'like', "%{$search}%")
                ->orWhereHas('teacher', function($tq) use ($search) {
                    $tq->where('name', 'like', "%{$search}%");
                })->orWhere('location', 'like', "%{$search}%");
            });
        }

        $schedules = $query->latest('scheduled_date')
                        ->latest('start_time')
                        ->latest()
                        ->paginate(10)
                        ->withQueryString();
        
        // Count for stats
        $counts = [
            'all' => CounselingSchedule::where('is_visible_to_admin', true)->whereNull('counseling_request_id')->count(),
            'scheduled' => CounselingSchedule::where('is_visible_to_admin', true)->whereNull('counseling_request_id')->where('status', 'scheduled')->count(),
            'completed' => CounselingSchedule::where('is_visible_to_admin', true)->whereNull('counseling_request_id')->where('status', 'completed')->count(),
            'cancelled' => CounselingSchedule::where('is_visible_to_admin', true)->whereNull('counseling_request_id')->where('status', 'cancelled')->count(),
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
            'teacher_name' => 'required|string|max:255',
            'topic_id' => 'required|string', // Bisa 'custom' atau ID numerik
            'custom_topic' => 'nullable|string|max:255',
            'scheduled_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'location' => 'required|string|max:255',
            'counseling_request_id' => 'nullable|exists:counseling_requests,id',
        ], [
            'end_time.after' => 'waktu selesai tidak boleh sama atau kurang dari waktu pukul',
            'student_id.required' => 'Wajib memilih siswa.',
            'teacher_name.required' => 'Wajib mengisi nama guru penanggung jawab.',
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

        // Check for conflicts - check against ALL schedules
        $conflict = CounselingSchedule::where('scheduled_date', $request->scheduled_date)
            ->whereIn('status', ['scheduled', 'completed'])
            ->where(function($query) use ($request) {
                $query->where('start_time', '<', $request->end_time)
                      ->where('end_time', '>', $request->start_time);
            })
            ->where(function($query) use ($request) {
                // Group identity checks
                $query->where(function($q) use ($request) {
                    $q->where('student_id', $request->student_id)
                      ->orWhere('teacher_id', Auth::id())
                      ->orWhere('teacher_name', $request->teacher_name)
                      ->orWhere(function($sq) use ($request) {
                          $sq->whereRaw('LOWER(location) = ?', [strtolower($request->location)])
                            ->whereNotNull('location');
                      });
                });
            })
            ->first();

        if ($conflict && !$request->has('ignore_conflict')) {
            $conflictType = '';
            if ($conflict->student_id == $request->student_id) $conflictType = "Siswa " . $conflict->student->name;
            elseif ($conflict->teacher_id == Auth::id() || $conflict->teacher_name == $request->teacher_name) $conflictType = "Guru BK (" . $request->teacher_name . ")";
            else $conflictType = "Lokasi " . $conflict->location;

            $conflictTime = substr($conflict->start_time, 0, 5) . ' - ' . substr($conflict->end_time, 0, 5);
            return redirect()->back()
                ->withInput()
                ->with('error', "Jadwal Bertabrakan! {$conflictType} sudah memiliki agenda pada pukul {$conflictTime} WIB. Silakan pilih waktu atau lokasi lain.");
        }
        
        // 1. Simpan Jadwal Konseling
        $schedule = CounselingSchedule::create([
            'student_id' => $request->student_id,
            'teacher_id' => Auth::id(), // For system tracking
            'teacher_name' => $request->teacher_name,
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
                $req->update([
                    'status' => 'approved', 
                    'teacher_id' => Auth::id(), 
                    'teacher_name' => $request->teacher_name
                ]);
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
            'teacher_name' => 'required|string|max:255',
            'topic_id' => 'required|string',
            'custom_topic' => 'nullable|string|max:255',
            'scheduled_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'location' => 'required|string|max:255',
        ], [
            'end_time.after' => 'waktu selesai tidak boleh sama atau kurang dari waktu pukul',
            'student_id.required' => 'Wajib memilih siswa.',
            'teacher_name.required' => 'Wajib mengisi nama guru penanggung jawab.',
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

        // Check for conflicts - check against ALL schedules
        $conflict = CounselingSchedule::where('scheduled_date', $request->scheduled_date)
            ->whereIn('status', ['scheduled', 'completed'])
            ->where('id', '!=', $schedule->id)
            ->where(function($query) use ($request) {
                $query->where('start_time', '<', $request->end_time)
                      ->where('end_time', '>', $request->start_time);
            })
            ->where(function($query) use ($request) {
                $query->where(function($q) use ($request) {
                    $q->where('student_id', $request->student_id)
                      ->orWhere('teacher_id', Auth::id())
                      ->orWhere('teacher_name', $request->teacher_name)
                      ->orWhere(function($sq) use ($request) {
                          $sq->whereRaw('LOWER(location) = ?', [strtolower($request->location)])
                            ->whereNotNull('location');
                      });
                });
            })
            ->first();

        if ($conflict && !$request->has('ignore_conflict')) {
            $conflictType = '';
            if ($conflict->student_id == $request->student_id) $conflictType = "Siswa " . $conflict->student->name;
            elseif ($conflict->teacher_id == Auth::id() || $conflict->teacher_name == $request->teacher_name) $conflictType = "Guru BK (" . $request->teacher_name . ")";
            else $conflictType = "Lokasi " . $conflict->location;

            $conflictTime = substr($conflict->start_time, 0, 5) . ' - ' . substr($conflict->end_time, 0, 5);
            return redirect()->back()
                ->withInput()
                ->with('error', "Jadwal Bertabrakan! {$conflictType} sudah memiliki agenda pada pukul {$conflictTime} WIB. Silakan pilih waktu atau lokasi lain.");
        }

        $schedule->update([
            'student_id' => $request->student_id,
            'teacher_name' => $request->teacher_name,
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
        // Jika sudah diarsipkan (is_visible_to_admin == false), maka hapus permanen
        if (!$schedule->is_visible_to_admin) {
            if ($schedule->session) {
                $schedule->session->delete();
            }
            $schedule->delete();
            return redirect()->route('admin.schedules.index')->with('success', 'Data berhasil dihapus permanen dari sistem.');
        }

        // Jika status SELESAI atau DIBATALKAN, sembunyikan saja
        if ($schedule->status === 'completed' || $schedule->status === 'cancelled') {
            $schedule->update(['is_visible_to_admin' => false]);
            return redirect()->route('admin.schedules.index')->with('success', 'Data ditutup dan diarsipkan dari daftar admin.');
        }

        // Jika masih TERJADWAL, tawarkan untuk membatalkan statusnya dulu atau langsung sembunyikan
        // Di sini kita sembunyikan saja dan otomatis ubah status jadi cancelled jika belum
        if ($schedule->status === 'scheduled') {
            $schedule->update([
                'status' => 'cancelled',
                'is_visible_to_admin' => false
            ]);
            return redirect()->route('admin.schedules.index')->with('success', 'Jadwal dibatalkan dan diarsipkan dari daftar admin.');
        }

        return redirect()->back()->with('error', 'Gagal memproses penghapusan data.');
    }
    /**
     * Mengecek bentrok jadwal konseling.
     */
    public function checkConflict(Request $request)
    {
        $date = $request->scheduled_date ?? $request->session_date;
        $startTime = $request->start_time;
        $endTime = $request->end_time;
        $excludeId = $request->id; // Untuk mode edit

        $studentId = $request->student_id;
        $teacherName = $request->teacher_name;
        $location = $request->location;

        // Cari jadwal yang overlap waktu (cek SEMUA jadwal)
        $conflicts = CounselingSchedule::with(['student.schoolClass', 'teacher'])
            ->where('scheduled_date', $date)
            ->whereIn('status', ['scheduled', 'completed'])
            ->where(function($query) use ($startTime, $endTime) {
                $query->where('start_time', '<', $endTime)
                      ->where('end_time', '>', $startTime);
            })
            ->where(function($query) use ($studentId, $teacherName, $location) {
                $query->where(function($q) use ($studentId, $teacherName, $location) {
                    $q->where('student_id', $studentId)
                      ->orWhere('teacher_id', Auth::id())
                      ->orWhere('teacher_name', $teacherName)
                      ->orWhere(function($sq) use ($location) {
                          if ($location) {
                              $sq->whereRaw('LOWER(location) = ?', [strtolower($location)]);
                          } else {
                              $sq->where('id', 0);
                          }
                      });
                });
            })
            ->when($excludeId, function($query) use ($excludeId) {
                $query->where('id', '!=', $excludeId);
            })
            ->get();
                
        if ($conflicts->count() > 0) {
            $conflictDetails = $conflicts->map(function($conflict) use ($studentId, $teacherName) {
                $conflictType = '';
                if ($conflict->student_id == $studentId) {
                    $conflictType = "Siswa (" . ($conflict->student->name ?? 'Siswa') . ")";
                } elseif ($conflict->teacher_id == Auth::id() || $conflict->teacher_name == $teacherName) {
                    $conflictType = "Guru BK (" . ($conflict->teacher->name ?? $conflict->teacher_name) . ")";
                } else {
                    $conflictType = "Lokasi (" . $conflict->location . ")";
                }

                return [
                    'student_name' => $conflict->student->name ?? 'Siswa',
                    'class_name' => $conflict->student->schoolClass->name ?? '-',
                    'time_range' => \Carbon\Carbon::parse($conflict->start_time)->format('H:i') . ' - ' . \Carbon\Carbon::parse($conflict->end_time)->format('H:i'),
                    'location' => $conflict->location,
                    'teacher_name' => $conflict->teacher_name ?? ($conflict->teacher->name ?? 'Guru BK'),
                    'conflict_type' => $conflictType
                ];
            });

            return response()->json([
                'conflict' => true,
                'count' => $conflicts->count(),
                'details' => $conflictDetails
            ]);
        }

        return response()->json(['conflict' => false]);
    }
}