@extends('layouts.app')

@section('title', 'Sesi Konseling: ' . $student->name)

@section('content')
<div class="p-6">
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('parent.dashboard') }}" 
               class="p-2 bg-gray-800 hover:bg-gray-700 text-gray-400 hover:text-white rounded-xl transition-all duration-300 border border-gray-700/50 group">
                <svg class="w-6 h-6 transform group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-white mb-1 flex items-center gap-3">
                    <span class="p-2 bg-blue-500/20 rounded-lg">
                        <svg class="w-8 h-8 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </span>
                    Sesi Konseling: {{ $student->name }}
                </h1>
                <p class="text-gray-400">Jadwal dan hasil pertemuan bimbingan konseling.</p>
            </div>
        </div>

        <div class="bg-gray-800/40 backdrop-blur-md border border-gray-700/50 p-4 rounded-2xl shadow-xl flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-500/10 rounded-xl flex items-center justify-center">
                <span class="text-blue-400 font-bold text-xl">{{ $sessions->total() }}</span>
            </div>
            <div>
                <p class="text-[10px] uppercase tracking-widest text-gray-500 font-bold leading-tight">Total Pertemuan</p>
                <p class="text-white font-medium">Sesi Konseling</p>
            </div>
        </div>
    </div>

    <!-- Sessions Grid/List -->
    <div class="grid grid-cols-1 gap-6">
        @forelse ($sessions as $session)
            <div class="bg-brand-gray border border-white/10 rounded-2xl overflow-hidden hover:border-blue-500/30 transition-all duration-300">
                <div class="flex flex-col md:flex-row">
                    <div class="p-6 flex-1">
                        <div class="flex items-center justify-end mb-4">
                            <span class="px-3 py-1 @if($session->status == 'completed' || $session->status == 'Selesai') bg-emerald-500/20 text-emerald-400 @elseif($session->status == 'cancelled' || $session->status == 'Dibatalkan') bg-rose-500/20 text-rose-400 @else bg-amber-500/20 text-amber-500 @endif text-xs font-bold rounded-lg uppercase">
                                @if($session->status == 'completed' || $session->status == 'Selesai')
                                    Selesai
                                @elseif($session->status == 'cancelled' || $session->status == 'Dibatalkan')
                                    Dibatalkan
                                @else
                                    {{ $session->status }}
                                @endif
                            </span>
                        </div>

                        <div class="flex flex-wrap gap-x-12 gap-y-6">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg bg-gray-700/50 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-brand-light/60" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest leading-none mb-1">Tanggal</p>
                                    <p class="text-white font-medium">{{ \Carbon\Carbon::parse($session->session_date)->format('d F Y') }}</p>
                                    <p class="text-xs text-brand-light/40 mt-1">{{ $session->start_time }} - {{ $session->end_time }} WIB</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg bg-gray-700/50 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-brand-light/60" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest leading-none mb-1">Guru BK</p>
                                    <p class="text-white font-medium">{{ $session->counselor_name ?? ($session->counselor->name ?? 'Guru BK') }}</p>
                                    <p class="text-xs text-brand-teal mt-1">Guru Bimbingan Konseling</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg bg-gray-700/50 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-brand-light/60" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest leading-none mb-1">Lokasi</p>
                                    <p class="text-white font-medium">{{ $session->location ?? 'Ruang BK' }}</p>
                                </div>
                            </div>
                        </div>

                        @if($session->notes)
                            <div class="mt-6 p-4 bg-gray-900/30 rounded-xl border border-white/5">
                                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mb-2">PESAN DARI GURU BK:</p>
                                <p class="text-brand-light/80 text-sm italic break-all whitespace-pre-wrap">"{{ $session->notes }}"</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-gray-800/50 backdrop-blur-xl border border-gray-700/50 rounded-2xl p-20 text-center">
                <div class="flex flex-col items-center gap-4">
                    <div class="w-20 h-20 bg-gray-700/20 rounded-full flex items-center justify-center text-gray-600">
                        <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                    </div>
                    <p class="text-gray-500 text-lg font-medium italic">Belum ada riwayat pertemuan konseling.</p>
                </div>
            </div>
        @endforelse

        @if($sessions->hasPages())
            <div class="mt-2">
                {{ $sessions->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
