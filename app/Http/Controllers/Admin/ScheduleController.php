<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CounselingSchedule;
use App\Models\CounselingRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    /**
     * Menampilkan daftar semua jadwal konseling. (READ - Index)
     */
    public function index()
    {
        $schedules = CounselingSchedule::with(['student', 'teacher', 'counselingRequest'])
                        ->orderBy('scheduled_date', 'desc')
                        ->orderBy('start_time', 'desc')
                        ->paginate(10);
        
        return view('admin.schedules.index', compact('schedules'));
    }

    /**
     * Menampilkan form untuk membuat jadwal baru. (CREATE - Form)
     */
    public function create(Request $request)
    {
        $students = User::students()->orderBy('name')->get(); 
        $teachers = User::teachers()->orderBy('name')->get();
        
        // Cek apakah ada request_id yang dilewatkan (dari persetujuan permintaan)
        $requestId = $request->query('request_id');
        $requestData = null;
        if ($requestId) {
            $requestData = CounselingRequest::with('student')->find($requestId);
            if (!$requestData || $requestData->status !== 'pending') {
                return redirect()->route('admin.schedules.index')->with('error', 'Permintaan tidak valid atau sudah diproses.');
            }
        }
        
        return view('admin.schedules.create', compact('students', 'teachers', 'requestData'));
    }

    /**
     * Menyimpan jadwal baru ke database. (CREATE - Store)
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'teacher_id' => 'required|exists:users,id',
            'scheduled_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'counseling_request_id' => 'nullable|exists:counseling_requests,id',
        ]);
        
        // 1. Simpan Jadwal Konseling
        $schedule = CounselingSchedule::create([
            'student_id' => $request->student_id,
            'teacher_id' => $request->teacher_id,
            'scheduled_date' => $request->scheduled_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
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

        return redirect()->route('admin.schedules.index')
                         ->with('success', 'Jadwal konseling berhasil dibuat.');
    }

    /**
     * Menampilkan form untuk mengedit jadwal. (UPDATE - Form)
     */
    public function edit(CounselingSchedule $schedule)
    {
        $students = User::students()->orderBy('name')->get();
        $teachers = User::teachers()->orderBy('name')->get();
        
        return view('admin.schedules.edit', compact('schedule', 'students', 'teachers'));
    }

    /**
     * Memperbarui data jadwal di database. (UPDATE - Store)
     */
    public function update(Request $request, CounselingSchedule $schedule)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'teacher_id' => 'required|exists:users,id',
            'scheduled_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $schedule->update($request->all());

        return redirect()->route('admin.schedules.index')
                         ->with('success', 'Jadwal konseling berhasil diperbarui.');
    }

    /**
     * Menghapus jadwal dari database. (DELETE)
     */
    public function destroy(CounselingSchedule $schedule)
    {
        // Pencegahan: Jangan hapus jika sudah memiliki sesi terkait
        if ($schedule->session) {
            return redirect()->back()->with('error', 'Jadwal tidak dapat dihapus karena sudah memiliki Sesi Konseling terkait.');
        }
        
        // Jika jadwal berasal dari permintaan, kembalikan status permintaan ke pending
        if ($schedule->counselingRequest) {
            $schedule->counselingRequest->update(['status' => 'pending', 'teacher_id' => null]);
        }
        
        $schedule->delete();

        return redirect()->route('admin.schedules.index')
                         ->with('success', 'Jadwal konseling berhasil dibatalkan dan dihapus.');
    }
}