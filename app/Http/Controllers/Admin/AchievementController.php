<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AchievementController extends Controller
{
    /**
     * Display a listing of achievements
     */
    public function index()
    {
        $achievements = Achievement::with(['student.schoolClass', 'teacher'])
            ->latest('achievement_date')
            ->paginate(15);
        
        return view('admin.achievements.index', compact('achievements'));
    }

    public function create()
    {
        $students = User::where('role', 'student')
            ->with('schoolClass')
            ->orderBy('name')
            ->get();
        
        $levels = ['sekolah', 'kecamatan', 'kabupaten', 'provinsi', 'nasional', 'internasional'];
        
        return view('admin.achievements.create', compact('students', 'levels'));
    }

    /**
     * Store a newly created achievement
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id,role,student',
            'name' => 'required|string|max:255',
            'level' => 'nullable|string|max:100',
            'point' => 'required|integer|min:1',
            'achievement_date' => 'required|date',
            'description' => 'required|string',
        ]);

        $achievement = Achievement::create([
            'student_id' => $request->student_id,
            'teacher_id' => Auth::id(),
            'name' => $request->name,
            'level' => $request->level,
            'point' => $request->point,
            'achievement_date' => $request->achievement_date,
            'description' => $request->description,
        ]);

        // Add points to student
        $student = User::find($request->student_id);
        if ($student) {
            $student->increment('points', $request->point);
        }

        return redirect()->route('admin.achievements.index')
            ->with('success', 'Prestasi siswa berhasil dicatat dan poin telah ditambahkan (+' . $achievement->point . ').');
    }

    public function edit(Achievement $achievement)
    {
        $students = User::where('role', 'student')
            ->with('schoolClass')
            ->orderBy('name')
            ->get();
        
        $levels = ['sekolah', 'kecamatan', 'kabupaten', 'provinsi', 'nasional', 'internasional'];
        
        return view('admin.achievements.edit', compact('achievement', 'students', 'levels'));
    }

    /**
     * Update the specified achievement
     */
    public function update(Request $request, Achievement $achievement)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id,role,student',
            'name' => 'required|string|max:255',
            'level' => 'nullable|string|max:100',
            'point' => 'required|integer|min:1',
            'achievement_date' => 'required|date',
            'description' => 'required|string',
        ]);

        // Calculate point difference
        $oldPoints = $achievement->point;
        $newPoints = $request->point;
        $pointDifference = $newPoints - $oldPoints;

        // Update achievement
        $achievement->update([
            'student_id' => $request->student_id,
            'name' => $request->name,
            'level' => $request->level,
            'point' => $request->point,
            'achievement_date' => $request->achievement_date,
            'description' => $request->description,
        ]);

        // Adjust student points if changed
        if ($pointDifference != 0) {
            $student = User::find($request->student_id);
            if ($student) {
                if ($pointDifference > 0) {
                    $student->increment('points', $pointDifference);
                } else {
                    $student->decrement('points', abs($pointDifference));
                }
            }
        }

        return redirect()->route('admin.achievements.index')
            ->with('success', 'Prestasi siswa berhasil diperbarui.');
    }

    /**
     * Remove the specified achievement
     */
    public function destroy(Achievement $achievement)
    {
        // Restore points to student
        $student = User::find($achievement->student_id);
        if ($student) {
            $student->decrement('points', $achievement->point);
        }

        $achievement->delete();

        return redirect()->route('admin.achievements.index')
            ->with('success', 'Prestasi berhasil dihapus dan poin telah dikurangi.');
    }
}