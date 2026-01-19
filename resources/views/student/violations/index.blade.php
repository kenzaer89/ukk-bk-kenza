@extends('layouts.app')

@section('title', 'Riwayat Pelanggaran')

@section('content')
<div class="min-h-screen p-6">
    <!-- Header -->
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-brand-light mb-2 flex items-center gap-3">
                <span class="p-2 bg-indigo-500/20 rounded-lg">
                    <svg class="w-8 h-8 text-brand-teal" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </span>
                Riwayat Pelanggaran
            </h1>
            <p class="text-brand-light/60">Daftar lengkap pelanggaran yang pernah tercatat</p>
        </div>
        <a href="{{ route('student.dashboard') }}" class="px-4 py-2 bg-brand-gray border border-brand-light/10 rounded-lg text-brand-light hover:bg-brand-light/5 transition-all">
            Kembali ke Dashboard
        </a>
    </div>

    <!-- Statistics Summary -->
    <div class="bg-brand-gray rounded-xl border border-brand-light/10 p-6 mb-8">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-brand-light/60 text-sm uppercase tracking-wider font-semibold mb-1">Total Poin Dikurangi</p>
                <p class="text-3xl font-bold text-red-500">
                    {{ $violations->sum(function($v) { return $v->rule->points; }) }}
                </p>
            </div>
            <div class="text-right">
                <p class="text-brand-light/60 text-sm uppercase tracking-wider font-semibold mb-1">Sisa Poin Saat Ini</p>
                <p class="text-3xl font-bold 
                    @if(Auth::user()->points <= 50) text-red-500 
                    @elseif(Auth::user()->points <= 70) text-yellow-500 
                    @else text-green-500 
                    @endif">
                    {{ Auth::user()->points }}
                </p>
            </div>
        </div>
    </div>

    <!-- Violations List -->
    <div class="grid grid-cols-1 gap-6">
        @forelse ($violations as $index => $violation)
            <div class="bg-brand-gray border border-white/10 rounded-2xl overflow-hidden hover:border-rose-500/30 transition-all duration-300">
                <div class="p-6">
                    <!-- Header Card: Category & Points -->
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 bg-rose-500/10 text-rose-400 text-[10px] font-black uppercase tracking-widest rounded-full border border-rose-500/20">
                                {{ $violation->rule->category ?? 'CUSTOM' }}
                            </span>
                            <span class="text-brand-light/40 text-xs">NO. {{ $violations->firstItem() + $index }}</span>
                        </div>
                        <span class="px-4 py-2 bg-rose-500/20 text-rose-400 text-lg font-black rounded-lg">
                            -{{ $violation->rule->points ?? 0 }}
                        </span>
                    </div>

                    <!-- Jenis Pelanggaran (Judul Besar) -->
                    <h3 class="text-2xl font-bold text-white leading-tight mb-6">{{ $violation->rule->name ?? 'Pelanggaran' }}</h3>

                    <!-- Grid Informasi Detail -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-gray-700/50 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-brand-light/60" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest leading-none mb-1">Tanggal</p>
                                <p class="text-white font-medium">{{ \Carbon\Carbon::parse($violation->violation_date)->format('d F Y') }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-gray-700/50 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-brand-light/60" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest leading-none mb-1">Status</p>
                                @php
                                    $statusColors = [
                                        'pending' => 'text-yellow-500',
                                        'resolved' => 'text-green-500',
                                        'canceled' => 'text-red-500',
                                    ];
                                    $statusLabels = [
                                        'pending' => 'Menunggu',
                                        'resolved' => 'Selesai',
                                        'canceled' => 'Dibatalkan',
                                    ];
                                @endphp
                                <p class="font-bold {{ $statusColors[$violation->status] ?? 'text-gray-400' }}">
                                    {{ $statusLabels[$violation->status] ?? ucfirst($violation->status) }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-gray-700/50 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-brand-light/60" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest leading-none mb-1">Dicatat Oleh</p>
                                <p class="text-white font-medium">{{ $violation->teacher->name ?? 'Guru BK' }}</p>
                            </div>
                        </div>
                    </div>

                    @if($violation->description)
                        <div class="p-4 bg-gray-900/30 rounded-xl border border-white/5 max-h-[150px] overflow-y-auto">
                            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mb-2">Catatan Konseling:</p>
                            <p class="text-brand-light/80 text-sm italic break-words whitespace-pre-wrap">{{ $violation->description }}</p>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="bg-brand-gray rounded-xl border border-brand-light/10 text-center py-12">
                <div class="w-16 h-16 bg-brand-light/5 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-brand-light mb-2">Tidak Ada Pelanggaran</h3>
                <p class="text-brand-light/60">Anda belum memiliki catatan pelanggaran. Pertahankan!</p>
            </div>
        @endforelse

        @if($violations->hasPages())
            <div class="mt-4">
                {{ $violations->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
