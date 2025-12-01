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
            'rule_id' => 'required',
            'violation_date' => 'required|date',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,resolved,escalated',
        ]);

        // If custom rule selected, validate custom fields
        if ($request->rule_id === 'custom') {
            $request->validate([
                'custom_rule_name' => 'required|string|max:255',
                'custom_points' => 'required|integer',
            ]);
        } else {
            // Ensure selected rule exists when not custom
            $request->validate([
                'rule_id' => 'exists:rules,id',
            ]);
        }

        // Logika Update Poin:
        // 1. Kembalikan dampak poin dari data lama (jika status sebelumnya 'resolved')
        if ($violation->status === 'resolved' && $violation->student && $violation->rule) {
            // Poin negatif, jadi decrement untuk mengembalikan (kurang minus = tambah)
            $violation->student->decrement('points', $violation->rule->points);
        }

        // If the admin selected a custom rule, create it
        $ruleIdToUse = $request->rule_id;
        if ($ruleIdToUse === 'custom') {
            $customPoints = (int) $request->custom_points;
            if ($customPoints > 0) {
                $customPoints = -1 * $customPoints;
            }
            $newRule = Rule::create([
                'name' => $request->custom_rule_name,
                'points' => $customPoints,
                'description' => 'Aturan custom dibuat melalui edit pelanggaran',
                'category' => 'custom'
            ]);
            $ruleIdToUse = $newRule->id;
        }

        // 2. Update data pelanggaran
        $violation->update([
            'student_id' => $request->student_id,
            'rule_id' => $ruleIdToUse,
            'violation_date' => $request->violation_date,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        // 3. Terapkan dampak poin data baru (jika status baru 'resolved')
        // Refresh relasi untuk mendapatkan data terbaru
        $violation->refresh();
        
        if ($violation->status === 'resolved' && $violation->student && $violation->rule) {
            // Poin negatif, jadi increment untuk mengurangi (tambah minus = kurang)
            $violation->student->increment('points', $violation->rule->points);
        }

        return redirect()->route('admin.violations.index')
                         ->with('success', 'Data pelanggaran berhasil diperbarui dan poin telah disesuaikan dengan status.');
    }

    /**
     * Menghapus data pelanggaran.
     */
    public function destroy(Violation $violation)
    {
        // Kembalikan poin siswa HANYA jika statusnya 'resolved'
        // Jika pending, berarti poin belum dikurangi, jadi tidak perlu dikembalikan
        if ($violation->status === 'resolved') {
            $student = $violation->student;
            if ($student && $violation->rule) {
                // Poin negatif, jadi decrement untuk mengembalikan (kurang minus = tambah)
                $student->decrement('points', $violation->rule->points);
            }
        }

        $violation->delete();
        return redirect()->route('admin.violations.index')
                         ->with('success', 'Data pelanggaran berhasil dihapus.');
    }

    /**
     * Menyimpan data pelanggaran baru. (CREATE - Store)
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id,role,student',
            'rule_id' => 'required',
            'violation_date' => 'required|date',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,resolved,escalated',
        ]);

        // If custom rule selected, validate custom fields
        if ($request->rule_id === 'custom') {
            $request->validate([
                'custom_rule_name' => 'required|string|max:255',
                'custom_points' => 'required|integer',
            ]);
        } else {
            // Ensure selected rule exists when not custom
            $request->validate([
                'rule_id' => 'exists:rules,id',
            ]);
        }

        try {
            $ruleId = $request->rule_id;
            if ($ruleId === 'custom') {
                // Ensure the custom points are stored as negative so that deduction works correctly
                $customPoints = (int) $request->custom_points;
                if ($customPoints > 0) {
                    $customPoints = -1 * $customPoints;
                }
                $newRule = Rule::create([
                    'name' => $request->custom_rule_name,
                    'points' => $customPoints,
                    'description' => 'Aturan custom dibuat melalui form catat pelanggaran',
                    'category' => 'custom'
                ]);
                $ruleId = $newRule->id;
            }

            $violation = Violation::create([
                'student_id' => $request->student_id,
                'rule_id' => $ruleId,
                'violation_date' => $request->violation_date,
                'description' => $request->description,
                'teacher_id' => Auth::id(),
                'status' => $request->status, 
            ]);

            $message = 'Pelanggaran siswa berhasil dicatat.';

            // HANYA kurangi poin jika statusnya 'resolved'
            if ($request->status === 'resolved') {
                $rulePoints = $violation->rule->points;
                
                $student = User::find($request->student_id);
                if ($student) {
                    // Poin negatif, jadi increment untuk mengurangi (tambah minus = kurang)
                    $student->increment('points', $rulePoints);
                }
                $message .= ' Poin telah dikurangi (' . $rulePoints . ').';
            } else {
                $message .= ' Poin belum dikurangi karena status masih ' . $request->status . '.';
            }

            return redirect()->route('admin.violations.index')
                             ->with('success', $message);

        } catch (\Exception $e) {
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Gagal mencatat pelanggaran. Error: ' . $e->getMessage());
        }
    }
}