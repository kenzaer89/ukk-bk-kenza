<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CounselingRequest;
use App\Models\CounselingSchedule;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification as AppNotification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CounselingRequestController extends Controller
{
    /**
     * Display a listing of counseling requests
     */
    public function index(Request $request)
    {
        $query = CounselingRequest::where('is_visible_to_admin', true)->with(['student', 'schedule']);
        
        // Filter by status if provided
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by search term
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('student', function($sq) use ($search) {
                    $sq->where('name', 'like', "%{$search}%");
                })->orWhere('reason', 'like', "%{$search}%");
            });
        }
        
        $requests = $query->latest()->paginate(15)->withQueryString();

        // Count for stats
        $counts = [
            'all' => CounselingRequest::where('is_visible_to_admin', true)->count(),
            'pending' => CounselingRequest::where('is_visible_to_admin', true)->where('status', 'pending')->count(),
            'approved' => CounselingRequest::where('is_visible_to_admin', true)->where('status', 'approved')->count(),
            'rejected' => CounselingRequest::where('is_visible_to_admin', true)->where('status', 'rejected')->count(),
            'canceled' => CounselingRequest::where('is_visible_to_admin', true)->where('status', 'canceled')->count(),
        ];
        
        return view('admin.counseling_requests.index', compact('requests', 'counts'));
    }

    /**
     * Show the form for viewing a specific request
     */
    public function show(CounselingRequest $counseling_request)
    {
        $counseling_request->load(['student', 'teacher', 'schedule']);
        
        $teachers = User::whereIn('role', ['admin', 'guru_bk', 'wali_kelas'])->orderBy('name')->get();
        
        return view('admin.counseling_requests.show', compact('counseling_request', 'teachers'));
    }

    /**
     * Approve a counseling request and create schedule
     */
    public function approve(Request $request, CounselingRequest $counseling_request)
    {
        $request->validate([
            'scheduled_date' => 'nullable|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:500',
            'teacher_name' => 'required|string',
        ], [
            'end_time.after' => 'waktu selesai tidak boleh sama atau kurang dari waktu pukul',
        ]);

        $scheduledDate = $request->filled('scheduled_date') ? $request->scheduled_date : now()->toDateString();
        $location = $request->location ?: 'Ruang BK';

        // No longer connecting to User table for the "handling teacher" name
        // We just take whatever they typed
        $teacherName = trim($request->teacher_name);
        
        // Tracking who approved it (current admin/guru bk)
        $approverId = Auth::id();

        // Check for conflicts - check against ALL schedules
        $conflict = CounselingSchedule::where('scheduled_date', $scheduledDate)
            ->whereIn('status', ['scheduled', 'completed'])
            ->where(function($query) use ($request) {
                $query->where('start_time', '<', $request->end_time)
                      ->where('end_time', '>', $request->start_time);
            })
            ->where(function($query) use ($request, $teacherName, $counseling_request) {
                // Group identity checks
                $query->where(function($q) use ($request, $teacherName, $counseling_request) {
                    $q->where('student_id', $counseling_request->student_id)
                      ->orWhere('teacher_id', Auth::id())
                      ->orWhere('teacher_name', $teacherName)
                      ->orWhere(function($sq) use ($request) {
                          $sq->whereRaw('LOWER(location) = ?', [strtolower($request->location)])
                            ->whereNotNull('location');
                      });
                });
            })
            ->first();

        if ($conflict && !$request->has('ignore_conflict')) {
            $conflictType = '';
            if ($conflict->student_id == $counseling_request->student_id) {
                $conflictType = "Siswa " . $conflict->student->name;
            } elseif ($conflict->teacher_id == Auth::id() || $conflict->teacher_name == $teacherName) {
                $conflictType = "Guru BK (" . $teacherName . ")";
            } else {
                $conflictType = "Lokasi " . $conflict->location;
            }

            $conflictTime = substr($conflict->start_time, 0, 5) . ' - ' . substr($conflict->end_time, 0, 5);
            return redirect()->back()
                ->withInput()
                ->with('error', "Jadwal Bertabrakan! {$conflictType} sudah memiliki agenda pada pukul {$conflictTime} WIB. Silakan pilih waktu atau lokasi lain.");
        }

        try {
            \DB::beginTransaction();

            // Update request status
            $counseling_request->update([
                'status' => 'approved',
                'teacher_id' => $approverId,
                'teacher_name' => $teacherName,
                'notes' => $request->notes,
            ]);

            // Create schedule
            CounselingSchedule::create([
                'student_id' => $counseling_request->student_id,
                'teacher_id' => $approverId,
                'teacher_name' => $teacherName,
                'counseling_request_id' => $counseling_request->id,
                'topic_id' => $counseling_request->topic_id,
                'scheduled_date' => $scheduledDate,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'location' => $location,
                'admin_notes' => $request->notes,
                'status' => 'scheduled',
            ]);

            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memproses persetujuan: ' . $e->getMessage());
        }

        // Notify the student & parent that their request has been approved
        $notifMessage = Str::limit('Permintaan konseling Anda telah disetujui. Jadwal: ' . $scheduledDate . ' ' . $request->start_time, 190);
        AppNotification::create([
            'user_id' => $counseling_request->student_id,
            'message' => $notifMessage,
            'status' => 'unread',
        ]);

        if ($counseling_request->student) {
            foreach ($counseling_request->student->childrenConnections as $connection) {
                $pNotifMsg = Str::limit("📅 Jadwal Konseling (" . $counseling_request->student->name . ") telah disetujui untuk tanggal " . $scheduledDate . " pukul " . $request->start_time, 190);
                AppNotification::create([
                    'user_id' => $connection->parent_id,
                    'message' => $pNotifMsg,
                    'status' => 'unread',
                ]);
            }
        }

        return redirect()->route('admin.counseling_requests.index')
            ->with('success', 'Permintaan konseling berhasil disetujui dan jadwal telah dibuat.');
    }

    /**
     * Reject a counseling request
     */
    public function reject(Request $request, CounselingRequest $counseling_request)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $counseling_request->update([
            'status' => 'rejected',
            'teacher_id' => Auth::id(),
            'notes' => $request->rejection_reason,
        ]);

        // Notify the student & parent that their request has been rejected
        $notifMessage = Str::limit('Permintaan konseling Anda ditolak. Alasan: ' . ($request->rejection_reason ?? '-'), 190);
        AppNotification::create([
            'user_id' => $counseling_request->student_id,
            'message' => $notifMessage,
            'status' => 'unread',
        ]);

        if ($counseling_request->student) {
            foreach ($counseling_request->student->childrenConnections as $connection) {
                $pNotifMsg = Str::limit("❌ Permintaan Konseling (" . $counseling_request->student->name . ") ditolak. Alasan: " . ($request->rejection_reason ?? '-'), 190);
                AppNotification::create([
                    'user_id' => $connection->parent_id,
                    'message' => $pNotifMsg,
                    'status' => 'unread',
                ]);
            }
        }

        return redirect()->route('admin.counseling_requests.index')
            ->with('success', 'Permintaan konseling telah ditolak.');
    }

    /**
     * Postpone a counseling request
     */
    public function postpone(Request $request, CounselingRequest $counseling_request)
    {
        $request->validate([
            'postpone_reason' => 'nullable|string|max:500',
        ]);

        $counseling_request->update([
            'status' => 'pending',
            'teacher_id' => Auth::id(),
            'notes' => $request->postpone_reason,
        ]);

        return redirect()->route('admin.counseling_requests.index')
            ->with('success', 'Permintaan konseling ditunda untuk ditinjau lebih lanjut.');
    }

    /**
     * Delete a counseling request
     */
    public function destroy(CounselingRequest $counseling_request)
    {
        // Jika sudah diarsipkan (is_visible_to_admin == false), maka hapus permanen
        if (!$counseling_request->is_visible_to_admin) {
            $counseling_request->delete();
            return redirect()->route('admin.counseling_requests.index')
                ->with('success', 'Data permintaan konseling berhasil dihapus permanen.');
        }

        // Jika status bukan PENDING (sudah diproses/selesai/batal), sembunyikan saja
        if ($counseling_request->status !== 'pending') {
            $counseling_request->update(['is_visible_to_admin' => false]);
            return redirect()->route('admin.counseling_requests.index')
                ->with('success', 'Permintaan telah diarsipkan dari daftar admin.');
        }

        // Jika masih PENDING, ubah status jadi canceled dan sembunyikan
        $counseling_request->update([
            'status' => 'canceled',
            'is_visible_to_admin' => false
        ]);

        return redirect()->route('admin.counseling_requests.index')
            ->with('success', 'Permintaan dibatalkan dan diarsipkan dari daftar admin.');
    }

    public function checkConflict(Request $request) 
    {
        $start_time = $request->start_time ?? $request->query('start_time');
        $end_time = $request->end_time ?? $request->query('end_time');
        $date = $request->date ?? $request->query('date', now()->toDateString());

        $teacherName = $request->teacher_name;
        $location = $request->location;
        $studentId = $request->student_id;

        // Admin is approving a request, check against ALL actual schedules
        $conflicts = CounselingSchedule::with(['student.schoolClass', 'teacher'])
            ->where('scheduled_date', $date)
            ->whereIn('status', ['scheduled', 'completed'])
            ->where(function($query) use ($start_time, $end_time) {
                $query->where('start_time', '<', $end_time)
                      ->where('end_time', '>', $start_time);
            })
            ->where(function($query) use ($studentId, $teacherName, $location) {
                $query->where('student_id', $studentId)
                      ->orWhere('teacher_id', Auth::id())
                      ->orWhere('teacher_name', $teacherName)
                      ->orWhere(function($sq) use ($location) {
                          if ($location) {
                              $sq->whereRaw('LOWER(location) = ?', [strtolower($location)]);
                          } else {
                              $sq->where('id', 0); // null location in request shouldn't conflict with any location
                          }
                      });
            })
            ->get();
                
        if ($conflicts->count() > 0) {
            $conflictDetails = $conflicts->map(function($conflict) use ($studentId, $teacherName) {
                $conflictType = '';
                if ($conflict->student_id == $studentId) {
                    $conflictType = "Siswa (" . $conflict->student->name . ")";
                } elseif ($conflict->teacher_id == Auth::id() || $conflict->teacher_name == $teacherName) {
                    $conflictType = "Guru BK (" . ($conflict->teacher->name ?? $conflict->teacher_name) . ")";
                } else {
                    $conflictType = "Lokasi (" . $conflict->location . ")";
                }

                return [
                    'student_name' => $conflict->student->name,
                    'class_name' => $conflict->student->schoolClass->name ?? '-',
                    'time_range' => \Carbon\Carbon::parse($conflict->start_time)->format('H:i') . ' - ' . \Carbon\Carbon::parse($conflict->end_time)->format('H:i'),
                    'location' => $conflict->location,
                    'teacher_name' => $conflict->teacher_name ?? ($conflict->teacher->name ?? 'Guru BK'),
                    'conflict_type' => $conflictType,
                    'schedule_url' => $conflict->counseling_request_id 
                        ? route('admin.counseling_requests.show', $conflict->counseling_request_id) 
                        : route('admin.schedules.edit', $conflict->id)
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
