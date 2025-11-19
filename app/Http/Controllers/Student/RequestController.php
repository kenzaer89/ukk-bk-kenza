<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\CounselingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RequestController extends Controller
{
    /**
     * Menampilkan daftar semua Permintaan Konseling milik Siswa yang login. (READ - Index)
     */
    public function index()
    {
        $studentId = Auth::id();

        $requests = CounselingRequest::where('student_id', $studentId)
                        ->with('teacher') // Load data guru yang menangani (jika ada)
                        ->latest()
                        ->paginate(10);
        
        return view('student.requests.index', compact('requests'));
    }

    /**
     * Menyimpan Permintaan Konseling baru dari dashboard. (CREATE - Store)
     */
    public function store(Request $request)
    {
        // Asumsi form di dashboard menggunakan field 'topic' dan 'description'
        // Kita gabungkan menjadi field 'reason' di database.
        $request->validate([
            'topic' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $reason = "Topik: " . $request->topic;
        if ($request->description) {
            $reason .= "\nDeskripsi: " . $request->description;
        }

        CounselingRequest::create([
            'student_id' => Auth::id(), // ID Siswa yang sedang login
            'reason' => $reason, 
            'status' => 'pending',
            'requested_at' => Carbon::now(),
            // teacher_id dibiarkan null, akan diisi oleh Guru BK
        ]);

        return redirect()->route('student.requests.index')
                         ->with('success', 'Permintaan konseling berhasil diajukan! Menunggu persetujuan Guru BK.');
    }

    /**
     * Menampilkan detail Permintaan Konseling. (READ - Show)
     */
    public function show(CounselingRequest $request)
    {
        // Pastikan siswa hanya bisa melihat permintaan mereka sendiri
        if ($request->student_id !== Auth::id()) {
            abort(403);
        }
        
        $request->load('teacher', 'schedule'); // Load relasi

        return view('student.requests.show', compact('request'));
    }

    // Metode 'create', 'edit', 'update', 'destroy' biasanya tidak diperlukan 
    // untuk Siswa dalam konteks requests, kecuali Anda mengizinkan pembatalan.
    public function destroy(CounselingRequest $request)
    {
        // Hanya izinkan menghapus jika status masih pending
        if ($request->student_id !== Auth::id() || $request->status !== 'pending') {
            return redirect()->route('student.requests.index')->with('error', 'Permintaan ini tidak dapat dibatalkan.');
        }

        $request->delete();
        return redirect()->route('student.requests.index')->with('success', 'Permintaan konseling berhasil dibatalkan.');
    }
    
    // Metode lainnya (create, edit, update) bisa diabaikan atau dikosongkan.
    public function create() { abort(404); }
    public function edit(CounselingRequest $request) { abort(404); }
    public function update(Request $request, CounselingRequest $counselingRequest) { abort(404); }
}