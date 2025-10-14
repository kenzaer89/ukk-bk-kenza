<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MonthlyReport;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $reports = MonthlyReport::with('class','creator')->orderBy('year','desc')->orderBy('month','desc')->paginate(12);
        return view('admin.reports.index', compact('reports'));
    }

    public function create()
    {
        $classes = SchoolClass::all();
        return view('admin.reports.create', compact('classes'));
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'month'=>'required|integer|min:1|max:12',
            'year'=>'required|integer|min:2020',
            'class_id'=>'required',
            'data'=>'nullable|string',
        ]);
        $data['created_by'] = session('user.id');
        MonthlyReport::create($data);
        return redirect()->route('admin.reports.index')->with('success','Laporan bulanan ditambahkan');
    }

    public function show(MonthlyReport $report)
    {
        return view('admin.reports.show', compact('report'));
    }

    public function destroy(MonthlyReport $report)
    {
        $report->delete();
        return back()->with('success','Laporan dihapus');
    }
}
