@extends('layouts.app')

@section('title', 'Siswa Kelas ' . $class->name)

@section('content')
<div class="p-6" x-data="{ 
    showDetail: false, 
    selectedUser: null,
    openDetail(user) {
        this.selectedUser = user;
        this.showDetail = true;
    }
}">
    <!-- Header Section -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.classes.index') }}" 
               class="p-2 bg-gray-800 hover:bg-gray-700 text-gray-400 hover:text-white rounded-xl transition-all duration-300 border border-gray-700/50 group">
                <svg class="w-6 h-6 transform group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-white mb-1 flex items-center gap-3">
                    <span class="p-2 bg-indigo-500/20 rounded-lg">
                        <svg class="w-8 h-8 text-brand-teal" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </span>
                    Daftar Siswa: {{ $class->name }}
                </h1>
                <nav class="flex text-sm text-gray-400" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('admin.dashboard') }}" class="hover:text-white transition-colors">Dashboard</a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                                <a href="{{ route('admin.classes.index') }}" class="hover:text-white transition-colors">Data Kelas</a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                                <span class="ml-1 md:ml-2 font-medium text-brand-teal">{{ $class->name }}</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Class Info Badge -->
        <div class="grid grid-cols-2 gap-4 bg-gray-800/40 backdrop-blur-md border border-gray-700/50 p-4 rounded-2xl shadow-xl">
            <div class="flex flex-col">
                <span class="text-[10px] uppercase tracking-widest text-gray-500 font-bold">Jurusan</span>
                <span class="text-white font-medium">{{ $class->jurusan_full_name }}</span>
            </div>
            <div class="flex flex-col border-l border-gray-700 pl-4">
                <span class="text-[10px] uppercase tracking-widest text-gray-500 font-bold">Wali Kelas</span>
                <span class="text-sky-400 font-bold">{{ $class->waliKelas->name ?? 'Belum Ditentukan' }}</span>
            </div>
        </div>
    </div>

    <!-- Main Table Cardio -->
    <div class="relative overflow-hidden bg-gray-800/50 backdrop-blur-xl border border-gray-700/50 rounded-2xl shadow-2xl overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-900/50">
                    <th class="px-6 py-4 text-sm font-semibold text-gray-400 uppercase tracking-wider border-b border-gray-700 text-center w-16">No</th>
                    <th class="px-6 py-4 text-sm font-semibold text-gray-400 uppercase tracking-wider border-b border-gray-700">Identitas Siswa</th>
                    <th class="px-6 py-4 text-sm font-semibold text-gray-400 uppercase tracking-wider border-b border-gray-700 text-center">Poin Kedisiplinan</th>
                    <th class="px-6 py-4 text-sm font-semibold text-gray-400 uppercase tracking-wider border-b border-gray-700 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700/50">
                @forelse ($class->students->sortBy('absen') as $index => $student)
                    <tr class="group hover:bg-gray-700/30 transition-colors duration-200" style="animation-delay: {{ $index * 0.05 }}s">
                        <td class="px-6 py-4 text-center">
                            <span class="text-gray-400 font-mono text-sm group-hover:text-indigo-400 transition-colors">
                                {{ str_pad($student->absen ?? '0', 2, '0', STR_PAD_LEFT) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold shadow-lg shadow-indigo-500/20">
                                    {{ substr($student->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-white font-bold text-base leading-tight">{{ $student->name }}</div>
                                    <div class="text-gray-500 text-xs mt-1">{{ $student->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="inline-flex flex-col items-center">
                                <span class="text-2xl font-black 
                                    @if($student->points <= 50) text-rose-500
                                    @elseif($student->points <= 70) text-amber-500
                                    @else text-emerald-400 @endif
                                ">{{ $student->points }}</span>
                                <div class="w-24 h-1 bg-gray-700 rounded-full mt-1 overflow-hidden">
                                    <div class="h-full rounded-full transition-all duration-1000 
                                        @if($student->points <= 50) bg-rose-500
                                        @elseif($student->points <= 70) bg-amber-500
                                        @else bg-emerald-400 @endif
                                    " style="width: {{ $student->points }}%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button @click="openDetail({
                                name: '{{ $student->name }}',
                                email: '{{ $student->email }}',
                                phone: '{{ $student->phone ?? '-' }}',
                                role: '{{ $student->role }}',
                                nisn: '{{ $student->nisn ?? '-' }}',
                                absen: '{{ $student->absen ?? '-' }}',
                                class: '{{ $class->name }}',
                                jurusan: '{{ $class->jurusan_full_name }}',
                                points: '{{ $student->points ?? 0 }}'
                            })" class="inline-flex items-center px-4 py-2 border border-indigo-500/50 text-indigo-400 text-xs font-bold rounded-lg hover:bg-indigo-500 hover:text-white transition-all duration-300">
                                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                LIHAT PROFIL
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="p-4 bg-gray-700/20 rounded-full">
                                    <svg class="w-12 h-12 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                </div>
                                <p class="text-gray-500 text-lg italic">Belum ada siswa yang terdaftar di kelas ini.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Detail Modal -->
    <div x-show="showDetail" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="fixed inset-0 z-[100] overflow-y-auto" 
         style="display: none;">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div @click="showDetail = false" class="fixed inset-0 bg-black/80 backdrop-blur-md transition-opacity"></div>
            
            <div class="relative bg-brand-gray/95 border border-white/10 rounded-3xl shadow-2xl max-w-lg w-full overflow-hidden transform transition-all">
                <!-- Modal Header -->
                <div class="px-8 py-6 border-b border-white/5 bg-white/5 flex justify-between items-center">
                    <div>
                        <h3 class="text-2xl font-black text-white tracking-tight">Detail Siswa</h3>
                        <p class="text-xs text-gray-400 font-bold uppercase tracking-widest mt-1" x-text="selectedUser?.class"></p>
                    </div>
                    <button @click="showDetail = false" class="p-2 hover:bg-white/10 rounded-full transition-all text-gray-400 hover:text-white">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                <!-- Modal Content -->
                <div class="p-8 space-y-6">
                    <div class="flex flex-col gap-1">
                        <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Nama Lengkap</label>
                        <p class="text-white text-lg font-bold" x-text="selectedUser?.name"></p>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex flex-col gap-4">
                            <div class="flex flex-col gap-1">
                                <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Email</label>
                                <p class="text-brand-teal font-medium" x-text="selectedUser?.email"></p>
                            </div>
                            <div class="flex flex-col gap-1">
                                <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">NISN</label>
                                <p class="text-white font-medium" x-text="selectedUser?.nisn"></p>
                            </div>
                        </div>
                        <div class="flex flex-col gap-4">
                            <div class="flex flex-col gap-1">
                                <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Telepon</label>
                                <p class="text-white font-medium" x-text="selectedUser?.phone"></p>
                            </div>
                            <div class="flex flex-col gap-1">
                                <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">No. Absen</label>
                                <p class="text-white font-medium" x-text="selectedUser?.absen"></p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-white/5">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-white/5 p-4 rounded-2xl border border-white/5 text-center">
                                <label class="text-[9px] font-bold text-gray-500 uppercase tracking-widest block mb-1">Poin Kredit</label>
                                <p class="text-emerald-400 font-black text-2xl" x-text="selectedUser?.points"></p>
                            </div>
                            <div class="bg-indigo-500/5 p-4 rounded-2xl border border-indigo-500/10 text-center">
                                <label class="text-[9px] font-bold text-indigo-400 uppercase tracking-widest block mb-1">Status</label>
                                <p class="text-white font-bold text-sm">Aktif</p>
                            </div>
                        </div>
                        <div class="mt-4 bg-brand-teal/5 p-4 rounded-2xl border border-brand-teal/10 appearance-none">
                            <label class="text-[9px] font-bold text-brand-teal uppercase tracking-widest block mb-1">Jurusan</label>
                            <p class="text-white font-bold text-sm" x-text="selectedUser?.jurusan"></p>
                        </div>
                    </div>
                </div>
                
                <!-- Modal Footer -->
                <div class="px-8 py-6 bg-white/5 border-t border-white/10 text-right">
                    <button @click="showDetail = false" class="px-8 py-3 bg-brand-teal text-brand-dark font-black rounded-2xl transition-all text-xs uppercase shadow-[0_10px_20px_rgba(45,212,191,0.2)] hover:shadow-[0_15px_30px_rgba(45,212,191,0.3)] hover:-translate-y-0.5 active:translate-y-0">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<style>
    @keyframes slide-up {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    tbody tr {
        animation: slide-up 0.4s ease-out forwards;
        opacity: 0;
    }
</style>
@endsection
