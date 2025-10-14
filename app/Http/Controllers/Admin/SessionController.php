<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CounselingSession;
use App\Models\CounselingSchedule;

class SessionController extends Controller
{
    public function index()
    {
        $sessions = CounselingSession::with('schedule.student')->orderBy('session_date','desc')->paginate(15);
        return view('admin.sessions.index', compact('sessions'));
    }

    public function create()
    {
        $schedules = CounselingSchedule::all();
        return view('admin.sessions.create', compact('schedules'));
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'schedule_id'=>'required',
            'session_date'=>'required|date',
            'teacher_notes'=>'nullable',
            'recommendations'=>'nullable',
        ]);
        CounselingSession::create($data);
        return redirect()->route('admin.sessions.index')->with('success','Sesi berhasil dibuat');
    }

    public function edit(CounselingSession $session)
    {
        $schedules = CounselingSchedule::all();
        return view('admin.sessions.edit', compact('session','schedules'));
    }

    public function update(Request $r, CounselingSession $session)
    {
        $data = $r->validate([
            'schedule_id'=>'required',
            'session_date'=>'required|date',
            'teacher_notes'=>'nullable',
            'recommendations'=>'nullable',
        ]);
        $session->update($data);
        return back()->with('success','Sesi diperbarui');
    }

    public function destroy(CounselingSession $session)
    {
        $session->delete();
        return back()->with('success','Sesi dihapus');
    }
}
