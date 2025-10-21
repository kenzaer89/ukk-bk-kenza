<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Violation;
use App\Models\User;
use App\Models\Rule;
use Illuminate\Http\Request;

class ViolationController extends Controller
{
    public function index()
    {
        $violations = Violation::with(['student','rule'])
            ->orderBy('violation_date','desc')
            ->paginate(20);

        return view('admin.violations.index', compact('violations'));
    }

    public function create()
    {
        $students = User::where('role','student')->get();
        $rules = Rule::all();
        return view('admin.violations.create', compact('students','rules'));
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'student_id'=>'required',
            'rule_id'=>'required',
            'violation_date'=>'required|date',
            'notes'=>'nullable|string',
        ]);

        $data['points'] = Rule::find($data['rule_id'])->points ?? 0;

        Violation::create($data);

        return redirect()->route('admin.violations.index')->with('success','Pelanggaran ditambahkan');
    }

    public function edit(Violation $violation)
    {
        $students = User::where('role','student')->get();
        $rules = Rule::all();
        return view('admin.violations.edit', compact('violation','students','rules'));
    }

    public function update(Request $r, Violation $violation)
    {
        $data = $r->validate([
            'student_id'=>'required',
            'rule_id'=>'required',
            'violation_date'=>'required|date',
            'notes'=>'nullable|string',
        ]);

        $violation->update($data);

        return back()->with('success','Pelanggaran diperbarui');
    }

    public function destroy(Violation $violation)
    {
        $violation->delete();
        return back()->with('success','Data dihapus');
    }
}
