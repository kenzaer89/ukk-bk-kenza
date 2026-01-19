@extends('layouts.app')

@section('title', 'Riwayat Prestasi: ' . $student->name)

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
                    <span class="p-2 bg-emerald-500/20 rounded-lg">
                        <svg class="w-8 h-8 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                    </span>
                    Riwayat Prestasi: {{ $student->name }}
                </h1>
                <p class="text-gray-400">Seluruh pencapaian dan apresiasi yang pernah diraih.</p>
            </div>
        </div>

        <div class="bg-gray-800/40 backdrop-blur-md border border-gray-700/50 p-4 rounded-2xl shadow-xl flex items-center gap-4">
            <div class="w-12 h-12 bg-emerald-500/10 rounded-xl flex items-center justify-center">
                <span class="text-emerald-400 font-bold text-xl">{{ $achievements->total() }}</span>
            </div>
            <div>
                <p class="text-[10px] uppercase tracking-widest text-gray-500 font-bold leading-tight">Total Catatan</p>
                <p class="text-white font-medium">Prestasi</p>
            </div>
        </div>
    </div>

    <!-- Achievements List -->
    <div class="grid grid-cols-1 gap-6">
        @forelse ($achievements as $achievement)
            <div class="bg-brand-gray border border-white/10 rounded-2xl overflow-hidden hover:border-emerald-500/30 transition-all duration-300">
                <div class="p-6">
                    <!-- Badge Level & Poin -->
                    <div class="flex items-center justify-between mb-4">
                        <span class="px-3 py-1 bg-emerald-500/10 text-emerald-400 text-[10px] font-black uppercase tracking-widest rounded-full border border-emerald-500/20">
                            {{ $achievement->level ?? 'Sekolah' }}
                        </span>
                        <span class="px-4 py-2 bg-emerald-500/20 text-emerald-400 text-lg font-black rounded-lg">
                            +{{ $achievement->point ?? 0 }}
                        </span>
                    </div>

                    <!-- Nama Prestasi sebagai Judul Utama -->
                    <h3 class="text-2xl font-bold text-white leading-tight mb-6">{{ $achievement->name }}</h3>

                    <!-- Grid Informasi -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-gray-700/50 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest leading-none mb-1">Tanggal Dicapai</p>
                                <p class="text-white font-bold text-lg">{{ \Carbon\Carbon::parse($achievement->achievement_date)->format('d F Y') }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-gray-700/50 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest leading-none mb-1">Tingkat Prestasi</p>
                                <p class="text-white font-medium capitalize">{{ $achievement->level ?? 'Umum' }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-gray-700/50 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest leading-none mb-1">Dicatat Oleh</p>
                                <p class="text-white font-medium">{{ $achievement->teacher->name ?? 'Admin' }}</p>
                                <p class="text-xs text-brand-teal mt-0.5">Guru Bimbingan Konseling</p>
                            </div>
                        </div>
                    </div>

                    @if($achievement->description)
                        <div class="p-4 bg-gray-900/30 rounded-xl border border-white/5 max-h-[150px] overflow-y-auto">
                            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mb-2">Deskripsi Prestasi:</p>
                            <p class="text-brand-light/80 text-sm italic break-words whitespace-pre-wrap">{{ $achievement->description }}</p>
                        </div>
                    @endif

                    @if($achievement->notes)
                        <div class="mt-4 p-4 bg-blue-500/5 rounded-xl border border-blue-500/10 max-h-[150px] overflow-y-auto">
                            <p class="text-[10px] text-blue-400 font-bold uppercase tracking-widest mb-1">Catatan Tambahan:</p>
                            <p class="text-brand-light/70 text-sm break-words whitespace-pre-wrap">{{ $achievement->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="bg-gray-800/50 backdrop-blur-xl border border-gray-700/50 rounded-2xl p-20 text-center">
                <div class="flex flex-col items-center gap-4">
                    <div class="w-20 h-20 bg-gray-700/20 rounded-full flex items-center justify-center text-gray-600">
                        <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <p class="text-gray-500 text-lg font-medium italic">Belum ada catatan prestasi.</p>
                </div>
            </div>
        @endforelse

        @if($achievements->hasPages())
            <div class="mt-4">
                {{ $achievements->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
