<?php

namespace App\Http\Controllers\ParentRole;

use App\Http\Controllers\Controller;
use App\Models\ParentStudent;
use App\Models\Violation;
use App\Models\CounselingSession;
use Illuminate\Http\Request;

class ParentDashboardController extends Controller
{
    public function index(Request $request)
    {
        $parent = \Illuminate\Support\Facades\Auth::user();
        $pid = $parent->id;
        
        // Ambil semua koneksi anak
        $childrenConnections = ParentStudent::with('student.schoolClass')->where('parent_id', $pid)->get();
        $childrenCount = $childrenConnections->count();

        // Jika tidak ada anak, tampilkan dashboard kosong
        if ($childrenCount === 0) {
            return view('parent.dashboard', ['data' => []]);
        }

        // Ambil ID anak yang sedang dipilih dari session
        $selectedChildId = session('selected_child_id');

        // Jika hanya punya 1 anak, otomatis pilih anak tersebut
        if ($childrenCount === 1) {
            $selectedChildId = $childrenConnections->first()->student_id;
            session(['selected_child_id' => $selectedChildId]);
        }

        // Jika punya > 1 anak tapi belum pilih, redirect ke halaman pemilihan (KECUALI jika paksa lewat query param)
        if ($childrenCount > 1 && !$selectedChildId) {
            return view('parent.select-child', compact('childrenConnections'));
        }

        // Jika ada pilihan di query param (tombol ganti anak), tampilkan halaman pemilihan
        if ($request->has('switch_child')) {
            return view('parent.select-child', compact('childrenConnections'));
        }

        // Ambil data detail untuk anak yang dipilih
        $child = $childrenConnections->firstWhere('student_id', $selectedChildId);
        
        // Jika ID di session ternyata tidak valid (misal data dihapus), reset session dan tampilkan pemilihan
        if (!$child && $childrenCount > 1) {
            session()->forget('selected_child_id');
            return redirect()->route('parent.dashboard');
        }

        // Fallback jika hanya 1 tapi entah kenapa tidak ketemu
        if (!$child) {
            $child = $childrenConnections->first();
        }

        $student = $child->student;
        $childData = [
            'student' => $student,
            'violations' => Violation::where('student_id', $student->id)
                ->with(['rule', 'student.schoolClass', 'teacher'])
                ->latest('violation_date')
                ->limit(3)
                ->get(),
            'achievements' => \App\Models\Achievement::where('student_id', $student->id)
                ->with(['student.schoolClass', 'teacher'])
                ->latest('achievement_date')
                ->limit(3)
                ->get(),
            'sessions' => CounselingSession::whereHas('schedule', fn($q) => $q->where('student_id', $student->id))
                ->with(['student.schoolClass', 'counselor', 'schedule'])
                ->latest('session_date')
                ->limit(3)
                ->get()
        ];

        return view('parent.dashboard', [
            'data' => [$childData], // Bungkus array agar view forelse tetap jalan tapi isi 1
            'hasMultipleChildren' => $childrenCount > 1
        ]);
    }

    public function selectChild($student_id)
    {
        $pid = \Illuminate\Support\Facades\Auth::id();
        
        // Pastikan anak tersebut memang milik orang tua ini
        $exists = ParentStudent::where('parent_id', $pid)->where('student_id', $student_id)->exists();
        
        if ($exists) {
            session(['selected_child_id' => $student_id]);
        }

        return redirect()->route('parent.dashboard');
    }

    private function getSelectedStudent()
    {
        $pid = \Illuminate\Support\Facades\Auth::id();
        $selectedChildId = session('selected_child_id');

        if (!$selectedChildId) return null;

        $connection = ParentStudent::where('parent_id', $pid)
            ->where('student_id', $selectedChildId)
            ->with('student.schoolClass')
            ->first();

        return $connection ? $connection->student : null;
    }

    public function violations()
    {
        $student = $this->getSelectedStudent();
        if (!$student) return redirect()->route('parent.dashboard');

        $violations = Violation::where('student_id', $student->id)
            ->with(['rule', 'teacher'])
            ->latest('violation_date')
            ->paginate(10);

        return view('parent.violations', compact('student', 'violations'));
    }

    public function achievements()
    {
        $student = $this->getSelectedStudent();
        if (!$student) return redirect()->route('parent.dashboard');

        $achievements = \App\Models\Achievement::where('student_id', $student->id)
            ->with(['teacher'])
            ->latest('achievement_date')
            ->paginate(10);

        return view('parent.achievements', compact('student', 'achievements'));
    }

    public function counseling()
    {
        $student = $this->getSelectedStudent();
        if (!$student) return redirect()->route('parent.dashboard');

        $sessions = CounselingSession::whereHas('schedule', fn($q) => $q->where('student_id', $student->id))
            ->with(['counselor', 'schedule'])
            ->latest('session_date')
            ->paginate(10);

        return view('parent.counseling', compact('student', 'sessions'));
    }
}
