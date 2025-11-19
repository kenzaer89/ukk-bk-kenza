<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; // Tambahkan ini

class AchievementController extends Controller
{
    /**
     * Menyimpan data prestasi baru. (CREATE - Store)
     */
    public function store(Request $request)
    {
        // PERBAIKAN: Gunakan Auth::user() atau $request->user()
        $user = Auth::user(); // atau $user = $request->user();

        $request->validate([
            'student_id' => 'required|exists:users,id,role,student',
            'point' => 'required|integer|min:1',
            'achievement_date' => 'required|date',
            'description' => 'required|string',
        ]);

        try {
            $achievement = Achievement::create([
                'student_id' => $request->student_id,
                'point' => $request->point,
                'achievement_date' => $request->achievement_date,
                'description' => $request->description,
                'teacher_id' => $user->id, // Sekarang aman
            ]);

            return redirect()->route('admin.achievements.index')
                             ->with('success', 'Prestasi siswa berhasil dicatat dan poin telah ditambahkan (+' . $achievement->point . ').');

        } catch (\Exception $e) {
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Gagal mencatat prestasi. Error: ' . $e->getMessage());
        }
    }
}