<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Student\StudentDashboardController;
use App\Http\Controllers\ParentRole\ParentDashboardController;
use App\Http\Controllers\Wali\WaliDashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\CounselingSessionController; // Tambahan Controller Sesi Konseling Admin
use App\Http\Controllers\Student\CounselingRequestController;
use App\Http\Controllers\Admin\NotificationController;
use Illuminate\Support\Facades\Auth;

// =====================================================================
// 🏡 HALAMAN UTAMA (WELCOME)
// Logic: Cek status login, jika sudah, redirect sesuai role. Jika belum, tampilkan welcome view.
// =====================================================================
Route::get('/', function () {
    // Kalau sudah login, langsung ke dashboard sesuai role
    if (Auth::check()) {
        $user = Auth::user();
        switch ($user->role) {
            case 'admin':
            case 'guru_bk': // Guru BK diarahkan ke dashboard Admin
                return redirect()->route('admin.dashboard');
            case 'student':
                return redirect()->route('student.dashboard');
            case 'parent':
                return redirect()->route('parent.dashboard');
            case 'wali_kelas':
                return redirect()->route('wali.dashboard');
        }
    }

    // Kalau belum login, tampilkan halaman welcome
    return view('welcome');
})->name('home');

// ===============================
// 🔐 LOGIN & LOGOUT
// ===============================
Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [LoginController::class, 'login'])
    ->middleware('guest')
    ->name('login.attempt');

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');

// =====================================================================
// 🧭 DASHBOARD DAN FITUR PER ROLE (Membutuhkan user terautentikasi)
// =====================================================================
Route::middleware(['auth'])->group(function () {

    // --- ADMIN & GURU BK ---
    // Akses ke fitur administrasi dan pengelolaan data master
    Route::middleware(['role:admin,guru_bk'])->prefix('admin')->name('admin.')->group(function () {
        
        // DASHBOARD ADMIN & GURU BK (Controller di sini harus memiliki logika role-switching)
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // RESOURCE ROUTES
        Route::resource('users', App\Http\Controllers\Admin\UserController::class);
        Route::resource('schedules', App\Http\Controllers\Admin\ScheduleController::class);
        Route::resource('achievements', App\Http\Controllers\Admin\AchievementController::class);
        Route::resource('classes', App\Http\Controllers\Admin\ClassController::class);
        Route::resource('rules', App\Http\Controllers\Admin\RuleController::class);
        Route::resource('point_levels', App\Http\Controllers\Admin\PointLevelController::class);
        Route::resource('topics', App\Http\Controllers\Admin\TopicController::class);
        
        // PENCATATAN PELANGGARAN
        Route::resource('violations', App\Http\Controllers\Admin\ViolationController::class);
        
        // LAPORAN BULANAN
        Route::resource('monthly_reports', App\Http\Controllers\Admin\MonthlyReportController::class)->names('monthly_reports');
        
        // PENGELOLAAN SESI KONSELING
        Route::resource('counseling_sessions', CounselingSessionController::class)->names('counseling_sessions');
        
        // LOG AKTIVITAS (Activity Log)
        Route::get('activity_logs', [App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('activity_logs.index');
        Route::get('activity_logs/{log}', [App\Http\Controllers\Admin\ActivityLogController::class, 'show'])->name('activity_logs.show');
        
        // Notifikasi (per admin area - legacy routes, mapped to shared controller)
        Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::post('notifications/mark-read', [NotificationController::class, 'markAsRead'])->name('notifications.markRead');
        Route::post('notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllRead');
        Route::delete('notifications/delete', [NotificationController::class, 'destroy'])->name('notifications.destroy');
        Route::get('notifications/count', [NotificationController::class, 'unreadCount'])->name('notifications.unreadCount');
        
        // Check new counseling requests (untuk auto-refresh dashboard)
        Route::get('check-new-requests', [AdminDashboardController::class, 'checkNewRequests'])->name('check_new_requests');
        
        // PERMINTAAN KONSELING (Guru BK)
        Route::resource('counseling_requests', App\Http\Controllers\Admin\CounselingRequestController::class)->only(['index', 'show', 'destroy']);
        Route::post('counseling_requests/{counseling_request}/approve', [App\Http\Controllers\Admin\CounselingRequestController::class, 'approve'])->name('counseling_requests.approve');
        Route::post('counseling_requests/{counseling_request}/reject', [App\Http\Controllers\Admin\CounselingRequestController::class, 'reject'])->name('counseling_requests.reject');
        Route::post('counseling_requests/{counseling_request}/postpone', [App\Http\Controllers\Admin\CounselingRequestController::class, 'postpone'])->name('counseling_requests.postpone');
        
    });


    // --- STUDENT ---
    Route::middleware(['role:student'])->prefix('student')->name('student.')->group(function () {
        Route::get('dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
        Route::get('violations', [StudentDashboardController::class, 'violations'])->name('violations.index');
        Route::get('achievements', [StudentDashboardController::class, 'achievements'])->name('achievements.index');
        
        // PERMINTAAN KONSELING SISWA
        Route::resource('counseling_requests', CounselingRequestController::class)->only(['index', 'create', 'store']);
        Route::post('counseling_requests/{request}/cancel', [CounselingRequestController::class, 'cancel'])->name('counseling_requests.cancel');
    });

    // Shared notification API routes (for AJAX on both admin & student)
    Route::get('notifications/list', [App\Http\Controllers\NotificationApiController::class, 'index'])->name('notifications.list');
    Route::get('notifications/count', [App\Http\Controllers\NotificationApiController::class, 'unreadCount'])->name('notifications.count');
    Route::post('notifications/mark-read', [App\Http\Controllers\NotificationApiController::class, 'markAsRead'])->name('notifications.markread');
    Route::post('notifications/mark-all-read', [App\Http\Controllers\NotificationApiController::class, 'markAllAsRead'])->name('notifications.markallread');
    Route::delete('notifications/delete', [App\Http\Controllers\NotificationApiController::class, 'destroy'])->name('notifications.delete');
    
    // --- PARENT ---
    Route::middleware(['role:parent'])->prefix('parent')->name('parent.')->group(function () {
        Route::get('dashboard', [ParentDashboardController::class, 'index'])->name('dashboard');
    });

    // --- WALI KELAS ---
    Route::middleware(['role:wali_kelas'])->prefix('wali')->name('wali.')->group(function () {
        Route::get('dashboard', [WaliDashboardController::class, 'index'])->name('dashboard');
    });
});

require __DIR__.'/auth.php';