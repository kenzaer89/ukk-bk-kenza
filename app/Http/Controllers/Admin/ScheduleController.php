<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CounselingSchedule;
use App\Models\User; // Pastikan ini di-import

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = CounselingSchedule::orderBy('scheduled_date', 'desc')->paginate(15);
        return view('admin.schedules.index', compact('schedules'));
    }

    public function create()
    {
        // kalau tetap ingin pilih guru BK dari user
        $teachers = User::whereIn('role', ['admin', 'guru_bk'])->get();
        // Students tidak perlu dikirim karena kita akan mencari berdasarkan nama input manual
        return view('admin.schedules.create', compact('teachers'));
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            // Validasi 'student_name' untuk mencari ID siswa
            'student_name'      => 'required|string|max:255',
            'teacher_id'        => 'nullable|exists:users,id',
            'scheduled_date'    => 'required|date',
            'start_time'        => 'required',
            'end_time'          => 'nullable',
            'topic'             => 'nullable|string|max:255',
            'status'            => 'nullable|string|max:50',
        ]);

        // 1. Cari siswa berdasarkan student_name yang diinput
        $student = User::where('name', $data['student_name'])
                       ->where('role', 'siswa') // Tambahkan filter role jika perlu
                       ->first();

        // 2. Jika siswa tidak ditemukan, kembalikan error validasi.
        if (!$student) {
            return back()->withErrors([
                'student_name' => 'Siswa dengan nama tersebut tidak ditemukan atau bukan berstatus Siswa.'
            ])->withInput();
        }

        // 3. Tambahkan student_id ke array data
        $data['student_id'] = $student->id;

        // 4. Hapus student_name dari data karena kolom ini tidak ada di tabel schedules
        unset($data['student_name']);

        // 5. Simpan data (Sekarang $data sudah memiliki 'student_id')
        CounselingSchedule::create($data);

        return redirect()
            ->route('admin.schedules.index')
            ->with('success', 'Jadwal konseling berhasil dibuat!');
    }

    public function edit(CounselingSchedule $schedule)
    {
        $teachers = User::whereIn('role', ['admin', 'guru_bk'])->get();
        return view('admin.schedules.edit', compact('schedule', 'teachers'));
    }

    public function update(Request $r, CounselingSchedule $schedule)
    {
        // Logika update perlu diperbaiki dengan cara yang sama seperti store,
        // mencari ID siswa dari nama yang diinput.
        $data = $r->validate([
            'student_name'      => 'required|string|max:255',
            'teacher_id'        => 'nullable|exists:users,id',
            'scheduled_date'    => 'required|date',
            'start_time'        => 'required',
            'end_time'          => 'nullable',
            'topic'             => 'nullable|string|max:255',
            'status'            => 'nullable|string|max:50',
        ]);

        $student = User::where('name', $data['student_name'])->where('role', 'siswa')->first();

        if (!$student) {
            return back()->withErrors([
                'student_name' => 'Siswa dengan nama tersebut tidak ditemukan.'
            ])->withInput();
        }

        $data['student_id'] = $student->id;
        unset($data['student_name']);
        
        $schedule->update($data);

        return back()->with('success', 'Jadwal berhasil diperbarui!');
    }

    public function destroy(CounselingSchedule $schedule)
    {
        $schedule->delete();
        return back()->with('success', 'Jadwal berhasil dihapus!');
    }
}