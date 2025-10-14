<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Student\StudentDashboardController;
use App\Http\Controllers\ParentRole\ParentDashboardController;
use App\Http\Controllers\Wali\WaliDashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// ========== ROUTE DASHBOARD SESUAI ROLE ==========
Route::middleware(['auth.session'])->group(function () {

    // Admin & Guru BK
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('users', App\Http\Controllers\Admin\UserController::class);
        Route::resource('schedules', App\Http\Controllers\Admin\ScheduleController::class);
        Route::resource('sessions', App\Http\Controllers\Admin\SessionController::class);
        Route::resource('violations', App\Http\Controllers\Admin\ViolationController::class);
        Route::resource('reports', App\Http\Controllers\Admin\ReportController::class);
    });

    // Student
    Route::middleware(['role:student'])->prefix('student')->name('student.')->group(function () {
        Route::get('dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
        Route::resource('requests', App\Http\Controllers\Student\RequestController::class);
    });

    // Parent
    Route::middleware(['role:parent'])->prefix('parent')->name('parent.')->group(function () {
        Route::get('dashboard', [ParentDashboardController::class, 'index'])->name('dashboard');
    });

    // Wali Kelas
    Route::middleware(['role:wali_kelas'])->prefix('wali')->name('wali.')->group(function () {
        Route::get('dashboard', [WaliDashboardController::class, 'index'])->name('dashboard');
    });
});

// ========== ROUTE LOGIN & REGISTER ==========
Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Tambahan dummy biar nggak error route not found
Route::get('/password/reset', function () {
    return view('auth.passwords.email');
})->name('password.request');
