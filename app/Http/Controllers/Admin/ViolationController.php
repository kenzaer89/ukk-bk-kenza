<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Violation;
use App\Models\User;
use App\Models\Rule;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule as ValidationRule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; // Tambahkan ini

class ViolationController extends Controller
{
    /**
     * Menampilkan daftar pelanggaran.
     */
    public function index()
    {
        $violations = Violation::with(['student.schoolClass', 'rule'])
            ->latest('violation_date')
            ->paginate(10);

        return view('admin.violations.index', compact('violations'));
    }

    /**
     * Menampilkan form untuk mencatat pelanggaran baru.
     */
    public function create()
    {
        $students = User::where('role', 'student')->with('schoolClass')->orderBy('name')->get();
        $rules = Rule::orderBy('name')->get();
        return view('admin.violations.create', compact('students', 'rules'));
    }

    /**
     * Menampilkan form untuk mengedit pelanggaran.
     */
    public function edit(Violation $violation)
    {
        $students = User::where('role', 'student')->orderBy('name')->get();
        $rules = Rule::orderBy('name')->get();
        return view('admin.violations.edit', compact('violation', 'students', 'rules'));
    }

    /**
     * Memperbarui data pelanggaran.
     */
    public function update(Request $request, Violation $violation)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'rule_id' => 'required|exists:rules,id',
            'violation_date' => 'required|date',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,resolved,escalated',
        ]);

        // Hitung selisih poin jika rule berubah
        $oldRule = $violation->rule;
        $newRule = Rule::find($request->rule_id);
        
        if ($oldRule && $newRule && $violation->student) {
            // Kembalikan poin lama
            $violation->student->increment('points', $oldRule->points);
            // Kurangi poin baru
            $violation->student->decrement('points', $newRule->points);
        }

        $violation->update([
            'student_id' => $request->student_id,
            'rule_id' => $request->rule_id,
            'violation_date' => $request->violation_date,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.violations.index')
                         ->with('success', 'Data pelanggaran berhasil diperbarui dan poin telah disesuaikan.');
    }

    /**
     * Menghapus data pelanggaran.
     */
    public function destroy(Violation $violation)
    {
        // Kembalikan poin siswa sebelum menghapus data pelanggaran
        $student = $violation->student;
        if ($student && $violation->rule) {
            $student->increment('points', $violation->rule->points);
        }

        $violation->delete();
        return redirect()->route('admin.violations.index')
                         ->with('success', 'Data pelanggaran berhasil dihapus dan poin siswa telah dikembalikan.');
    }

    /**
     * Menyimpan data pelanggaran baru. (CREATE - Store)
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id,role,student',
            'rule_id' => 'required|exists:rules,id',
            'violation_date' => 'required|date',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,resolved,escalated',
        ]);

        try {
            $violation = Violation::create([
                'student_id' => $request->student_id,
                'rule_id' => $request->rule_id,
                'violation_date' => $request->violation_date,
                'description' => $request->description,
                'teacher_id' => Auth::id(), // PERBAIKAN: Gunakan Auth::id()
                'status' => $request->status, 
            ]);

            $rulePoints = $violation->rule->points;
            
            // Kurangi poin siswa
            $student = User::find($request->student_id);
            if ($student) {
                $student->decrement('points', $rulePoints);
            }

            return redirect()->route('admin.violations.index')
                             ->with('success', 'Pelanggaran siswa berhasil dicatat dan poin telah dikurangi (-' . $rulePoints . ').');

        } catch (\Exception $e) {
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Gagal mencatat pelanggaran. Error: ' . $e->getMessage());
        }
    }
}