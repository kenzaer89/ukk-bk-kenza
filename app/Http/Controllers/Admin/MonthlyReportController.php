<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MonthlyReport;
use App\Models\Violation;
use App\Models\CounselingSession;
use App\Models\User;
use App\Models\Rule;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; // Tambahkan ini

class MonthlyReportController extends Controller
{
    /**
     * Menampilkan daftar semua laporan bulanan.
     */
    public function index()
    {
        // PERBAIKAN: Gunakan Auth::user() atau $request->user() di method yang menerima Request
        $user = Auth::user(); 

        $query = MonthlyReport::with('teacher')->latest();
        
        if ($user->role === 'guru_bk') {
            $query->where('teacher_id', $user->id);
        }

        $reports = $query->paginate(10);
        
        return view('admin.monthly_reports.index', compact('reports'));
    }

    /**
     * Menyimpan data laporan bulanan baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2020',
            'summary' => 'required|string',
            'status' => 'required|in:draft,submitted',
        ]);
        
        $reportDate = Carbon::create($request->year, $request->month, 1);
        
        // PERBAIKAN: Gunakan Auth::id() atau auth()->id()
        $existingReport = MonthlyReport::whereYear('report_date', $request->year)
                                        ->whereMonth('report_date', $request->month)
                                        ->where('teacher_id', Auth::id()) // Perbaikan di sini
                                        ->first();

        if ($existingReport) {
            return redirect()->back()->withInput()->with('error', 'Laporan bulanan untuk bulan dan tahun ini sudah ada.');
        }

        MonthlyReport::create([
            'report_date' => $reportDate,
            'summary' => $request->summary,
            'teacher_id' => Auth::id(), // Perbaikan di sini
            'status' => $request->status,
        ]);

        return redirect()->route('admin.monthly_reports.index')
                         ->with('success', 'Laporan Bulanan berhasil disimpan.');
    }

    /**
     * Helper: Mendapatkan Top 5 Siswa dengan poin pelanggaran terbanyak di bulan itu
     */
    private function getTopViolatingStudents($startDate, $endDate)
    {
        // PERBAIKAN: Tambahkan use statement untuk model User jika diperlukan
        $topStudents = Violation::select('student_id')
            ->selectRaw('SUM(rules.points) as total_points_deducted')
            ->whereBetween('violation_date', [$startDate, $endDate])
            ->join('rules', 'violations.rule_id', '=', 'rules.id')
            ->groupBy('student_id')
            ->orderByDesc('total_points_deducted')
            ->take(5)
            // PERBAIKAN: Pastikan relasi 'student' dan 'schoolClass' ada di model Violation
            ->with(['student' => function($q) { 
                $q->with('schoolClass'); 
            }]) 
            ->get();
            
        return $topStudents;
    }
}