@extends('layouts.app')

@section('title', 'Dashboard Wali Kelas')

@section('content')
<div class="p-6">
    @if (!Auth::user()->is_approved)
        <div class="bg-brand-gray border border-yellow-500/30 rounded-2xl p-12 text-center my-12 shadow-[0_0_50px_rgba(234,179,8,0.1)]">
            <div class="w-24 h-24 bg-yellow-500/20 rounded-full flex items-center justify-center mx-auto mb-6 text-yellow-500 text-5xl animate-pulse">
                ⚠️
            </div>
            <h2 class="text-3xl font-bold text-white mb-4">Akun Belum Aktif</h2>
            <p class="text-brand-light/60 max-w-lg mx-auto text-lg leading-relaxed">
                Pendaftaran Anda sebagai Wali Kelas sedang menunggu verifikasi oleh Admin atau Guru BK. 
                Silakan hubungi Administrator sekolah untuk mengaktifkan akun Anda.
            </p>
            <div class="mt-8">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-brand-teal hover:text-brand-teal/80 font-semibold transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    @elseif (!$class)
        <div class="bg-brand-gray border border-indigo-500/30 rounded-2xl p-12 text-center my-12 shadow-[0_0_50px_rgba(99,102,241,0.1)]">
            <div class="w-24 h-24 bg-indigo-500/20 rounded-full flex items-center justify-center mx-auto mb-6 text-indigo-400 text-5xl">
                🏫
            </div>
            <h2 class="text-3xl font-bold text-white mb-4">Kelas Belum Ditugaskan</h2>
            <p class="text-brand-light/60 max-w-lg mx-auto text-lg leading-relaxed">
                Anda sudah aktif, namun Anda belum ditugaskan sebagai Wali Kelas untuk kelas manapun. 
                Silakan hubungi Administrator untuk penugasan kelas Anda.
            </p>
            <div class="mt-8">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-brand-teal hover:text-brand-teal/80 font-semibold transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    @else
        <!-- Header -->
        <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <span class="text-indigo-400 font-semibold uppercase tracking-widest text-xs">Overview Wali Kelas</span>
                <h1 class="text-3xl font-bold text-white mt-1 flex items-center gap-3">
                    <span class="p-2 bg-indigo-500/20 rounded-lg">
                        <svg class="w-8 h-8 text-brand-teal" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </span>
                    {{ $class->name }} <span class="text-gray-500 font-medium">| Monitoring Dashboard</span>
                </h1>
                <p class="text-gray-400 mt-2 flex items-center gap-2 text-sm">
                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                    Sistem Akademik & Kedisiplinan Siswa
                </p>
            </div>
            <div class="bg-gray-800/40 backdrop-blur-md border border-gray-700/50 p-4 rounded-2xl flex items-center gap-4 shadow-xl">
                <div class="w-12 h-12 bg-indigo-500/20 rounded-xl flex items-center justify-center text-indigo-400 border border-indigo-500/30">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] uppercase font-bold text-gray-500 tracking-wider">Jurusan</p>
                    <p class="text-white font-bold">{{ $class->jurusan ?? 'Umum' }}</p>
                </div>
            </div>
        </div>

        <!-- Progress Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Siswa -->
            <div class="group bg-gray-800/50 backdrop-blur-xl border border-gray-700/50 p-6 rounded-3xl shadow-lg transition-all duration-300 hover:border-indigo-500/50 hover:shadow-indigo-500/10">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-indigo-500/20 rounded-2xl text-indigo-400 group-hover:bg-indigo-500 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                    <span class="text-xs font-bold text-gray-500 uppercase">Total Siswa</span>
                </div>
                <div class="flex items-end justify-between">
                    <h3 class="text-2xl font-bold text-white">{{ $stats['total_students'] }}</h3>
                    <div class="text-[10px] font-bold text-indigo-400">AKTIF</div>
                </div>
            </div>

            <!-- Total Pelanggaran -->
            <div class="group bg-gray-800/50 backdrop-blur-xl border border-gray-700/50 p-6 rounded-3xl shadow-lg transition-all duration-300 hover:border-rose-500/50 hover:shadow-rose-500/10">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-rose-500/20 rounded-2xl text-rose-400 group-hover:bg-rose-500 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <span class="text-xs font-bold text-gray-500 uppercase">Pelanggaran</span>
                </div>
                <div class="flex items-end justify-between">
                    <h3 class="text-2xl font-bold text-white">{{ $stats['total_violations'] }}</h3>
                    <span class="px-2 py-0.5 bg-rose-500/20 text-rose-400 rounded text-[9px] font-bold">WARNING</span>
                </div>
            </div>

            <!-- Total Prestasi -->
            <div class="group bg-gray-800/50 backdrop-blur-xl border border-gray-700/50 p-6 rounded-3xl shadow-lg transition-all duration-300 hover:border-emerald-500/50 hover:shadow-emerald-500/10">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-emerald-500/20 rounded-2xl text-emerald-400 group-hover:bg-emerald-500 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                    </div>
                    <span class="text-xs font-bold text-gray-500 uppercase">Prestasi</span>
                </div>
                <div class="flex items-end justify-between">
                    <h3 class="text-2xl font-bold text-white">{{ $stats['total_achievements'] }}</h3>
                    <span class="px-2 py-0.5 bg-emerald-500/20 text-emerald-400 rounded text-[9px] font-bold">EXCELLENCE</span>
                </div>
            </div>

            <!-- Sesi Konseling -->
            <div class="group bg-gray-800/50 backdrop-blur-xl border border-gray-700/50 p-6 rounded-3xl shadow-lg transition-all duration-300 hover:border-sky-500/50 hover:shadow-sky-500/10">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-sky-500/20 rounded-2xl text-sky-400 group-hover:bg-sky-500 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/></svg>
                    </div>
                    <span class="text-xs font-bold text-gray-500 uppercase">Konseling</span>
                </div>
                <div class="flex items-end justify-between">
                    <h3 class="text-2xl font-bold text-white">{{ $stats['total_sessions'] }}</h3>
                    <span class="px-2 py-0.5 bg-sky-500/20 text-sky-400 rounded text-[9px] font-bold">SESSIONS</span>
                </div>
            </div>
        </div>

        <!-- Activities Grid - Horizontal Alignment -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Recent Violations -->
            <div class="bg-gray-800/50 backdrop-blur-xl border border-gray-700/50 rounded-3xl shadow-2xl p-6 h-full flex flex-col">
                <h3 class="text-lg font-bold text-white mb-6 flex items-center gap-2">
                    <span class="w-1 h-6 bg-rose-500 rounded-full"></span>
                    Pelanggaran Terbaru
                </h3>
                <div class="space-y-3 flex-1">
                    @forelse ($recentViolations as $v)
                        <div class="p-4 bg-gray-900/40 rounded-2xl border border-gray-700/50 hover:border-rose-500/30 transition-all group">
                            <div class="flex justify-between items-start mb-2">
                                <span class="text-xs font-bold text-rose-400">{{ $v->rule->name ?? 'Pelanggaran' }}</span>
                                <span class="text-[10px] text-gray-600 font-mono bg-black/20 px-2 py-0.5 rounded italic font-bold tracking-tight">{{ $v->violation_date->format('d M') }}</span>
                            </div>
                            <p class="text-white font-bold text-sm leading-snug">{{ $v->student->name }}</p>
                            <p class="text-[10px] text-gray-500 mt-1 line-clamp-1 italic group-hover:text-gray-400 transition-colors">{{ $v->description }}</p>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center h-full py-12">
                            <p class="text-center text-gray-600 text-sm italic font-bold">Alhamdulillah, nihil pelanggaran.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Achievements -->
            <div class="bg-gray-800/50 backdrop-blur-xl border border-gray-700/50 rounded-3xl shadow-2xl p-6 h-full flex flex-col">
                <h3 class="text-lg font-bold text-white mb-6 flex items-center gap-2">
                    <span class="w-1 h-6 bg-emerald-500 rounded-full"></span>
                    Prestasi Terbaru
                </h3>
                <div class="space-y-3 flex-1">
                    @forelse ($recentAchievements as $a)
                        <div class="p-4 bg-gray-900/40 rounded-2xl border border-gray-700/50 hover:border-emerald-500/30 transition-all group">
                            <div class="flex justify-between items-start mb-2">
                                <span class="text-xs font-bold text-emerald-400">{{ $a->point }} Poin</span>
                                <span class="text-[10px] text-gray-600 font-mono bg-black/20 px-2 py-0.5 rounded italic font-bold tracking-tight">{{ $a->achievement_date->format('d M') }}</span>
                            </div>
                            <p class="text-white font-bold text-sm leading-snug">{{ $a->student->name }}</p>
                            <p class="text-[10px] text-gray-500 mt-1 line-clamp-1 italic group-hover:text-gray-400 transition-colors">{{ $a->name }}</p>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center h-full py-12">
                            <p class="text-center text-gray-600 text-sm italic font-bold">Belum ada prestasi tercatat.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Counseling History -->
            <div class="bg-gray-800/50 backdrop-blur-xl border border-gray-700/50 rounded-3xl shadow-2xl p-6 h-full flex flex-col">
                <h3 class="text-lg font-bold text-white mb-6 flex items-center gap-2">
                    <span class="w-1 h-6 bg-sky-500 rounded-full"></span>
                    Riwayat Konseling Selesai
                </h3>
                <div class="space-y-4 flex-1">
                    @forelse ($recentSessions as $s)
                        <div class="p-4 bg-gray-900/40 rounded-2xl border border-gray-700/30 hover:border-sky-500/30 transition-all group">
                            <div class="flex justify-between items-start mb-2">
                                <span class="text-[10px] font-black text-sky-400 uppercase tracking-widest">{{ $s->session_type }}</span>
                                <span class="text-[10px] text-gray-600 font-mono italic font-bold tracking-tight">{{ $s->session_date->format('d M') }}</span>
                            </div>
                            <p class="text-white font-bold text-sm leading-tight">{{ $s->student->name }}</p>
                            <p class="text-[10px] text-gray-500 mt-1 line-clamp-1 italic">Bersama: {{ $s->counselor_name ?? ($s->counselor->name ?? 'Admin') }}</p>
                            <div class="mt-2 p-2 bg-black/20 rounded-lg text-[10px] text-gray-400 italic line-clamp-2">
                                "{{ $s->notes }}"
                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center h-full py-12">
                            <p class="text-gray-600 text-sm font-bold italic">Belum ada riwayat konseling.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
