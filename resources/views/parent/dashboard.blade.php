@extends('layouts.app')

@section('title', 'Dashboard Orang Tua')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white">Dashboard Orang Tua</h1>
        <p class="text-gray-400 mt-2">Pantau perkembangan dan aktivitas anak Anda di sekolah.</p>
    </div>

    @forelse($data as $childData)
        @php $student = $childData['student']; @endphp
        
        <!-- Student Info Card -->
        <div class="bg-brand-gray border border-brand-light/10 rounded-xl p-6 mb-6">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-brand-teal to-cyan-600 flex items-center justify-center text-white font-bold text-2xl shadow-lg">
                    {{ substr($student->name, 0, 1) }}
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-white">{{ $student->name }}</h2>
                    <p class="text-brand-light/60">{{ $student->email }}</p>
                    @if($student->schoolClass)
                        <p class="text-sm text-brand-teal mt-1">{{ $student->schoolClass->name }}</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
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
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-white/10">
                    <div class="w-10 h-10 rounded-lg bg-red-500/10 flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white">Pelanggaran Terbaru</h3>
                </div>
                
                @if($childData['violations']->count() > 0)
                    <div class="space-y-3">
                        @foreach($childData['violations'] as $violation)
                            <div class="bg-white/5 hover:bg-white/10 p-4 rounded-lg border border-white/10 transition-all duration-200">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex-1">
                                        <p class="text-white font-semibold text-lg">{{ $violation->rule->name ?? 'Pelanggaran' }}</p>
                                        <p class="text-brand-light/60 text-sm mt-1">{{ \Carbon\Carbon::parse($violation->violation_date)->format('d M Y') }}</p>
                                    </div>
                                    <span class="px-3 py-1 bg-red-500/20 text-red-400 text-xs font-semibold rounded-full">
                                        Pelanggaran
                                    </span>
                                </div>
                                
                                <!-- Detail Information -->
                                <div class="mt-3 pt-3 border-t border-white/10 space-y-2">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-brand-light/40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        <span class="text-brand-light/60 text-sm">{{ $violation->student->name ?? '-' }}</span>
                                    </div>
                                    
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-brand-light/40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                        <span class="text-brand-light/60 text-sm">
                                            Kelas: {{ $violation->student->schoolClass->name ?? '-' }} 
                                            @if($violation->student->absen)
                                                • Absen: {{ $violation->student->absen }}
                                            @endif
                                        </span>
                                    </div>
                                    
                                    @if($violation->description)
                                        <div class="flex items-start gap-2 mt-2">
                                            <svg class="w-4 h-4 text-brand-light/40 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            <div class="flex-1">
                                                <p class="text-brand-light/40 text-xs mb-1">Catatan Guru BK:</p>
                                                <p class="text-brand-light/60 text-sm">{{ $violation->description }}</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="w-16 h-16 text-brand-light/20 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-brand-light/40 text-sm">Tidak ada pelanggaran</p>
                    </div>
                @endif
            </div>

            <!-- Prestasi Terbaru -->
            <div class="bg-brand-gray border border-brand-light/10 rounded-xl p-6">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-white/10">
                    <div class="w-10 h-10 rounded-lg bg-yellow-500/10 flex items-center justify-center">
                        <svg class="w-5 h-5 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white">Prestasi Terbaru</h3>
                </div>
                
                @if($childData['achievements']->count() > 0)
                    <div class="space-y-3">
                        @foreach($childData['achievements'] as $achievement)
                            <div class="bg-white/5 hover:bg-white/10 p-4 rounded-lg border border-white/10 transition-all duration-200">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex-1">
                                        <p class="text-white font-semibold text-lg">{{ $achievement->name }}</p>
                                        <p class="text-brand-teal text-sm mt-1 font-medium">{{ $achievement->level }}</p>
                                        <p class="text-brand-light/60 text-xs mt-1">{{ \Carbon\Carbon::parse($achievement->achievement_date)->format('d M Y') }}</p>
                                    </div>
                                    <span class="px-3 py-1 bg-yellow-500/20 text-yellow-500 text-xs font-semibold rounded-full">
                                        @if($achievement->point)
                                            +{{ $achievement->point }} poin
                                        @else
                                            Prestasi
                                        @endif
                                    </span>
                                </div>
                                
                                <!-- Detail Information -->
                                <div class="mt-3 pt-3 border-t border-white/10 space-y-2">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-brand-light/40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        <span class="text-brand-light/60 text-sm">{{ $achievement->student->name ?? '-' }}</span>
                                    </div>
                                    
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-brand-light/40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                        <span class="text-brand-light/60 text-sm">
                                            Kelas: {{ $achievement->student->schoolClass->name ?? '-' }} 
                                            @if($achievement->student->absen)
                                                • Absen: {{ $achievement->student->absen }}
                                            @endif
                                        </span>
                                    </div>
                                    
                                    @if($achievement->description)
                                        <div class="flex items-start gap-2 mt-2">
                                            <svg class="w-4 h-4 text-brand-light/40 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            <div class="flex-1">
                                                <p class="text-brand-light/40 text-xs mb-1">Deskripsi:</p>
                                                <p class="text-brand-light/60 text-sm">{{ $achievement->description }}</p>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    @if($achievement->notes)
                                        <div class="flex items-start gap-2 mt-2">
                                            <svg class="w-4 h-4 text-brand-light/40 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            <div class="flex-1">
                                                <p class="text-brand-light/40 text-xs mb-1">Catatan Guru BK:</p>
                                                <p class="text-brand-light/60 text-sm">{{ $achievement->notes }}</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="w-16 h-16 text-brand-light/20 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                        <p class="text-brand-light/40 text-sm">Belum ada prestasi</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Riwayat Konseling -->
        <div class="bg-brand-gray border border-brand-light/10 rounded-xl p-6 mt-6">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-white/10">
                <div class="w-10 h-10 rounded-lg bg-blue-500/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-white">Riwayat Konseling</h3>
            </div>
            
            @if($childData['sessions']->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($childData['sessions'] as $session)
                        <div class="bg-white/5 hover:bg-white/10 p-4 rounded-lg border border-white/10 transition-all duration-200">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex-1">
                                    <p class="text-white font-semibold text-lg">{{ $session->session_type ?? 'Konseling' }}</p>
                                    <p class="text-brand-light/60 text-sm mt-1">{{ \Carbon\Carbon::parse($session->session_date)->format('d M Y') }}</p>
                                </div>
                                <span class="px-3 py-1 bg-blue-500/20 text-blue-400 text-xs font-semibold rounded-full">
                                    {{ ucfirst($session->status) }}
                                </span>
                            </div>
                            
                            <!-- Detail Information -->
                            <div class="mt-3 pt-3 border-t border-white/10 space-y-2">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-brand-light/40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <span class="text-brand-light/60 text-sm">{{ $session->student->name ?? '-' }}</span>
                                </div>
                                
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-brand-light/40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                    <span class="text-brand-light/60 text-sm">
                                        Kelas: {{ $session->student->schoolClass->name ?? '-' }} 
                                        @if($session->student->absen)
                                            • Absen: {{ $session->student->absen }}
                                        @endif
                                    </span>
                                </div>
                                
                                @if($session->counselor)
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-brand-light/40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                        <span class="text-brand-light/60 text-sm">Guru BK: {{ $session->counselor->name }}</span>
                                    </div>
                                @endif
                                
                                @if($session->start_time && $session->end_time)
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-brand-light/40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="text-brand-light/60 text-sm">{{ $session->start_time }} - {{ $session->end_time }}</span>
                                    </div>
                                @endif
                                
                                @if($session->location)
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-brand-light/40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        <span class="text-brand-light/60 text-sm">{{ $session->location }}</span>
                                    </div>
                                @endif
                                
                                @if($session->notes)
                                    <div class="flex items-start gap-2 mt-2">
                                        <svg class="w-4 h-4 text-brand-light/40 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <div class="flex-1">
                                            <p class="text-brand-light/40 text-xs mb-1">Catatan:</p>
                                            <p class="text-brand-light/60 text-sm">{{ $session->notes }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
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
@endsection
