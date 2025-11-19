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

            return redirect()->route('admin.violations.index')
                             ->with('success', 'Pelanggaran siswa berhasil dicatat dan poin telah dikurangi (-' . $rulePoints . ').');

        } catch (\Exception $e) {
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Gagal mencatat pelanggaran. Error: ' . $e->getMessage());
        }
    }
}