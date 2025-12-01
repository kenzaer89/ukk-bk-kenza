<?php

namespace App\Http\Controllers;

use App\Models\Notification as AppNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationApiController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $unread = AppNotification::where('user_id', $user->id)->where('status', 'unread')->latest()->get();
        $read = AppNotification::where('user_id', $user->id)->where('status', 'read')->latest()->take(10)->get();

        $notifications = $unread->merge($read);

        return response()->json(['notifications' => $notifications]);
    }

    public function unreadCount(Request $request)
    {
        $user = Auth::user();
        $count = AppNotification::where('user_id', $user->id)->where('status', 'unread')->count();
        return response()->json(['count' => $count]);
    }

    public function markAsRead(Request $request)
    {
        $user = Auth::user();
        $request->validate(['id' => 'required|integer']);
        $notification = AppNotification::where('user_id', $user->id)->where('id', $request->input('id'))->first();

        if (!$notification) {
            return response()->json(['success' => false, 'message' => 'Notifikasi tidak ditemukan.'], 404);
        }

        $notification->status = 'read';
        $notification->save();

        return response()->json(['success' => true]);
    }

    public function markAllAsRead(Request $request)
    {
        $user = Auth::user();
        $updated = AppNotification::where('user_id', $user->id)->where('status', 'unread')->update(['status' => 'read']);
        return response()->json(['success' => true, 'updated' => $updated]);
    }

    public function destroy(Request $request)
    {
        $user = Auth::user();
        $request->validate(['id' => 'required|integer']);
        $deleted = AppNotification::where('user_id', $user->id)->where('id', $request->input('id'))->delete();
        return response()->json(['success' => (bool)$deleted]);
    }
}
