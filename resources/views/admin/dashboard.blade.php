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
        <a href="{{ route('admin.counseling_requests.index') }}" class="group bg-gradient-to-r from-teal-500 to-teal-600 rounded-xl p-6 hover:shadow-[0_0_30px_rgba(45,212,191,0.3)] transition-all transform hover:-translate-y-1">
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

        <a href="{{ route('admin.schedules.index') }}" class="group bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-xl p-6 hover:shadow-[0_0_30px_rgba(99,102,241,0.3)] transition-all transform hover:-translate-y-1">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-white/10 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-white font-bold text-lg">Jadwal Konseling</h3>
                    <p class="text-white/80 text-sm">Atur jadwal sesi</p>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.violations.index') }}" class="group bg-gradient-to-r from-red-500 to-red-600 rounded-xl p-6 hover:shadow-[0_0_30px_rgba(239,68,68,0.3)] transition-all transform hover:-translate-y-1">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-white/10 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-white font-bold text-lg">Pelanggaran</h3>
                    <p class="text-white/80 text-sm">Catat pelanggaran siswa</p>
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
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.counseling_requests.index', ['status' => 'pending']) }}" class="text-sm text-brand-teal hover:text-brand-teal/80 transition-colors">Lihat Semua</a>
                    <span id="requests-badge" class="px-3 py-1 rounded-full text-xs font-bold bg-yellow-500/20 text-yellow-500">
                        {{ $recentRequests->count() }}
                    </span>
                </div>
            </div>

            @if($recentRequests->count() > 0)
                <div id="requests-container" class="space-y-3">
                    @foreach($recentRequests as $request)
                    <div class="bg-brand-dark/50 border border-brand-light/5 rounded-lg p-4 hover:border-yellow-500/30 transition-all">
                        <div class="flex flex-col gap-2">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-medium text-brand-light">{{ $request->student->name }}</p>
                                    <p class="text-[10px] text-brand-light/40 uppercase tracking-tight">{{ $request->student->email }}</p>
                                </div>
                                <span class="text-[10px] text-brand-light/40">{{ $request->requested_at->diffForHumans() }}</span>
                            </div>
                            <div class="text-sm text-brand-light/60">
                                @if(str_starts_with($request->reason, '[Topik:'))
                                    @php
                                        preg_match('/^\[Topik:\s*(.*?)\]/s', $request->reason, $matches);
                                        $topicName = $matches[1] ?? 'Custom';
                                        $actualReason = trim(preg_replace('/^\[Topik:.*?\]/s', '', $request->reason));
                                    @endphp
                                    <span class="inline-block px-2 py-0.5 bg-brand-teal/10 text-brand-teal text-[10px] rounded uppercase font-bold tracking-tight mb-1">
                                        {{ $topicName }}
                                    </span>
                                    <p class="text-xs italic opacity-80">{{ Str::limit($actualReason, 50) }}</p>
                                @else
                                    {{ Str::limit($request->reason, 80) }}
                                @endif
                            </div>
                            <div class="pt-2 border-t border-brand-light/5 mt-1 flex justify-end">
                                <a href="{{ route('admin.counseling_requests.show', $request) }}" class="text-[10px] font-bold text-brand-teal hover:underline uppercase tracking-wider">Lihat Detail →</a>
                            </div>
                        </div>
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
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-brand-teal/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-brand-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-brand-light">Jadwal Mendatang</h3>
                </div>
                <a href="{{ route('admin.schedules.index') }}" class="text-sm text-brand-teal hover:text-brand-teal/80 transition-colors">Lihat Semua</a>
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
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-red-500/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-brand-light">Pelanggaran Terbaru</h3>
                </div>
                <a href="{{ route('admin.violations.index') }}" class="text-sm text-brand-teal hover:text-brand-teal/80 transition-colors">Lihat Semua</a>
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
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-green-500/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-brand-light">Prestasi Terbaru</h3>
                </div>
                <a href="{{ route('admin.achievements.index') }}" class="text-sm text-brand-teal hover:text-brand-teal/80 transition-colors">Lihat Semua</a>
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

@push('scripts') 
<script>
<script>

    // Function to update requests list
    function updateRequestsList(requests) {
        const container = document.getElementById('requests-container');
        const badge = document.getElementById('requests-badge');
        const pendingCard = document.getElementById('pending-count');
        
        if (!container) return;

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
            container.innerHTML = requests.map(request => {
                let reasonHtml = '';
                if (request.reason && request.reason.startsWith('[Topik:')) {
                    const match = request.reason.match(/^\[Topik:\s*(.*?)\]/s);
                    const topicName = match ? match[1] : 'Custom';
                    const actualReason = request.reason.replace(/^\[Topik:.*?\]/s, '').trim();
                    const reasonSnippet = actualReason.length > 50 ? actualReason.substring(0, 50) + '...' : actualReason;
                    
                    reasonHtml = `
                        <span class="inline-block px-2 py-0.5 bg-brand-teal/10 text-brand-teal text-[10px] rounded uppercase font-bold tracking-tight mb-1">
                            ${topicName}
                        </span>
                        <p class="text-xs italic opacity-80">${reasonSnippet}</p>
                    `;
                } else {
                    const reasonSnippet = request.reason ? (request.reason.length > 80 ? request.reason.substring(0, 80) + '...' : request.reason) : '';
                    reasonHtml = reasonSnippet;
                }

                return `
                    <div class="bg-brand-dark/50 border border-brand-light/5 rounded-lg p-4 hover:border-yellow-500/30 transition-all">
                        <div class="flex flex-col gap-2">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-medium text-brand-light">${request.student_name}</p>
                                    <p class="text-[10px] text-brand-light/40 uppercase tracking-tight">${request.student_email || ''}</p>
                                </div>
                                <span class="text-[10px] text-brand-light/40">${request.requested_at}</span>
                            </div>
                            <div class="text-sm text-brand-light/60">
                                ${reasonHtml}
                            </div>
                            <div class="pt-2 border-t border-brand-light/5 mt-1 flex justify-end">
                                <a href="/admin/counseling_requests/${request.id}" class="text-[10px] font-bold text-brand-teal hover:underline uppercase tracking-wider">Lihat Detail →</a>
                            </div>
                        </div>
                    </div>
                `;
            }).join('');
        }
        
        if (badge) badge.textContent = requests.length;
        if (pendingCard) pendingCard.textContent = requests.length;
    }

    // Initialize lastRequestCount for the global poller if it hasn't started yet
    // This prevents a false "New Notification" on the very first poll after loading the dashboard
    if (typeof lastRequestCount !== 'undefined') {
        lastRequestCount = {{ $stats['pending_requests'] ?? 0 }};
    } else {
        window.lastRequestCount = {{ $stats['pending_requests'] ?? 0 }};
    }
</script>
@endpush
@endsection