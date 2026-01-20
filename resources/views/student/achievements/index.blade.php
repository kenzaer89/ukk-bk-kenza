@extends('layouts.app')

@section('title', 'Riwayat Prestasi')

@section('content')
<div class="min-h-screen p-6">
    <!-- Header -->
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-brand-light mb-2 flex items-center gap-3">
                <span class="p-2 bg-emerald-500/20 rounded-lg">
                    <svg class="w-8 h-8 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                    </svg>
                </span>
                Riwayat Prestasi
            </h1>
            <p class="text-brand-light/60">Daftar lengkap prestasi yang telah Anda raih</p>
        </div>
        <a href="{{ route('student.dashboard') }}" class="px-4 py-2 bg-brand-gray border border-brand-light/10 rounded-lg text-brand-light hover:bg-brand-light/5 transition-all">
            Kembali ke Dashboard
        </a>
    </div>

    <!-- Statistics Summary -->
    <div class="bg-brand-gray rounded-xl border border-brand-light/10 p-6 mb-8">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-brand-light/60 text-sm uppercase tracking-wider font-semibold mb-1">Total Poin Diperoleh</p>
                <p class="text-3xl font-bold text-green-500">
                    +{{ $achievements->sum('point') }}
                </p>
            </div>
            <div class="text-right">
                <p class="text-brand-light/60 text-sm uppercase tracking-wider font-semibold mb-1">Total Prestasi</p>
                <p class="text-3xl font-bold text-brand-light">
                    {{ $achievements->total() }}
                </p>
            </div>
        </div>
    </div>

    <!-- Achievements Table -->
    <div class="bg-gray-800 rounded-2xl border border-brand-light/10 shadow-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-xs font-semibold tracking-wider text-left text-gray-400 uppercase border-b border-gray-700 bg-gray-800/50">
                        <th class="px-8 py-4">PRESTASI</th>
                        <th class="px-8 py-4">TANGGAL</th>
                        <th class="px-8 py-4">PENCATAT</th>
                        <th class="px-8 py-4">POIN</th>
                        <th class="px-8 py-4 text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($achievements as $achievement)
                    <tr class="hover:bg-gray-700 transition duration-150 border-b border-gray-700">
                        <td class="px-8 py-6">
                            <div class="flex flex-col gap-1">
                                <span class="text-brand-light font-bold text-base">{{ $achievement->name }}</span>
                                <span class="inline-flex items-center w-fit px-2 py-0.5 rounded bg-emerald-500/10 text-emerald-400 text-[10px] font-bold uppercase tracking-wider">
                                    {{ $achievement->level ?? 'Sekolah' }}
                                </span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex flex-col">
                                <span class="text-brand-light font-medium">{{ $achievement->achievement_date ? $achievement->achievement_date->translatedFormat('d F Y') : '-' }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex flex-col">
                                <span class="text-brand-light font-medium">{{ $achievement->teacher->name ?? 'Admin Sekolah' }}</span>
                                <span class="text-[10px] text-brand-light/40 uppercase tracking-wider">Guru BK</span>
                            </div>
                        </td>
                         <td class="px-8 py-6">
                            <span class="px-3 py-1 inline-flex text-sm font-bold rounded-full bg-green-500/20 text-green-500">
                                +{{ $achievement->point }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <button x-data @click="$dispatch('open-achievement-detail-{{ $achievement->id }}')" class="px-4 py-1.5 bg-brand-light/5 border border-brand-light/10 text-brand-light/80 rounded-lg font-bold hover:bg-brand-teal hover:text-brand-dark transition-all text-[10px] uppercase tracking-wider">
                                Detail
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center gap-4">
                                <div class="w-16 h-16 rounded-2xl bg-brand-light/5 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-emerald-400/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                    </svg>
                                </div>
                                <div class="max-w-xs">
                                    <h3 class="text-lg font-bold text-brand-light mb-1">Belum Ada Prestasi</h3>
                                    <p class="text-sm text-brand-light/40">Teruslah berusaha dan raih prestasimu!</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($achievements->hasPages())
    <div class="mt-8">
        {{ $achievements->links() }}
    </div>
    @endif
</div>

<!-- Modals for details -->
@foreach($achievements as $achievement)
    <div x-data="{ open: false }" 
         x-show="open" 
         @open-achievement-detail-{{ $achievement->id }}.window="open = true"
         style="display: none;"
         class="fixed inset-0 z-50 overflow-y-auto" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-brand-dark/95 transition-opacity" @click="open = false"></div>

            <div class="inline-block align-bottom bg-brand-gray rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-brand-light/10">
                <div class="px-6 py-4 border-b border-brand-light/5 flex justify-between items-center">
                    <h3 class="text-xl font-bold text-brand-light">Detail Prestasi</h3>
                    <button @click="open = false" class="text-brand-light/40 hover:text-brand-light transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <div class="p-8 space-y-6">
                    <!-- Status & Time -->
                    <div class="flex justify-between items-center bg-brand-light/5 p-4 rounded-xl">
                        <div class="flex flex-col">
                            <span class="text-[10px] text-brand-light/40 uppercase font-bold tracking-widest mb-1">Poin</span>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase w-fit bg-green-500/20 text-green-500">
                                +{{ $achievement->point }} Poin
                            </span>
                        </div>
                        <div class="text-right">
                            <span class="text-[10px] text-brand-light/40 uppercase font-bold tracking-widest block mb-1">Tanggal</span>
                            <span class="text-brand-light font-medium text-sm">{{ $achievement->achievement_date ? $achievement->achievement_date->translatedFormat('d F Y') : '-' }}</span>
                        </div>
                    </div>

                    <!-- Details Grid -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 bg-brand-light/5 border border-brand-light/5 rounded-xl">
                            <span class="text-[10px] text-brand-light/40 uppercase font-bold tracking-widest block mb-2">Tingkat</span>
                            <p class="text-brand-light font-bold">{{ $achievement->level ?? 'Sekolah' }}</p>
                        </div>
                        <div class="p-4 bg-brand-light/5 border border-brand-light/5 rounded-xl">
                            <span class="text-[10px] text-brand-light/40 uppercase font-bold tracking-widest block mb-2">Pencatat</span>
                            <p class="text-brand-light font-bold">{{ $achievement->teacher->name ?? 'Admin Sekolah' }}</p>
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <span class="text-[10px] text-brand-light/40 uppercase font-bold tracking-widest block mb-1">Nama Prestasi</span>
                        <div class="p-4 bg-brand-teal/5 border border-brand-teal/10 rounded-xl mb-4">
                            <p class="text-brand-teal font-bold">
                                {{ $achievement->name }}
                            </p>
                        </div>
                        
                         @if($achievement->description)
                        <span class="text-[10px] text-brand-light/40 uppercase font-bold tracking-widest block mb-2">Deskripsi Lengkap</span>
                        <div class="p-4 bg-brand-light/5 border border-brand-light/5 rounded-xl max-h-[200px] overflow-y-auto">
                            <p class="text-brand-light/90 italic leading-relaxed break-words whitespace-pre-wrap">{{ $achievement->description }}</p>
                        </div>
                        @endif
                    </div>

                </div>

                <div class="px-8 py-6 bg-brand-light/5 border-t border-brand-light/5 text-right">
                    <button @click="open = false" class="px-6 py-2.5 bg-brand-gray border border-brand-light/10 text-brand-light font-bold rounded-xl hover:bg-brand-light/10 transition-all text-sm">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
@endforeach
@endsection
