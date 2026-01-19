@extends('layouts.app')

@section('title', 'Dashboard Orang Tua')

@section('content')
    @if(!Auth::user()->is_approved)
        <div class="bg-brand-gray border border-yellow-500/30 rounded-2xl p-12 text-center my-12 shadow-[0_0_50px_rgba(234,179,8,0.1)]">
            <div class="w-24 h-24 bg-yellow-500/20 rounded-full flex items-center justify-center mx-auto mb-6 text-yellow-500 text-5xl animate-pulse">
                ⚠️
            </div>
            <h2 class="text-3xl font-bold text-white mb-4">Akun Belum Aktif</h2>
            <p class="text-brand-light/60 max-w-lg mx-auto text-lg leading-relaxed">
                Pendaftaran Anda sebagai Orang Tua sedang menunggu verifikasi oleh Guru BK atau Admin. 
                Silakan hubungi bagian Konseling sekolah untuk mengaktifkan akun Anda agar dapat memantau perkembangan anak.
            </p>
            <div class="mt-8">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-brand-teal hover:text-brand-teal/80 font-semibold transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    @else
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-bold text-white flex items-center gap-3">
                <span class="p-2 bg-indigo-500/20 rounded-lg">
                    <svg class="w-8 h-8 text-brand-teal" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </span>
                Dashboard Orang Tua
            </h1>
            <p class="text-gray-400 mt-2">Pantau perkembangan dan aktivitas anak Anda di sekolah.</p>
        </div>

        @if(isset($hasMultipleChildren) && $hasMultipleChildren)
        <a href="{{ route('parent.dashboard', ['switch_child' => 1]) }}" 
           class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand-teal/10 hover:bg-brand-teal/20 text-brand-teal border border-brand-teal/30 rounded-xl font-bold transition-all duration-300 group">
            <svg class="w-5 h-5 group-hover:rotate-180 transition-transform duration-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
            </svg>
            GANTI ANAK
        </a>
        @endif
    </div>

    @forelse($data as $childData)
        @php $student = $childData['student']; @endphp
        
        <!-- Student Info Card -->
        <div class="bg-brand-gray border border-brand-light/10 rounded-xl p-6 mb-6">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-brand-teal to-cyan-600 flex items-center justify-center text-white font-bold text-2xl shadow-lg">
                    {{ substr($student->name, 0, 1) }}
                </div>
                <div class="flex-1">
                    <h2 class="text-2xl font-bold text-white">{{ $student->name }}</h2>
                    <p class="text-brand-light/60">{{ $student->email }}</p>
                    @if($student->schoolClass)
                        <p class="text-sm text-brand-teal mt-1">{{ $student->schoolClass->name }}</p>
                    @endif
                    <div class="flex gap-4 mt-2 text-xs text-brand-light/60">
                        @if($student->nisn)
                            <span>NISN: {{ $student->nisn }}</span>
                        @endif
                        @if($student->phone)
                            <span>📞 {{ $student->phone }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
            <!-- Total Violations -->
            <div class="bg-brand-gray border border-brand-light/10 rounded-xl p-6 hover:shadow-[0_0_30px_rgba(239,68,68,0.2)] transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-lg bg-red-500/10 flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <span class="text-3xl font-bold text-red-400">{{ $childData['violations']->count() }}</span>
                </div>
                <h3 class="text-brand-light/60 text-sm font-medium">Total Pelanggaran</h3>
            </div>

            <!-- Total Achievements -->
            <div class="bg-brand-gray border border-brand-light/10 rounded-xl p-6 hover:shadow-[0_0_30px_rgba(234,179,8,0.2)] transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-lg bg-yellow-500/10 flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                    </div>
                    <span class="text-3xl font-bold text-yellow-500">{{ $childData['achievements']->count() }}</span>
                </div>
                <h3 class="text-brand-light/60 text-sm font-medium">Total Prestasi</h3>
            </div>

            <!-- Sisa Poin -->
            <div class="bg-brand-gray border border-brand-light/10 rounded-xl p-6 hover:shadow-[0_0_30px_rgba(168,85,247,0.2)] transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-lg bg-purple-500/10 flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    </div>
                    <span class="text-3xl font-bold text-purple-400">{{ $student->points }}</span>
                </div>
                <h3 class="text-brand-light/60 text-sm font-medium">Sisa Poin Siswa</h3>
            </div>

            <!-- Total Sessions -->
            <div class="bg-brand-gray border border-brand-light/10 rounded-xl p-6 hover:shadow-[0_0_30px_rgba(59,130,246,0.2)] transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-lg bg-blue-500/10 flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <span class="text-3xl font-bold text-blue-400">{{ $childData['sessions']->count() }}</span>
                </div>
                <h3 class="text-brand-light/60 text-sm font-medium">Riwayat Konseling</h3>
            </div>

            <!-- Status -->
            <div class="bg-brand-gray border border-brand-light/10 rounded-xl p-6 hover:shadow-[0_0_30px_rgba(45,212,191,0.2)] transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-lg bg-brand-teal/10 flex items-center justify-center">
                        <svg class="w-6 h-6 text-brand-teal" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <h3 class="text-brand-light/60 text-sm font-medium">Status Siswa</h3>
                <p class="text-brand-teal font-semibold mt-1">Aktif</p>
            </div>
        </div>

        <!-- Recent Activities Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Pelanggaran Terbaru -->
            <div class="bg-brand-gray border border-brand-light/10 rounded-xl p-6">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-red-500/10 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-brand-light">Pelanggaran Terbaru</h3>
                    </div>
                    <a href="{{ route('parent.violations.index') }}" class="text-sm text-brand-teal hover:text-brand-light transition-colors">Lihat Semua</a>
                </div>

                @if($childData['violations']->count() > 0)
                    <div class="space-y-3">
                        @foreach($childData['violations']->take(5) as $violation)
                        <div class="bg-brand-dark/50 border border-brand-light/5 rounded-lg p-4">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <p class="font-medium text-brand-light">{{ $violation->rule->name ?? 'Pelanggaran' }}</p>
                                    <p class="text-sm text-brand-light/60 mt-1">{{ \Carbon\Carbon::parse($violation->violation_date)->format('d M Y') }}</p>
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
            <div class="bg-brand-gray border border-brand-light/10 rounded-xl p-6">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-500/10 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-brand-light">Prestasi Terbaru</h3>
                    </div>
                    <a href="{{ route('parent.achievements.index') }}" class="text-sm text-brand-teal hover:text-brand-teal/80 transition-colors">Lihat Semua</a>
                </div>

                @if($childData['achievements']->count() > 0)
                    <div class="space-y-3">
                        @foreach($childData['achievements']->take(5) as $achievement)
                        <div class="bg-brand-dark/50 border border-brand-light/5 rounded-lg p-4">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <p class="font-medium text-brand-light">{{ $achievement->name }}</p>
                                    <p class="text-sm text-brand-light/60 mt-1">{{ $achievement->achievement_date ? \Carbon\Carbon::parse($achievement->achievement_date)->format('d M Y') : '-' }}</p>
                                </div>
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-500/20 text-green-500">
                                    +{{ $achievement->point ?? 0 }} poin
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

        <!-- Riwayat Konseling -->
        <div class="bg-brand-gray border border-brand-light/10 rounded-xl p-6 mt-6">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-500/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white">Riwayat Konseling</h3>
                </div>
                <a href="{{ route('parent.counseling.index') }}" class="text-sm text-brand-teal hover:text-brand-teal/80 transition-colors">Lihat Semua</a>
            </div>
            
            @if($childData['sessions']->count() > 0)
                <div class="space-y-3">
                    @foreach($childData['sessions']->take(5) as $session)
                    <div class="bg-brand-dark/50 border border-brand-light/5 rounded-lg p-4 hover:border-brand-teal/30 transition-all">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <p class="font-semibold text-brand-light">{{ $session->session_date ? \Carbon\Carbon::parse($session->session_date)->format('d M Y') : '-' }}</p>
                                <p class="text-sm text-brand-light/60">{{ $session->start_time ?? '-' }} - {{ $session->end_time ?? '-' }}</p>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-500/20 text-green-500">
                                {{ ucfirst($session->status) }}
                            </span>
                        </div>
                        @php
                            $counselorName = $session->counselor->name ?? 'Admin';
                        @endphp
                        <p class="text-sm text-brand-light/70">Guru BK: {{ $counselorName }}</p>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="w-16 h-16 text-brand-light/20 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-brand-light/40 text-sm">Belum ada sesi konseling</p>
                </div>
            @endif
        </div>

    @empty
        <div class="bg-brand-gray border border-brand-light/10 rounded-xl p-12 text-center">
            <svg class="w-20 h-20 text-brand-light/20 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            <h3 class="text-2xl font-bold text-white mb-2">Belum Ada Data Anak</h3>
            <p class="text-brand-light/60">Anda belum terhubung dengan data siswa manapun.</p>
        </div>
    @endforelse
    @endif
@endsection
