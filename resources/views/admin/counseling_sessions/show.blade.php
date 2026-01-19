@extends('layouts.app')

@section('title', 'Detail Sesi Konseling')

@section('content')
<div class="p-6 min-h-screen bg-brand-dark">
    <!-- Header -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <a href="{{ route('admin.schedules.index', ['status' => 'completed']) }}" class="inline-flex items-center gap-2 text-brand-teal hover:text-brand-teal/80 mb-4 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Daftar
            </a>
            <h1 class="text-3xl font-bold text-white flex items-center gap-3">
                <span class="p-2 bg-brand-teal/20 rounded-lg">
                    <svg class="w-8 h-8 text-brand-teal" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                </span>
                Detail Sesi Konseling
            </h1>
            <p class="text-gray-400 mt-1">Laporan lengkap hasil sesi konseling yang telah dilaksanakan</p>
        </div>

    </div>

    <!-- Main Content in one single column -->
    <div class="max-w-4xl space-y-8">
        <!-- Student Information Card -->
        <div class="bg-gray-800/50 backdrop-blur-xl rounded-2xl border border-white/5 overflow-hidden shadow-2xl">
            <div class="bg-gradient-to-r from-brand-teal/10 to-transparent px-8 py-8 border-b border-white/5 flex flex-col md:flex-row items-start gap-8">
                <!-- Avatar -->
                <div class="w-28 h-28 bg-brand-teal/20 rounded-full flex items-center justify-center border-2 border-brand-teal/30 shrink-0 shadow-lg relative mt-2">
                    <span class="text-4xl font-bold text-brand-teal">{{ strtoupper(substr($session->student->name, 0, 1)) }}</span>
                    <div class="absolute -bottom-1 -right-1 w-8 h-8 bg-brand-dark rounded-full border border-white/10 flex items-center justify-center">
                        <svg class="w-4 h-4 text-brand-teal" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                </div>
                
                <div class="text-center md:text-left flex-1 mt-2">
                    <h3 class="text-2xl font-bold text-white mb-1">{{ $session->student->name }}</h3>
                    
                    <!-- Quick Info Grid -->
                    <div class="flex flex-wrap justify-center md:justify-start gap-x-8 gap-y-3 mt-4">
                        <div class="flex flex-col">
                            <span class="text-[10px] text-gray-500 font-extrabold uppercase tracking-[0.2em] mb-1">NISN</span>
                            <span class="text-brand-light font-bold text-sm">{{ $session->student->nisn ?? '-' }}</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[10px] text-gray-500 font-extrabold uppercase tracking-[0.2em] mb-1">Kelas</span>
                            <span class="text-brand-teal font-bold text-sm">{{ $session->student->schoolClass->name ?? '-' }}</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[10px] text-gray-500 font-extrabold uppercase tracking-[0.2em] mb-1">No. Absen</span>
                            <span class="text-brand-light font-bold text-sm">{{ $session->student->absen ?? '-' }}</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[10px] text-gray-500 font-extrabold uppercase tracking-[0.2em] mb-1">Nomer Telpon</span>
                            <span class="text-brand-light font-bold text-sm flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                {{ $session->student->phone ?? '-' }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-6 flex flex-col md:flex-row md:items-center gap-4 pt-5 border-t border-white/5">
                        <div class="flex items-center gap-3 bg-brand-teal/10 px-4 py-2 rounded-xl border border-brand-teal/20">
                            <svg class="w-5 h-5 text-brand-teal" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            <span class="text-xs font-bold text-brand-teal uppercase tracking-widest">{{ $session->student->specialization_full_name }}</span>
                        </div>
                        <span class="text-gray-400 text-sm flex items-center gap-2 px-1">
                            <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            {{ $session->student->email }}
                        </span>
                    </div>
                </div>

                <!-- Status Badge -->
                <div class="shrink-0 flex items-center gap-4 px-6 py-4 bg-gray-900/40 rounded-2xl border border-white/5 shadow-inner">
                    @if ($session->status == 'completed')
                        <div class="w-10 h-10 bg-green-500/20 rounded-xl flex items-center justify-center border border-green-500/30">
                            <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-green-500 font-bold text-sm leading-none uppercase tracking-widest">Selesai</p>
                            <p class="text-brand-light/40 text-[10px] mt-1">{{ $session->updated_at->format('d M, H:i') }}</p>
                        </div>
                    @elseif ($session->status == 'cancelled')
                         <div class="w-10 h-10 bg-red-500/20 rounded-xl flex items-center justify-center border border-red-500/30">
                            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-red-500 font-bold text-sm leading-none uppercase tracking-widest">Dibatalkan</p>
                        </div>
                    @else
                        <div class="w-10 h-10 bg-yellow-500/20 rounded-xl flex items-center justify-center border border-yellow-500/30">
                            <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-yellow-500 font-bold text-sm leading-none uppercase tracking-widest">Terjadwal</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Execution Info Grid -->
            <div class="p-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 bg-gray-900/20">
                <div class="space-y-1">
                    <p class="text-gray-400 text-[10px] uppercase font-bold tracking-widest">Tanggal Sesi</p>
                    <p class="text-white font-medium italic">{{ $session->session_date->format('d M Y') }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-gray-400 text-[10px] uppercase font-bold tracking-widest">Waktu</p>
                    <p class="text-white font-medium font-mono text-indigo-400">{{ substr($session->start_time, 0, 5) }} - {{ substr($session->end_time, 0, 5) }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-gray-400 text-[10px] uppercase font-bold tracking-widest">Lokasi</p>
                    <p class="text-white font-medium flex items-center gap-1.5">
                        <span class="text-brand-teal">📍</span> {{ $session->location }}
                    </p>
                </div>
                <div class="space-y-1">
                    <p class="text-gray-400 text-[10px] uppercase font-bold tracking-widest">Konselor</p>
                    <p class="text-white font-bold">{{ $session->counselor_name ?? ($session->counselor->name ?? 'N/A') }}</p>
                </div>
            </div>
        </div>

        <!-- Topics Section -->
        <div class="bg-gray-800/50 backdrop-blur-xl rounded-2xl border border-white/5 p-8 shadow-xl">
            <h3 class="text-lg font-bold text-white mb-6 flex items-center gap-3 border-b border-white/5 pb-3">
                <svg class="w-5 h-5 text-brand-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
                Topik Konseling
            </h3>
            <div class="flex flex-col md:flex-row gap-8">
                <div class="flex-1">
                    <span class="text-gray-400 text-[10px] uppercase font-bold tracking-widest block mb-3">Kategori Topik</span>
                    <div class="flex flex-wrap gap-2">
                        @forelse($session->topics as $topic)
                            <span class="px-4 py-1.5 bg-brand-teal/10 text-brand-teal text-sm font-bold rounded-xl border border-brand-teal/20">
                                {{ $topic->name }}
                            </span>
                        @empty
                            <span class="text-gray-500 italic text-sm">Tidak ada topik terangkum</span>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Notes Section -->
        <div class="bg-gray-800/50 backdrop-blur-xl rounded-2xl border border-white/5 overflow-hidden shadow-2xl">
            <div class="bg-gradient-to-r from-brand-teal/20 to-transparent px-8 py-5 border-b border-white/5">
                <h3 class="text-xl font-bold text-brand-teal flex items-center gap-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Catatan & Hasil Konseling
                </h3>
            </div>
            <div class="p-8 space-y-8">
                <div class="relative bg-gray-900/50 rounded-2xl p-8 border border-white/5 shadow-inner max-h-[400px] overflow-y-auto">
                    <svg class="absolute top-4 left-4 w-8 h-8 text-white/5" fill="currentColor" viewBox="0 0 32 32">
                        <path d="M10 8c-3.3 0-6 2.7-6 6v10h10V14H6c0-2.2 1.8-4 4-4V8zm18 0c-3.3 0-6 2.7-6 6v10h10V14h-8c0-2.2 1.8-4 4-4V8z"></path>
                    </svg>
                    <p class="text-brand-light/90 leading-relaxed whitespace-pre-wrap text-base md:text-lg font-medium italic py-4 break-words">
                        {{ $session->notes }}
                    </p>
                </div>
                
                @if($session->recommendations)
                <div class="pt-6 border-t border-white/5">
                    <h4 class="text-sm font-bold text-brand-teal uppercase tracking-widest mb-4 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-brand-teal animate-pulse"></span>
                        Rekomendasi / Tindak Lanjut
                    </h4>
                    <div class="p-6 bg-brand-teal/5 border border-brand-teal/20 rounded-2xl max-h-[300px] overflow-y-auto">
                        <p class="text-brand-light/80 leading-relaxed text-base break-words whitespace-pre-wrap">{{ $session->recommendations }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>

        @if($session->schedule && $session->schedule->counselingRequest)
        <!-- Request Origin Information -->
        <div class="bg-gray-800/30 rounded-2xl border border-white/5 p-6 flex items-center justify-between group">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-white/5 rounded-xl flex items-center justify-center border border-white/10 group-hover:border-brand-teal/30 transition-colors">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-brand-light/40 uppercase font-bold tracking-widest">Asal Permintaan Konseling</p>
                    <p class="text-brand-light text-sm">Sesi ini dibuat berdasarkan permintaan siswa.</p>
                </div>
            </div>
            <a href="{{ route('admin.counseling_requests.show', $session->schedule->counseling_request_id) }}" 
               class="px-5 py-2 bg-brand-teal/10 hover:bg-brand-teal/20 text-brand-teal font-bold rounded-xl text-sm transition-all border border-brand-teal/20">
                Detail Permintaan #{{ $session->schedule->counseling_request_id }}
            </a>
        </div>
        @endif
    </div>
</div>
@endsection