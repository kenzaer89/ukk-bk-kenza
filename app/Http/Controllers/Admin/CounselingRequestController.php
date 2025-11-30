<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CounselingRequest;
use App\Models\CounselingSchedule;
use App\Models\User;
use Illuminate\Http\Request;

class CounselingRequestController extends Controller
{
    /**
     * Display a listing of counseling requests
     */
    public function index(Request $request)
    {
        $query = CounselingRequest::with(['student']);
        
        // Filter by status if provided
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        
        $requests = $query->latest()->paginate(15);
        
        return view('admin.counseling_requests.index', compact('requests'));
    }

    /**
     * Show the form for viewing a specific request
     */
    public function show(CounselingRequest $counseling_request)
    {
        $counseling_request->load(['student', 'teacher']);
        
        return view('admin.counseling_requests.show', compact('counseling_request'));
    }

    /**
     * Approve a counseling request and create schedule
     */
    public function approve(Request $request, CounselingRequest $counseling_request)
    {
        $request->validate([
            'scheduled_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:500',
        ]);

        // Update request status
        $counseling_request->update([
            'status' => 'approved',
            'teacher_id' => auth()->id(),
        ]);

        // Create schedule
        CounselingSchedule::create([
            'student_id' => $counseling_request->student_id,
            'teacher_id' => auth()->id(),
            'counseling_request_id' => $counseling_request->id,
            'scheduled_date' => $request->scheduled_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'location' => $request->location,
            'notes' => $request->notes,
            'status' => 'scheduled',
        ]);

        return redirect()->route('admin.counseling_requests.index')
            ->with('success', 'Permintaan konseling berhasil disetujui dan jadwal telah dibuat.');
    }

    /**
     * Reject a counseling request
     */
    public function reject(Request $request, CounselingRequest $counseling_request)
    {
        $request->validate([
            'rejection_reason' => 'nullable|string|max:500',
        ]);

        $counseling_request->update([
            'status' => 'rejected',
            'teacher_id' => auth()->id(),
            'notes' => $request->rejection_reason,
        ]);

        return redirect()->route('admin.counseling_requests.index')
            ->with('success', 'Permintaan konseling telah ditolak.');
    }

    /**
     * Postpone a counseling request
     */
    public function postpone(Request $request, CounselingRequest $counseling_request)
    {
        $request->validate([
            'postpone_reason' => 'nullable|string|max:500',
        ]);

        $counseling_request->update([
            'status' => 'pending',
            'teacher_id' => auth()->id(),
            'notes' => $request->postpone_reason,
        ]);

        return redirect()->route('admin.counseling_requests.index')
            ->with('success', 'Permintaan konseling ditunda untuk ditinjau lebih lanjut.');
    }

    /**
     * Delete a counseling request
     */
    public function destroy(CounselingRequest $counseling_request)
    {
        $counseling_request->delete();

        return redirect()->route('admin.counseling_requests.index')
            ->with('success', 'Permintaan konseling berhasil dihapus.');
    }
}
