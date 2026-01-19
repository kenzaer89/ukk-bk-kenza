@extends('layouts.app')

@section('title', 'Daftar Pelanggaran')

@section('content')
<div class="p-6">
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-white flex items-center gap-3">
                <span class="p-2 bg-indigo-500/20 rounded-lg">
                    <svg class="w-8 h-8 text-brand-teal" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </span>
                Daftar Pelanggaran Siswa
            </h1>
            <p class="text-gray-400 mt-1">Kelola catatan kedisiplinan siswa</p>
        </div>

        <div class="flex flex-col sm:flex-row items-center gap-4">
            <form action="{{ route('admin.violations.index') }}" method="GET" class="relative group w-full sm:w-64">
                <input type="text" name="search" value="{{ request('search') }}" 
                    placeholder="Cari siswa, aturan..." 
                    class="w-full bg-gray-900/50 border border-gray-700/50 text-white text-sm rounded-xl px-4 py-3 pl-10 focus:ring-2 focus:ring-brand-teal focus:border-transparent transition-all duration-200 outline-none group-hover:bg-gray-800/80">
                <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 group-hover:text-brand-teal transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </form>

            <a href="{{ route('admin.violations.create') }}" 
               class="w-full sm:w-auto bg-brand-teal hover:bg-brand-teal/90 text-brand-dark font-bold py-2.5 px-6 rounded-lg transition-all duration-300 shadow-[0_0_20px_rgba(45,212,191,0.2)] flex items-center justify-center whitespace-nowrap">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Catat Pelanggaran
            </a>
        </div>
    </div>



    <div class="bg-gray-800 rounded-xl shadow-lg p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr class="text-xs font-semibold tracking-wider text-left text-gray-400 uppercase border-b border-gray-700">
                        <th class="px-5 py-3 text-gray-400 font-bold uppercase">NO</th>
                        <th class="px-5 py-3 text-gray-400 font-bold uppercase">SISWA</th>
                        <th class="px-5 py-3 text-gray-400 font-bold uppercase">KELAS</th>
                        <th class="px-5 py-3 text-gray-400 font-bold uppercase">JENIS PELANGGARAN</th>
                        <th class="px-5 py-3 text-gray-400 font-bold uppercase">POIN</th>
                        <th class="px-5 py-3 text-gray-400 font-bold uppercase">STATUS</th>
                        <th class="px-5 py-3 text-gray-400 font-bold uppercase">TANGGAL</th>
                        <th class="px-5 py-3 text-gray-400 font-bold uppercase">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($violations as $violation)
                        <tr class="hover:bg-gray-700 transition duration-150 border-b border-gray-700">
                            <td class="px-5 py-5 text-sm">{{ $loop->iteration }}</td>
                            <td class="px-5 py-5 text-sm font-medium text-white">{{ $violation->student->name ?? 'N/A' }}</td>
                            <td class="px-5 py-5 text-sm">{{ $violation->student->schoolClass->name ?? 'N/A' }}</td>
                            <td class="px-5 py-5 text-sm text-red-400 font-medium">{{ $violation->rule->name ?? 'Aturan Dihapus' }}</td>
                            <td class="px-5 py-5 text-sm text-red-500 font-bold">{{ $violation->rule->points ?? 0 }}</td>
                            <td class="px-5 py-5 text-sm">
                                @if($violation->status == 'resolved')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-green-500/20 text-green-500">
                                        Selesai
                                    </span>
                                @elseif($violation->status == 'pending')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-yellow-500/20 text-yellow-500">
                                        Menunggu
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-gray-500/20 text-brand-light">
                                        {{ ucfirst($violation->status) }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-5 text-sm">{{ \Carbon\Carbon::parse($violation->violation_date)->format('d M Y') }}</td>
                            <td class="px-5 py-5 text-sm">
                                <div class="flex items-center gap-2">
                                    @if($violation->status == 'resolved')
                                    <button x-data @click="$dispatch('open-violation-detail-{{ $violation->id }}')" class="inline-flex items-center px-3 py-1 bg-brand-teal/10 text-brand-teal border border-brand-teal/30 rounded-md hover:bg-brand-teal hover:text-brand-dark transition text-xs font-bold">
                                        Detail
                                    </button>
                                    @endif
                                    
                                    @if($violation->status !== 'resolved')
                                    <a href="{{ route('admin.violations.edit', $violation) }}" 
                                       class="inline-flex items-center px-3 py-1 bg-yellow-600/20 text-yellow-500 border border-yellow-500/50 rounded-md hover:bg-yellow-600 hover:text-white transition text-xs font-bold">
                                        Edit
                                    </a>
                                    @endif
                                    <form action="{{ route('admin.violations.destroy', $violation) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center px-3 py-1 bg-red-600/10 text-red-500 border border-red-600/30 rounded-md hover:bg-red-600 hover:text-white transition text-xs font-bold"
                                                onclick="return confirmAction(event, 'Hapus Pelanggaran', 'Apakah Anda yakin ingin menghapus pelanggaran ini?', 'warning', 'Ya, Hapus')">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-5 py-20 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <svg class="w-16 h-16 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                    @if(request('search'))
                                        <p class="text-gray-500 text-lg italic">Tidak ada pelanggaran yang cocok dengan kata kunci "{{ request('search') }}".</p>
                                        <a href="{{ route('admin.violations.index') }}" class="text-brand-teal hover:underline font-semibold mt-2">Hapus pencarian</a>
                                    @else
                                        <p class="text-gray-500 text-lg italic">Belum ada pelanggaran yang dicatat.</p>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $violations->links() }}
        </div>
    </div>
</div>

<!-- Modals for details -->
@foreach($violations as $violation)
    @if($violation->status == 'resolved')
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
                            <span class="text-[10px] text-brand-light/40 uppercase font-bold tracking-widest mb-1">Status</span>
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-green-500/20 text-green-500 uppercase">
                                Selesai
                            </span>
                        </div>
                        <div class="text-right">
                            <span class="text-[10px] text-brand-light/40 uppercase font-bold tracking-widest block mb-1">Tanggal Pelanggaran</span>
                            <span class="text-brand-light font-medium text-sm">{{ \Carbon\Carbon::parse($violation->violation_date)->translatedFormat('d F Y') }}</span>
                        </div>
                    </div>

                    <!-- Rule & Points -->
                    <div>
                        <span class="text-[10px] text-brand-light/40 uppercase font-bold tracking-widest block mb-2">Jenis Pelanggaran & Poin</span>
                        <div class="p-4 bg-brand-light/5 border border-brand-light/5 rounded-xl">
                            <span class="bg-red-500/10 text-red-400 text-[10px] font-bold px-2 py-0.5 rounded uppercase mb-2 inline-block">
                                {{ $violation->rule->name ?? 'Aturan Dihapus' }}
                            </span>
                            <div class="flex items-center gap-2">
                                <span class="text-brand-light font-bold text-lg leading-tight">{{ $violation->student->name ?? 'N/A' }}</span>
                                <span class="text-red-500 font-bold">({{ $violation->rule->points ?? 0 }} Poin)</span>
                            </div>
                            <p class="text-brand-light/40 text-xs mt-1">{{ $violation->student->schoolClass->name ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="p-4 bg-brand-light/5 border border-brand-light/5 rounded-xl">
                        <span class="text-[10px] text-brand-light/40 uppercase font-bold tracking-widest block mb-2">Catatan Pelanggaran</span>
                        <p class="text-brand-light leading-relaxed whitespace-pre-wrap break-words italic">"{{ $violation->description }}"</p>
                    </div>

                    <!-- Teacher Assigned -->
                    <div class="p-4 bg-brand-light/5 border border-brand-light/5 rounded-xl">
                        <span class="text-[10px] text-brand-light/40 uppercase font-bold tracking-widest block mb-2">Guru BK yang Menangani</span>
                        <div class="flex items-center gap-3">
                            <span class="text-brand-light font-bold">{{ $violation->teacher->name ?? 'N/A' }}</span>
                        </div>
                    </div>

                    <!-- Follow up -->
                    @if($violation->follow_up_action)
                    <div class="p-4 bg-brand-teal/5 border border-brand-teal/10 rounded-xl">
                        <span class="text-[10px] text-brand-teal uppercase font-bold tracking-widest block mb-2">Tindakan Lanjut</span>
                        <p class="text-brand-light leading-relaxed whitespace-pre-wrap break-words">{{ $violation->follow_up_action }}</p>
                    </div>
                    @endif
                </div>

                <div class="px-8 py-6 bg-brand-light/5 border-t border-brand-light/5 text-right">
                    <button @click="open = false" class="px-6 py-2.5 bg-brand-gray border border-brand-light/10 text-brand-light font-bold rounded-xl hover:bg-brand-light/10 transition-all text-sm">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
@endforeach
@endsection