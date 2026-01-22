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
                    {{ $violations->where('status', 'resolved')->sum(function($v) { return $v->rule->points; }) }}
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

    <!-- Violations Table -->
    <div class="bg-gray-800 rounded-2xl border border-brand-light/10 shadow-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-xs font-semibold tracking-wider text-left text-gray-400 uppercase border-b border-gray-700 bg-gray-800/50">
                        <th class="px-8 py-4">JENIS PELANGGARAN</th>
                        <th class="px-8 py-4">WAKTU DAN PENCATAT</th>
                        <th class="px-8 py-4">POIN</th>
                        <th class="px-8 py-4 text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse ($violations as $violation)
                    <tr class="hover:bg-gray-700 transition duration-150 border-b border-gray-700">
                        <td class="px-8 py-6">
                            <div class="flex flex-col gap-1">
                                <span class="inline-flex items-center w-fit px-2 py-0.5 rounded bg-rose-500/10 text-rose-400 text-[10px] font-bold uppercase tracking-wider">
                                    {{ $violation->rule->category ?? 'CUSTOM' }}
                                </span>
                                <p class="text-brand-light font-medium text-sm">{{ $violation->rule->name ?? 'Pelanggaran' }}</p>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex flex-col">
                                <span class="text-brand-light font-medium">{{ \Carbon\Carbon::parse($violation->violation_date)->translatedFormat('d F Y') }}</span>
                                <span class="text-[10px] text-brand-light/40 uppercase tracking-wider">
                                    Oleh: {{ $violation->teacher->name ?? 'Guru BK' }}
                                </span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="text-rose-400 font-bold">-{{ $violation->rule->points ?? 0 }}</span>
                        </td>

                        <td class="px-8 py-6 text-center">
                            <button x-data @click="$dispatch('open-violation-detail-{{ $violation->id }}')" class="px-4 py-1.5 bg-brand-light/5 border border-brand-light/10 text-brand-light/80 rounded-lg font-bold hover:bg-brand-teal hover:text-brand-dark transition-all text-[10px] uppercase tracking-wider">
                                Detail
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center gap-4">
                                <div class="w-16 h-16 rounded-2xl bg-brand-light/5 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="max-w-xs">
                                    <h3 class="text-lg font-bold text-brand-light mb-1">Tidak Ada Pelanggaran</h3>
                                    <p class="text-sm text-brand-light/40">Anda belum memiliki catatan pelanggaran. Pertahankan!</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($violations->hasPages())
            <div class="mt-4">
                {{ $violations->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modals for details -->
@foreach($violations as $violation)
    <div x-data="{ open: false }" 
         x-show="open" 
         @open-violation-detail-{{ $violation->id }}.window="open = true"
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
                    <h3 class="text-xl font-bold text-brand-light">Detail Pelanggaran</h3>
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
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase w-fit bg-rose-500/20 text-rose-500">
                                -{{ $violation->rule->points ?? 0 }} Poin
                            </span>
                        </div>
                        <div class="text-right">
                            <span class="text-[10px] text-brand-light/40 uppercase font-bold tracking-widest block mb-1">Tanggal</span>
                            <span class="text-brand-light font-medium text-sm">{{ \Carbon\Carbon::parse($violation->violation_date)->translatedFormat('d F Y') }}</span>
                        </div>
                    </div>

                    <!-- Details Grid -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 bg-brand-light/5 border border-brand-light/5 rounded-xl">
                            <span class="text-[10px] text-brand-light/40 uppercase font-bold tracking-widest block mb-2">Kategori</span>
                            <p class="text-brand-light font-bold">{{ $violation->rule->category ?? 'Umum' }}</p>
                        </div>
                        <div class="p-4 bg-brand-light/5 border border-brand-light/5 rounded-xl">
                            <span class="text-[10px] text-brand-light/40 uppercase font-bold tracking-widest block mb-2">Pencatat</span>
                            <p class="text-brand-light font-bold">{{ $violation->teacher->name ?? 'Guru Tok' }}</p>
                        </div>
                    </div>
                    


                    <!-- Description -->
                    <div>
                        <span class="text-[10px] text-brand-light/40 uppercase font-bold tracking-widest block mb-1">Jenis Pelanggaran</span>
                        <div class="p-4 bg-rose-500/5 border border-rose-500/10 rounded-xl mb-4">
                            <p class="text-rose-400 font-bold">
                                {{ $violation->rule->name ?? 'Pelanggaran' }}
                            </p>
                        </div>
                        
                         @if($violation->description)
                        <span class="text-[10px] text-brand-light/40 uppercase font-bold tracking-widest block mb-2">Catatan Kekhususan</span>
                        <div class="p-4 bg-brand-light/5 border border-brand-light/5 rounded-xl max-h-[150px] overflow-y-auto mb-4">
                            <p class="text-brand-light/90 italic leading-relaxed break-words whitespace-pre-wrap">{{ $violation->description }}</p>
                        </div>
                        @endif

                        @if($violation->follow_up_action)
                        <span class="text-[10px] text-brand-light/40 uppercase font-bold tracking-widest block mb-2">Tindak Lanjut</span>
                        <div class="p-4 bg-brand-light/5 border border-brand-light/5 rounded-xl max-h-[150px] overflow-y-auto">
                            <p class="text-brand-light/90 italic leading-relaxed break-words whitespace-pre-wrap">{{ $violation->follow_up_action }}</p>
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
