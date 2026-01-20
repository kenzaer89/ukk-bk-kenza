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
    public function index(Request $request)
    {
        $query = Achievement::with(['student.schoolClass', 'teacher']);
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('level', 'like', "%{$search}%")
                  ->orWhereHas('student', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }
        
        $achievements = $query->where('is_visible_to_admin', true)->latest('achievement_date')->paginate(15)->withQueryString();
        
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
            'point' => 'nullable|integer|min:0|max:99',
            'achievement_date' => 'required|date|before_or_equal:today',
            'description' => 'required|string|max:500',
        ]);

        $point = $request->point ?? 0;

        $achievement = Achievement::create([
            'student_id' => $request->student_id,
            'teacher_id' => Auth::id(),
            'name' => $request->name,
            'level' => $request->level,
            'point' => $point,
            'achievement_date' => $request->achievement_date,
            'description' => $request->description,
        ]);

        // Add points to student
        $student = User::find($request->student_id);
        if ($student && $point > 0) {
            $student->increment('points', $point);
        }

        // 3. Notifikasi ke Siswa & Orang Tua
        $notifPointStr = $point > 0 ? " (+" . $point . " poin)" : "";
        $notifMessage = "Selamat! Prestasi baru dicatat: " . $achievement->name . $notifPointStr . ".";
        \App\Models\Notification::create([
            'user_id' => $request->student_id,
            'message' => $notifMessage,
            'status' => 'unread',
        ]);

        if ($student) {
            $parentPointStr = $point > 0 ? ". Penambahan " . $point . " poin." : ".";
            foreach ($student->childrenConnections as $connection) {
                \App\Models\Notification::create([
                    'user_id' => $connection->parent_id,
                    'message' => "🏆 Prestasi Baru (" . $student->name . "): " . $achievement->name . $parentPointStr,
                    'status' => 'unread',
                ]);
            }
        }

        $successMessage = $point > 0 
            ? 'Prestasi siswa berhasil dicatat dan poin telah ditambahkan (+' . $point . ').'
            : 'Prestasi siswa berhasil dicatat tanpa penambahan poin.';

        return redirect()->route('admin.achievements.index')
            ->with('success', $successMessage);
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
            'point' => 'nullable|integer|min:0|max:99',
            'achievement_date' => 'required|date|before_or_equal:today',
            'description' => 'required|string|max:500',
        ]);

        $newPoints = $request->point ?? 0;

        // Calculate point difference
        $oldPoints = $achievement->point;
        $pointDifference = $newPoints - $oldPoints;

        // Update achievement
        $achievement->update([
            'student_id' => $request->student_id,
            'name' => $request->name,
            'level' => $request->level,
            'point' => $newPoints,
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

        // Notifikasi ke Siswa & Orang Tua
        $updatePointStr = $achievement->point > 0 ? " (+" . $achievement->point . " poin)" : "";
        $notifMessage = "Data prestasi Anda diperbarui: " . $achievement->name . $updatePointStr . ".";
        \App\Models\Notification::create([
            'user_id' => $achievement->student_id,
            'message' => $notifMessage,
            'status' => 'unread',
        ]);

        if ($achievement->student) {
            foreach ($achievement->student->childrenConnections as $connection) {
                \App\Models\Notification::create([
                    'user_id' => $connection->parent_id,
                    'message' => "Update Prestasi (" . $achievement->student->name . "): " . $achievement->name . $updatePointStr . ".",
                    'status' => 'unread',
                ]);
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
        // Jangan hapus permanen agar data tetap ada bagi Siswa, Orang Tua, & Wali Kelas
        // Poin TIDAK dikurangi karena prestasi tetap dianggap pernah diraih
        $achievement->update(['is_visible_to_admin' => false]);

        return redirect()->route('admin.achievements.index')
            ->with('success', 'Prestasi telah diarsipkan dari daftar admin (tetap terlihat di sisi siswa/orang tua).');
    }
}