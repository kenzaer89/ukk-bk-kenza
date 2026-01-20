@extends('layouts.app')

@section('title', 'Riwayat Pelanggaran: ' . $student->name)

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
                    <span class="p-2 bg-rose-500/20 rounded-lg">
                        <svg class="w-8 h-8 text-rose-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </span>
                    Riwayat Pelanggaran: {{ $student->name }}
                </h1>
                <p class="text-gray-400">Seluruh catatan kedisiplinan yang tercatat di sistem.</p>
            </div>
        </div>

        <div class="bg-gray-800/40 backdrop-blur-md border border-gray-700/50 p-4 rounded-2xl shadow-xl flex items-center gap-4">
            <div class="w-12 h-12 bg-rose-500/10 rounded-xl flex items-center justify-center">
                <span class="text-rose-400 font-bold text-xl">{{ $violations->total() }}</span>
            </div>
            <div>
                <p class="text-[10px] uppercase tracking-widest text-gray-500 font-bold leading-tight">Total Catatan</p>
                <p class="text-white font-medium">Pelanggaran</p>
            </div>
        </div>
    </div>

    <!-- Violations Grid/List -->
    <div class="grid grid-cols-1 gap-6">
        @forelse ($violations as $index => $violation)
            <div class="bg-brand-gray border border-white/10 rounded-2xl overflow-hidden hover:border-rose-500/30 transition-all duration-300">
                <div class="flex flex-col md:flex-row">
                    <div class="p-6 flex-1">
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

                        <div class="flex flex-wrap gap-x-12 gap-y-6">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg bg-gray-700/50 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-brand-light/60" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest leading-none mb-1">Jenis Pelanggaran</p>
                                    <p class="text-white font-bold">{{ $violation->rule->name ?? 'Pelanggaran' }}</p>
                                </div>
                            </div>

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
                            <div class="mt-6 p-4 bg-gray-900/30 rounded-xl border border-white/5">
                                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mb-2">PESAN DARI GURU BK:</p>
                                <p class="text-brand-light/80 text-sm italic break-all whitespace-pre-wrap">{{ $violation->description }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-gray-800/50 backdrop-blur-xl border border-gray-700/50 rounded-2xl p-20 text-center">
                <div class="flex flex-col items-center gap-4">
                    <div class="w-20 h-20 bg-gray-700/20 rounded-full flex items-center justify-center text-emerald-400">
                        <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-gray-500 text-lg font-bold italic uppercase tracking-widest">Luar Biasa!</p>
                    <p class="text-gray-600 max-w-xs mx-auto text-sm leading-relaxed">
                        Anak Anda tidak memiliki catatan pelanggaran. Terus dukung perilakunya yang positif!
                    </p>
                </div>
            </div>
        @endforelse

        @if($violations->hasPages())
            <div class="mt-2">
                {{ $violations->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
