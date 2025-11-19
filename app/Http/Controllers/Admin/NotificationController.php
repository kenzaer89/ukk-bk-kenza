<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        // Ambil semua notifikasi yang belum dibaca (unread)
        // Ini adalah relasi yang disediakan oleh trait Notifiable
        $unreadNotifications = $user->unreadNotifications;

        // Ambil 10 notifikasi yang sudah dibaca (read) terbaru
        $readNotifications = $user->readNotifications()->latest()->take(10)->get();

        // Gabungkan keduanya untuk ditampilkan di halaman index
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

        // Validasi ID notifikasi
        $request->validate([
            'id' => 'required|string', // ID notifikasi (UUID)
        ]);

        // Cari notifikasi berdasarkan ID yang dimiliki oleh pengguna yang sedang login
        $notification = $user->notifications()->where('id', $request->id)->first();

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
        
        $count = $user->unreadNotifications->count();
        // Mass action untuk menandai semua notifikasi yang belum dibaca
        $user->unreadNotifications->markAsRead();

        return response()->json(['success' => true, 'message' => "$count notifikasi berhasil ditandai sudah dibaca."], 200);
    }
    
    /**
     * Menghapus satu notifikasi tertentu.
     */
    public function destroy(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Validasi ID notifikasi
        $request->validate([
            'id' => 'required|string', // ID notifikasi (UUID)
        ]);

        // Hapus notifikasi
        $deleted = $user->notifications()->where('id', $request->id)->delete();

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

        $count = $user->unreadNotifications->count();

        return response()->json(['count' => $count]);
    }
}