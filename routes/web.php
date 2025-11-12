<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Student\StudentDashboardController;
use App\Http\Controllers\ParentRole\ParentDashboardController;
use App\Http\Controllers\Wali\WaliDashboardController;
use App\Http\Controllers\Auth\LoginController;


//Halaman Utama (Welcome)

Route::get('/', function () {
    // Kalau sudah login, langsung ke dashboard sesuai role
    if (auth()->check()) {
        $user = auth()->user();
        switch ($user->role) {
            case 'admin':
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

// ===============================
// 🧭 DASHBOARD PER ROLE
// ===============================
Route::middleware(['auth'])->group(function () {

    // --- ADMIN ---
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('users', App\Http\Controllers\Admin\UserController::class);
        Route::resource('schedules', App\Http\Controllers\Admin\ScheduleController::class);
        Route::resource('sessions', App\Http\Controllers\Admin\SessionController::class);
        Route::resource('violations', App\Http\Controllers\Admin\ViolationController::class);
        Route::resource('reports', App\Http\Controllers\Admin\ReportController::class);
    });

    // --- STUDENT ---
    Route::middleware(['role:student'])->prefix('student')->name('student.')->group(function () {
        Route::get('dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
        Route::resource('requests', App\Http\Controllers\Student\RequestController::class);
    });
    
    // --- PARENT ---
    Route::middleware(['role:parent'])->prefix('parent')->name('parent.')->group(function () {
        Route::get('dashboard', [ParentDashboardController::class, 'index'])->name('dashboard');
    });

    // --- WALI KELAS ---
    Route::middleware(['role:wali_kelas'])->prefix('wali')->name('wali.')->group(function () {
        Route::get('dashboard', [WaliDashboardController::class, 'index'])->name('dashboard');
    });
});
