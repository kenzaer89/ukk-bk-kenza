<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CounselingSchedule;
use App\Models\User;

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
        return view('admin.schedules.create', compact('teachers'));
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'student_name'    => 'required|string|max:255',
            'teacher_id'      => 'nullable|exists:users,id',
            'scheduled_date'  => 'required|date',
            'start_time'      => 'required',
            'end_time'        => 'nullable',
            'topic'           => 'nullable|string|max:255',
            'status'          => 'nullable|string|max:50',
        ]);

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
        $data = $r->validate([
            'student_name'    => 'required|string|max:255',
            'teacher_id'      => 'nullable|exists:users,id',
            'scheduled_date'  => 'required|date',
            'start_time'      => 'required',
            'end_time'        => 'nullable',
            'topic'           => 'nullable|string|max:255',
            'status'          => 'nullable|string|max:50',
        ]);

        $schedule->update($data);

        return back()->with('success', 'Jadwal berhasil diperbarui!');
    }

    public function destroy(CounselingSchedule $schedule)
    {
        $schedule->delete();
        return back()->with('success', 'Jadwal berhasil dihapus!');
    }
}
