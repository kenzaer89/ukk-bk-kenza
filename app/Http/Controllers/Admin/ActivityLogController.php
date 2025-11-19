<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $logs = ActivityLog::with('user')
                           ->orderByDesc('created_at')
                           ->paginate(20);

        return view('admin.activity_logs.index', compact('logs'));
    }
    
    // Mungkin diperlukan method show untuk melihat detail data lama/baru
    public function show(ActivityLog $log)
    {
        return view('admin.activity_logs.show', compact('log'));
    }
}