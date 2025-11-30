@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="min-h-screen bg-brand-dark p-6">
    <!-- Header -->
    <div class="mb-8 flex justify-between items-end">
        <div>
            <h1 class="text-3xl font-bold text-brand-light mb-2">
                Halo, {{ Auth::user()->name }} 
                @if(Auth::user()->absen) / {{ Auth::user()->absen }} @endif
                @if(Auth::user()->schoolClass) / {{ Auth::user()->schoolClass->name }} @endif
                👋
            </h1>
            <p class="text-brand-light/60">Selamat datang di dashboard siswa BK System</p>
        </div>
        <div class="bg-brand-gray border border-brand-light/10 px-6 py-3 rounded-xl text-center">
            <p class="text-brand-light/60 text-xs uppercase tracking-wider font-semibold mb-1">Sisa Poin</p>
            <p class="text-3xl font-bold 
                @if(Auth::user()->points <= 50) text-red-500 
                @elseif(Auth::user()->points <= 70) text-yellow-500 
                @else text-green-500 
                @endif">
                {{ Auth::user()->points }}
            </p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Sesi Terjadwal -->
        <div class="bg-brand-gray rounded-xl border border-brand-light/10 p-6 hover:border-brand-teal/50 transition-all">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-brand-teal/10 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-brand-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-brand-light/60 text-sm mb-1">Sesi Terjadwal</p>
            <p class="text-3xl font-bold text-brand-teal">{{ $stats['scheduled_sessions'] }}</p>
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
            <p class="text-3xl font-bold text-yellow-500">{{ $stats['pending_requests'] }}</p>
        </div>

        <!-- Pelanggaran -->
        <a href="{{ route('student.violations.index') }}" class="block bg-brand-gray rounded-xl border border-brand-light/10 p-6 hover:border-brand-teal/50 transition-all group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-red-500/10 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-brand-light/60 text-sm mb-1">Pelanggaran</p>
            <p class="text-3xl font-bold text-red-500">{{ $stats['violations'] }}</p>
        </a>

        <!-- Prestasi -->
        <a href="{{ route('student.achievements.index') }}" class="bg-brand-gray rounded-xl border border-brand-light/10 p-6 hover:border-brand-teal/50 transition-all group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-500/10 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-brand-light/60 text-sm mb-1">Prestasi</p>
            <p class="text-3xl font-bold text-green-500">{{ $stats['achievements'] }}</p>
        </a>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <a href="{{ route('student.counseling_requests.create') }}" class="group bg-gradient-to-r from-brand-teal to-[#5a8e91] rounded-xl p-6 hover:shadow-[0_0_30px_rgba(118,171,174,0.3)] transition-all transform hover:-translate-y-1">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-white/10 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-white font-bold text-lg">Ajukan Konseling</h3>
                    <p class="text-white/80 text-sm">Buat permintaan konseling baru</p>
                </div>
            </div>
        </a>

        <a href="{{ route('student.counseling_requests.index') }}" class="group bg-brand-gray border border-brand-light/10 rounded-xl p-6 hover:border-brand-teal/50 hover:shadow-[0_0_20px_rgba(118,171,174,0.15)] transition-all transform hover:-translate-y-1">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-brand-teal/10 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-brand-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-brand-light font-bold text-lg">Lihat Permintaan</h3>
                    <p class="text-brand-light/60 text-sm">Riwayat permintaan konseling</p>
                </div>
            </div>
        </a>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Jadwal Konseling Mendatang -->
        <div class="bg-brand-gray rounded-xl border border-brand-light/10 p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 bg-brand-teal/10 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-brand-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-brand-light">Jadwal Mendatang</h3>
            </div>

            @if($upcomingSessions->count() > 0)
                <div class="space-y-3">
                    @foreach($upcomingSessions as $session)
                    <div class="bg-brand-dark/50 border border-brand-light/5 rounded-lg p-4 hover:border-brand-teal/30 transition-all">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <p class="font-semibold text-brand-light">{{ $session->scheduled_date->format('d M Y') }}</p>
                                <p class="text-sm text-brand-light/60">{{ $session->start_time }} - {{ $session->end_time }}</p>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-brand-teal/20 text-brand-teal">
                                {{ ucfirst($session->status) }}
                            </span>
                        </div>
                        @if($session->teacher)
                        <p class="text-sm text-brand-light/70">Dengan: {{ $session->teacher->name }}</p>
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

        <!-- Riwayat Konseling -->
        <div class="bg-brand-gray rounded-xl border border-brand-light/10 p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 bg-green-500/10 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-brand-light">Riwayat Konseling</h3>
            </div>

            @if($recentSessions->count() > 0)
                <div class="space-y-3">
                    @foreach($recentSessions as $session)
                    <div class="bg-brand-dark/50 border border-brand-light/5 rounded-lg p-4 hover:border-brand-teal/30 transition-all">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <p class="font-semibold text-brand-light">{{ $session->scheduled_date->format('d M Y') }}</p>
                                <p class="text-sm text-brand-light/60">{{ $session->start_time }} - {{ $session->end_time }}</p>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-500/20 text-green-500">
                                Selesai
                            </span>
                        </div>
                        @if($session->teacher)
                        <p class="text-sm text-brand-light/70">Dengan: {{ $session->teacher->name }}</p>
                        @endif
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="w-16 h-16 text-brand-light/20 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-brand-light/40">Belum ada riwayat konseling</p>
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
                <a href="{{ route('student.violations.index') }}" class="text-sm text-brand-teal hover:text-brand-light transition-colors">Lihat Semua</a>
            </div>

            @if($recentViolations->count() > 0)
                <div class="space-y-3">
                    @foreach($recentViolations as $violation)
                    <div class="bg-brand-dark/50 border border-brand-light/5 rounded-lg p-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-brand-light">{{ $violation->rule->name }}</p>
                                <p class="text-sm text-brand-light/60 mt-1">{{ $violation->violation_date->format('d M Y') }}</p>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-500/20 text-red-500">
                                -{{ $violation->rule->points }} poin
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
                    <p class="text-brand-light/40">Tidak ada pelanggaran 🎉</p>
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
                <a href="{{ route('student.achievements.index') }}" class="text-sm text-brand-teal hover:text-brand-teal/80 transition-colors">Lihat Semua</a>
            </div>

            @if($recentAchievements->count() > 0)
                <div class="space-y-3">
                    @foreach($recentAchievements as $achievement)
                    <div class="bg-brand-dark/50 border border-brand-light/5 rounded-lg p-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-brand-light">{{ $achievement->name }}</p>
                                <p class="text-sm text-brand-light/60 mt-1">{{ $achievement->achievement_date ? $achievement->achievement_date->format('d M Y') : '-' }}</p>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-500/20 text-green-500">
                                +{{ $achievement->point }} poin
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
</div>
@endsection