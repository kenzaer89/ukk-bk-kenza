<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification as AppNotification;

class NotificationController extends Controller
{
    /**
     * Menampilkan semua notifikasi yang belum dibaca dan 10 notifikasi terbaru yang sudah dibaca.
     * Metode ini akan dipanggil saat pengguna membuka halaman daftar notifikasi.
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $unreadNotifications = AppNotification::where('user_id', $user->id)->where('status', 'unread')->latest()->get();
        $readNotifications = AppNotification::where('user_id', $user->id)->where('status', 'read')->latest()->take(10)->get();
        $notifications = $unreadNotifications->merge($readNotifications);

        return view('admin.notifications.index', compact('notifications', 'unreadNotifications'));
    }

    /**
     * Menandai satu notifikasi tertentu sebagai sudah dibaca (read) melalui request AJAX.
     */
    public function markAsRead(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'id' => 'required|integer',
        ]);

        $notification = AppNotification::where('user_id', $user->id)->where('id', $request->id)->first();

        if ($notification) {
            $notification->markAsRead();
            return response()->json(['success' => true, 'message' => 'Notifikasi ditandai sudah dibaca.'], 200);
        }

        return response()->json(['success' => false, 'message' => 'Notifikasi tidak ditemukan.'], 404);
    }

    /**
     * Menandai SEMUA notifikasi yang belum dibaca sebagai sudah dibaca (read) melalui request AJAX.
     */
    public function markAllAsRead()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $count = AppNotification::where('user_id', $user->id)->where('status', 'unread')->count();
        AppNotification::where('user_id', $user->id)->where('status', 'unread')->update(['status' => 'read']);

        return response()->json(['success' => true, 'message' => "$count notifikasi berhasil ditandai sudah dibaca."], 200);
    }
    
    /**
     * Menghapus satu notifikasi tertentu.
     */
    public function destroy(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $request->validate(['id' => 'required|integer']);
        $deleted = AppNotification::where('user_id', $user->id)->where('id', $request->id)->delete();

        if ($deleted) {
            return response()->json(['success' => true, 'message' => 'Notifikasi berhasil dihapus.'], 200);
        }

        return response()->json(['success' => false, 'message' => 'Gagal menghapus notifikasi.'], 404);
    }

    /**
     * Mengambil jumlah notifikasi yang belum dibaca (digunakan untuk header/widget bell icon).
     */
    public function unreadCount()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $count = AppNotification::where('user_id', $user->id)->where('status', 'unread')->count();
        return response()->json(['count' => $count]);
    }
}