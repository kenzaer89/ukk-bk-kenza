<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\CounselingRequest;
use App\Models\Notification as AppNotification;
use App\Models\User;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CounselingRequestController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status;
        $query = CounselingRequest::where('student_id', Auth::id())
                                ->with(['teacher', 'schedule']);

        if ($status && in_array($status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $status);
        }

        $requests = $query->latest()
                          ->paginate(10);
        
        $counts = [
            'all' => CounselingRequest::where('student_id', Auth::id())->count(),
            'pending' => CounselingRequest::where('student_id', Auth::id())->where('status', 'pending')->count(),
            'approved' => CounselingRequest::where('student_id', Auth::id())->where('status', 'approved')->count(),
            'rejected' => CounselingRequest::where('student_id', Auth::id())->where('status', 'rejected')->count(),
        ];
        
        return view('student.counseling_requests.index', compact('requests', 'counts'));
    }

    public function create()
    {
        $topics = Topic::where('is_custom', false)->orderBy('name')->get();
        return view('student.counseling_requests.create', compact('topics'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'topic_id' => 'required',
            'reason' => 'required|string|max:500',
        ]);

        // If custom topic selected, validate custom topic name
        if ($request->topic_id === 'custom') {
            $request->validate([
                'custom_topic_name' => 'required|string|max:255',
            ]);
            
            // For custom topics, set topic_id to null and prepend topic name to reason
            $topicId = null;
            $reason = "[Topik: {$request->custom_topic_name}]\n\n{$request->reason}";
        } else {
            // Ensure selected topic exists when not custom
            $request->validate([
                'topic_id' => 'exists:topics,id',
            ]);
            $topicId = $request->topic_id;
            $reason = $request->reason;
        }

        $counselingRequest = CounselingRequest::create([
            'student_id' => Auth::id(),
            'topic_id' => $topicId,
            'reason' => $reason,
            'status' => 'pending',
        ]);

        // Notify admins and BK teachers about this new request
        $admins = User::whereIn('role', ['admin', 'guru_bk'])->get();
        foreach ($admins as $admin) {
            AppNotification::create([
                'user_id' => $admin->id,
                'message' => "Permintaan konseling baru dari " . Auth::user()->name,
                'status' => 'unread',
            ]);
        }

        return redirect()->route('student.counseling_requests.index')
                         ->with('success', 'Permintaan konseling berhasil diajukan. Guru BK akan segera menindaklanjuti.');
    }
    
    public function cancel(CounselingRequest $counseling_request)
    {
        if ($counseling_request->student_id != Auth::id() || $counseling_request->status !== 'pending') {
            return redirect()->back()->with('error', 'Anda hanya dapat membatalkan permintaan yang berstatus pending.');
        }

        $counseling_request->update(['status' => 'canceled']);
        
        return redirect()->back()->with('success', 'Permintaan konseling berhasil dibatalkan.');
    }
}