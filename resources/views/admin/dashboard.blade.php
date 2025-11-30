@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="min-h-screen bg-brand-dark p-6">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-brand-light mb-2">Dashboard Admin</h1>
        <p class="text-brand-light/60">Selamat datang, {{ Auth::user()->name }}</p>
    </div>

    <!-- Statistics Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Siswa -->
        <div class="bg-brand-gray rounded-xl border border-brand-light/10 p-6 hover:border-brand-teal/50 transition-all">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-500/10 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-brand-light/60 text-sm mb-1">Total Siswa</p>
            <p class="text-3xl font-bold text-blue-500">{{ $stats['total_students'] }}</p>
            <p class="text-xs text-brand-light/40 mt-2">+{{ $studentsThisMonth }} bulan ini</p>
        </div>

        <!-- Total Guru -->
        <div class="bg-brand-gray rounded-xl border border-brand-light/10 p-6 hover:border-brand-teal/50 transition-all">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-500/10 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-brand-light/60 text-sm mb-1">Total Guru</p>
            <p class="text-3xl font-bold text-purple-500">{{ $stats['total_teachers'] }}</p>
        </div>

        <!-- Permintaan Pending -->
        <div class="bg-brand-gray rounded-xl border border-brand-light/10 p-6 hover:border-brand-teal/50 transition-all">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-yellow-500/10 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-brand-light/60 text-sm mb-1">Permintaan Pending</p>
            <p id="pending-count" class="text-3xl font-bold text-yellow-500">{{ $stats['pending_requests'] }}</p>
        </div>

        <!-- Total Sesi -->
        <div class="bg-brand-gray rounded-xl border border-brand-light/10 p-6 hover:border-brand-teal/50 transition-all">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-brand-teal/10 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-brand-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-brand-light/60 text-sm mb-1">Total Sesi</p>
            <p class="text-3xl font-bold text-brand-teal">{{ $stats['total_sessions'] }}</p>
            <p class="text-xs text-brand-light/40 mt-2">{{ $sessionsThisMonth }} bulan ini</p>
        </div>

        <!-- Pelanggaran -->
        <div class="bg-brand-gray rounded-xl border border-brand-light/10 p-6 hover:border-brand-teal/50 transition-all">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-red-500/10 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-brand-light/60 text-sm mb-1">Total Pelanggaran</p>
            <p class="text-3xl font-bold text-red-500">{{ $stats['total_violations'] }}</p>
        </div>

        <!-- Prestasi -->
        <div class="bg-brand-gray rounded-xl border border-brand-light/10 p-6 hover:border-brand-teal/50 transition-all">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-500/10 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-brand-light/60 text-sm mb-1">Total Prestasi</p>
            <p class="text-3xl font-bold text-green-500">{{ $stats['total_achievements'] }}</p>
        </div>

        <!-- Jadwal -->
        <div class="bg-brand-gray rounded-xl border border-brand-light/10 p-6 hover:border-brand-teal/50 transition-all">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-indigo-500/10 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
            </div>
            <p class="text-brand-light/60 text-sm mb-1">Total Jadwal</p>
            <p class="text-3xl font-bold text-indigo-500">{{ $stats['total_schedules'] }}</p>
        </div>

        <!-- Kelas -->
        <div class="bg-brand-gray rounded-xl border border-brand-light/10 p-6 hover:border-brand-teal/50 transition-all">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-pink-500/10 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
            </div>
            <p class="text-brand-light/60 text-sm mb-1">Total Kelas</p>
            <p class="text-3xl font-bold text-pink-500">{{ $stats['total_classes'] }}</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <a href="{{ route('admin.counseling_requests.index') }}" class="group bg-gradient-to-r from-brand-teal to-[#5a8e91] rounded-xl p-6 hover:shadow-[0_0_30px_rgba(118,171,174,0.3)] transition-all transform hover:-translate-y-1">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-white/10 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-white font-bold text-lg">Permintaan Konseling</h3>
                    <p class="text-white/80 text-sm">Kelola permintaan siswa</p>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.schedules.index') }}" class="group bg-brand-gray border border-brand-light/10 rounded-xl p-6 hover:border-brand-teal/50 hover:shadow-[0_0_20px_rgba(118,171,174,0.15)] transition-all transform hover:-translate-y-1">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-brand-teal/10 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-brand-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-brand-light font-bold text-lg">Jadwal Konseling</h3>
                    <p class="text-brand-light/60 text-sm">Atur jadwal sesi</p>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.violations.index') }}" class="group bg-brand-gray border border-brand-light/10 rounded-xl p-6 hover:border-brand-teal/50 hover:shadow-[0_0_20px_rgba(118,171,174,0.15)] transition-all transform hover:-translate-y-1">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-red-500/10 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-brand-light font-bold text-lg">Pelanggaran</h3>
                    <p class="text-brand-light/60 text-sm">Catat pelanggaran siswa</p>
                </div>
            </div>
        </a>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Permintaan Konseling Pending -->
        <div class="bg-brand-gray rounded-xl border border-brand-light/10 p-6">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-yellow-500/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-brand-light">Permintaan Pending</h3>
                </div>
                <span id="requests-badge" class="px-3 py-1 rounded-full text-xs font-bold bg-yellow-500/20 text-yellow-500">
                    {{ $recentRequests->count() }}
                </span>
            </div>

            @if($recentRequests->count() > 0)
                <div id="requests-container" class="space-y-3">
                    @foreach($recentRequests as $request)
                    <div class="bg-brand-dark/50 border border-brand-light/5 rounded-lg p-4 hover:border-yellow-500/30 transition-all">
                        <div class="flex justify-between items-start mb-2">
                            <div class="flex-1">
                                <p class="font-medium text-brand-light">{{ $request->student->name }}</p>
                                <p class="text-sm text-brand-light/60 mt-1">{{ Str::limit($request->reason, 60) }}</p>
                            </div>
                        </div>
                        <p class="text-xs text-brand-light/40">{{ $request->requested_at->diffForHumans() }}</p>
                    </div>
                    @endforeach
                </div>
            @else
                <div id="requests-container" class="text-center py-8">
                    <svg class="w-16 h-16 text-brand-light/20 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-brand-light/40">Tidak ada permintaan pending</p>
                </div>
            @endif
        </div>

        <!-- Jadwal Mendatang -->
        <div class="bg-brand-gray rounded-xl border border-brand-light/10 p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 bg-brand-teal/10 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-brand-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-brand-light">Jadwal Mendatang</h3>
            </div>

            @if($upcomingSchedules->count() > 0)
                <div class="space-y-3">
                    @foreach($upcomingSchedules as $schedule)
                    <div class="bg-brand-dark/50 border border-brand-light/5 rounded-lg p-4 hover:border-brand-teal/30 transition-all">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <p class="font-semibold text-brand-light">{{ $schedule->scheduled_date->format('d M Y') }}</p>
                                <p class="text-sm text-brand-light/60">{{ $schedule->start_time }} - {{ $schedule->end_time }}</p>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-brand-teal/20 text-brand-teal">
                                {{ ucfirst($schedule->status) }}
                            </span>
                        </div>
                        <p class="text-sm text-brand-light/70">Siswa: {{ $schedule->student->name }}</p>
                        @if($schedule->teacher)
                        <p class="text-sm text-brand-light/70">Guru: {{ $schedule->teacher->name }}</p>
                        @endif
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="w-16 h-16 text-brand-light/20 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <p class="text-brand-light/40">Tidak ada jadwal mendatang</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Pelanggaran & Prestasi -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Pelanggaran Terbaru -->
        <div class="bg-brand-gray rounded-xl border border-brand-light/10 p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 bg-red-500/10 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-brand-light">Pelanggaran Terbaru</h3>
            </div>

            @if($recentViolations->count() > 0)
                <div class="space-y-3">
                    @foreach($recentViolations as $violation)
                    <div class="bg-brand-dark/50 border border-brand-light/5 rounded-lg p-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-brand-light">{{ $violation->student->name ?? 'N/A' }}</p>
                                <p class="text-sm text-brand-light/60 mt-1">{{ $violation->rule->name ?? 'N/A' }}</p>
                                <p class="text-xs text-brand-light/40 mt-1">{{ $violation->violation_date->format('d M Y') }}</p>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-500/20 text-red-500">
                                -{{ $violation->rule->points ?? 0 }} poin
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="w-16 h-16 text-brand-light/20 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-brand-light/40">Tidak ada pelanggaran</p>
                </div>
            @endif
        </div>

        <!-- Prestasi Terbaru -->
        <div class="bg-brand-gray rounded-xl border border-brand-light/10 p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 bg-green-500/10 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-brand-light">Prestasi Terbaru</h3>
            </div>

            @if($recentAchievements->count() > 0)
                <div class="space-y-3">
                    @foreach($recentAchievements as $achievement)
                    <div class="bg-brand-dark/50 border border-brand-light/5 rounded-lg p-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-brand-light">{{ $achievement->student->name ?? 'N/A' }}</p>
                                <p class="text-sm text-brand-light/60 mt-1">{{ $achievement->achievement_name }}</p>
                                <p class="text-xs text-brand-light/40 mt-1">{{ $achievement->achievement_date->format('d M Y') }}</p>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-500/20 text-green-500">
                                +{{ $achievement->points }} poin
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="w-16 h-16 text-brand-light/20 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                    </svg>
                    <p class="text-brand-light/40">Belum ada prestasi</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast-notification" class="fixed top-4 right-4 z-50 transform translate-x-[400px] transition-transform duration-300">
        <div class="bg-gradient-to-r from-yellow-500 to-orange-500 text-white px-6 py-4 rounded-lg shadow-2xl flex items-center gap-4 min-w-[350px]">
            <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center animate-pulse">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
            </div>
            <div class="flex-1">
                <p class="font-bold text-lg">Permintaan Konseling Baru!</p>
                <p class="text-sm text-white/90" id="toast-message">Ada permintaan konseling baru dari siswa</p>
            </div>
            <button onclick="closeToast()" class="text-white/80 hover:text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let lastRequestCount = {{ $stats['pending_requests'] }};
    let lastCheckTime = new Date();
    let isFirstLoad = true;

    // Function to show toast notification
    function showToast(message) {
        const toast = document.getElementById('toast-notification');
        const toastMessage = document.getElementById('toast-message');
        toastMessage.textContent = message;
        
        // Show toast
        toast.classList.remove('translate-x-[400px]');
        toast.classList.add('translate-x-0');
        
        // Play notification sound
        playNotificationSound();
        
        // Auto hide after 5 seconds
        setTimeout(() => {
            closeToast();
        }, 5000);
    }

    function closeToast() {
        const toast = document.getElementById('toast-notification');
        toast.classList.remove('translate-x-0');
        toast.classList.add('translate-x-[400px]');
    }

    // Function to play notification sound
    function playNotificationSound() {
        // Create audio context for notification sound
        const audioContext = new (window.AudioContext || window.webkitAudioContext)();
        const oscillator = audioContext.createOscillator();
        const gainNode = audioContext.createGain();
        
        oscillator.connect(gainNode);
        gainNode.connect(audioContext.destination);
        
        oscillator.frequency.value = 800;
        oscillator.type = 'sine';
        
        gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
        gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.5);
        
        oscillator.start(audioContext.currentTime);
        oscillator.stop(audioContext.currentTime + 0.5);
    }

    // Function to update requests list
    function updateRequestsList(requests) {
        const container = document.getElementById('requests-container');
        const badge = document.getElementById('requests-badge');
        const pendingCard = document.getElementById('pending-count');
        
        if (requests.length === 0) {
            container.innerHTML = `
                <div class="text-center py-8">
                    <svg class="w-16 h-16 text-brand-light/20 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-brand-light/40">Tidak ada permintaan pending</p>
                </div>
            `;
        } else {
            container.innerHTML = requests.map(request => `
                <div class="bg-brand-dark/50 border border-brand-light/5 rounded-lg p-4 hover:border-yellow-500/30 transition-all animate-fade-in">
                    <div class="flex justify-between items-start mb-2">
                        <div class="flex-1">
                            <p class="font-medium text-brand-light">${request.student_name}</p>
                            <p class="text-sm text-brand-light/60 mt-1">${request.reason.substring(0, 60)}${request.reason.length > 60 ? '...' : ''}</p>
                        </div>
                    </div>
                    <p class="text-xs text-brand-light/40">${request.requested_at}</p>
                </div>
            `).join('');
        }
        
        // Update badge
        badge.textContent = requests.length;
        
        // Update pending count in stats card
        if (pendingCard) {
            pendingCard.textContent = requests.length;
        }
    }

    // Function to check for new requests
    async function checkNewRequests() {
        try {
            const response = await fetch('{{ route('admin.check_new_requests') }}');
            const data = await response.json();
            
            // Check if there are new requests
            if (!isFirstLoad && data.count > lastRequestCount) {
                const newRequestsCount = data.count - lastRequestCount;
                showToast(`${newRequestsCount} permintaan konseling baru dari siswa!`);
                
                // Add pulse animation to pending requests card
                const pendingCard = document.querySelector('.bg-brand-gray.rounded-xl.border.border-brand-light\\/10.p-6.hover\\:border-brand-teal\\/50');
                if (pendingCard) {
                    pendingCard.classList.add('animate-pulse');
                    setTimeout(() => {
                        pendingCard.classList.remove('animate-pulse');
                    }, 2000);
                }
            }
            
            // Update the requests list
            updateRequestsList(data.requests);
            
            // Update last count
            lastRequestCount = data.count;
            lastCheckTime = new Date();
            isFirstLoad = false;
            
        } catch (error) {
            console.error('Error checking new requests:', error);
        }
    }

    // Check for new requests every 10 seconds
    setInterval(checkNewRequests, 10000);

    // Add fade-in animation style
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fade-in {
            animation: fade-in 0.3s ease-out;
        }
    `;
    document.head.appendChild(style);
</script>
@endpush
@endsection