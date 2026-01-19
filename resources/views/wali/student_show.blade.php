@extends('layouts.app')

@section('title', 'Detail Siswa - ' . $student->name)

@section('content')
<div class="p-6" x-data="{ 
    showModal: false, 
    modalTitle: '', 
    modalData: {},
    activeTab: 'overview',
    openDetail(title, data) {
        this.modalTitle = title;
        this.modalData = data;
        this.showModal = true;
    }
}">
    <!-- Breadcrumbs / Back Button -->
    <div class="mb-8">
        <a href="{{ route('wali.monitoring') }}" class="inline-flex items-center gap-2 text-gray-400 hover:text-brand-teal transition-colors font-medium">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Monitoring
        </a>
    </div>

    <!-- Student Profile Header (Always Visible) -->
    <div class="bg-gray-800/50 backdrop-blur-xl border border-gray-700/50 rounded-3xl p-6 mb-8 shadow-2xl">
        <div class="flex flex-col md:flex-row items-start gap-8">
            <div class="w-20 h-20 rounded-full bg-gradient-to-br from-indigo-500/20 to-brand-teal/20 flex items-center justify-center text-brand-teal border border-brand-teal/30 text-2xl font-bold shadow-xl">
                {{ substr($student->name, 0, 1) }}
            </div>
            <div class="flex-1">
                <div class="flex flex-wrap items-center gap-3 mb-4">
                    <h1 class="text-2xl font-bold text-white tracking-tight">{{ $student->name }}</h1>
                    <span class="px-2 py-0.5 bg-brand-teal/10 text-brand-teal rounded-lg text-[10px] font-semibold border border-brand-teal/20 uppercase tracking-widest">
                        Aktif
                    </span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="space-y-0.5">
                        <p class="text-[9px] uppercase font-semibold text-gray-500 tracking-widest">Alamat Email</p>
                        <p class="text-white text-sm font-medium">{{ $student->email }}</p>
                    </div>
                    <div class="space-y-0.5">
                        <p class="text-[9px] uppercase font-semibold text-gray-500 tracking-widest">Nomor Absen</p>
                        <p class="text-white text-sm font-medium">{{ str_pad($student->absen ?? '0', 2, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    <div class="space-y-0.5">
                        <p class="text-[9px] uppercase font-semibold text-gray-500 tracking-widest">Kelas & Jurusan</p>
                        <p class="text-white text-sm font-medium leading-tight">{{ $student->schoolClass->name ?? '-' }} ({{ $student->specialization_full_name ?? '-' }})</p>
                    </div>
                    <div class="space-y-0.5">
                        <p class="text-[9px] uppercase font-semibold text-gray-500 tracking-widest">NISN</p>
                        <p class="text-white text-sm font-medium">{{ $student->nisn ?? '-' }}</p>
                    </div>
                    <div class="space-y-0.5">
                        <p class="text-[9px] uppercase font-semibold text-gray-500 tracking-widest">Nomor Telepon</p>
                        <p class="text-white text-sm font-medium">{{ $student->phone ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-gray-900/40 px-6 py-4 rounded-2xl border border-gray-700/50 text-center min-w-[120px]">
                <p class="text-[9px] uppercase font-bold text-gray-500 tracking-widest mb-1">Poin Saat Ini</p>
                <p class="text-4xl font-black leading-none
                    {{ $student->points <= 50 ? 'text-rose-500' : ($student->points <= 75 ? 'text-amber-500' : 'text-emerald-400') }}">
                    {{ $student->points }}
                </p>
            </div>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="flex flex-wrap gap-2 mb-8 bg-gray-800/30 p-2 rounded-2xl border border-gray-700/50 backdrop-blur-md inline-flex">
        <button @click="activeTab = 'overview'" 
                :class="activeTab === 'overview' ? 'bg-brand-teal text-brand-dark shadow-lg shadow-brand-teal/20' : 'text-gray-400 hover:text-white hover:bg-white/5'"
                class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all duration-300 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
            RINGKASAN
        </button>
        <button @click="activeTab = 'violations'" 
                :class="activeTab === 'violations' ? 'bg-rose-500 text-white shadow-lg shadow-rose-500/20' : 'text-gray-400 hover:text-white hover:bg-white/5'"
                class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all duration-300 flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-rose-400" :class="activeTab === 'violations' ? 'bg-white' : ''"></span>
            PELANGGARAN
            <span class="px-1.5 py-0.5 rounded-md bg-black/20 text-[10px]">{{ $student->violations->count() }}</span>
        </button>
        <button @click="activeTab = 'achievements'" 
                :class="activeTab === 'achievements' ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/20' : 'text-gray-400 hover:text-white hover:bg-white/5'"
                class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all duration-300 flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-emerald-400" :class="activeTab === 'achievements' ? 'bg-white' : ''"></span>
            PRESTASI
            <span class="px-1.5 py-0.5 rounded-md bg-black/20 text-[10px]">{{ $student->achievements->count() }}</span>
        </button>
        <button @click="activeTab = 'counseling'" 
                :class="activeTab === 'counseling' ? 'bg-sky-500 text-white shadow-lg shadow-sky-500/20' : 'text-gray-400 hover:text-white hover:bg-white/5'"
                class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all duration-300 flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-sky-400" :class="activeTab === 'counseling' ? 'bg-white' : ''"></span>
            KONSELING
            <span class="px-1.5 py-0.5 rounded-md bg-black/20 text-[10px]">{{ $student->sessions->count() }}</span>
        </button>
    </div>

    <!-- Tab Content -->
    <div class="space-y-8">
        
        <!-- Overview Tab -->
        <div x-show="activeTab === 'overview'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Violations Summary Card -->
                <div class="bg-gray-800/50 backdrop-blur-xl border border-gray-700/50 rounded-3xl p-6 hover:border-rose-500/30 transition-all group cursor-pointer" @click="activeTab = 'violations'">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl bg-rose-500/20 flex items-center justify-center text-rose-400">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <svg class="w-5 h-5 text-gray-600 group-hover:text-rose-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </div>
                    <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-1">Total Pelanggaran</p>
                    <h4 class="text-3xl font-black text-white">{{ $student->violations->count() }}</h4>
                </div>

                <!-- Achievements Summary Card -->
                <div class="bg-gray-800/50 backdrop-blur-xl border border-gray-700/50 rounded-3xl p-6 hover:border-emerald-500/30 transition-all group cursor-pointer" @click="activeTab = 'achievements'">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl bg-emerald-500/20 flex items-center justify-center text-emerald-400">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                            </svg>
                        </div>
                        <svg class="w-5 h-5 text-gray-600 group-hover:text-emerald-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </div>
                    <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-1">Total Prestasi</p>
                    <h4 class="text-3xl font-black text-white">{{ $student->achievements->count() }}</h4>
                </div>

                <!-- Counseling Summary Card -->
                <div class="bg-gray-800/50 backdrop-blur-xl border border-gray-700/50 rounded-3xl p-6 hover:border-sky-500/30 transition-all group cursor-pointer" @click="activeTab = 'counseling'">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl bg-sky-500/20 flex items-center justify-center text-sky-400">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
                            </svg>
                        </div>
                        <svg class="w-5 h-5 text-gray-600 group-hover:text-sky-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </div>
                    <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-1">Total Konseling</p>
                    <h4 class="text-3xl font-black text-white">{{ $student->sessions->count() }}</h4>
                </div>
            </div>

            <!-- Recent Activity Highlights in Overview -->
            <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Recent Violations Highlight -->
                <div class="bg-gray-800/50 backdrop-blur-xl border border-gray-700/50 rounded-3xl p-6">
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-[0.2em] mb-6 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                        Pelanggaran Terakhir
                    </h3>
                    @if($student->violations->isNotEmpty())
                        @php $v = $student->violations->sortByDesc('violation_date')->first(); @endphp
                        <div class="p-5 bg-gray-900/50 rounded-2xl border border-gray-700/30">
                            <div class="flex justify-between items-start mb-3">
                                <span class="text-white font-bold">{{ $v->rule->name ?? 'Pelanggaran' }}</span>
                                <span class="text-[10px] text-gray-500 font-mono font-medium">{{ $v->violation_date->format('d M Y') }}</span>
                            </div>
                            <p class="text-gray-400 text-xs italic mb-4">"{{ $v->description }}"</p>
                            <button @click="activeTab = 'violations'" class="text-[10px] font-black text-rose-400 hover:text-rose-300 tracking-widest uppercase">Lihat Seluruh Riwayat →</button>
                        </div>
                    @else
                        <div class="text-center py-6 text-gray-600 italic">Tidak ada catatan pelanggaran.</div>
                    @endif
                </div>

                <!-- Recent Achievements Highlight -->
                <div class="bg-gray-800/50 backdrop-blur-xl border border-gray-700/50 rounded-3xl p-6">
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-[0.2em] mb-6 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        Prestasi Terakhir
                    </h3>
                    @if($student->achievements->isNotEmpty())
                        @php $a = $student->achievements->sortByDesc('achievement_date')->first(); @endphp
                        <div class="p-5 bg-gray-900/50 rounded-2xl border border-gray-700/30">
                            <div class="flex justify-between items-start mb-3">
                                <span class="text-white font-bold">{{ $a->name }}</span>
                                <span class="text-[10px] text-gray-500 font-mono font-medium">{{ $a->achievement_date->format('d M Y') }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-0.5 bg-emerald-500/10 text-emerald-500 text-[10px] font-bold rounded uppercase tracking-tighter">+{{ $a->point }} Poin</span>
                                <span class="text-gray-500 text-[10px] italic">Level: {{ $a->level }}</span>
                            </div>
                            <button @click="activeTab = 'achievements'" class="mt-4 text-[10px] font-black text-emerald-400 hover:text-emerald-300 tracking-widest uppercase">Lihat Seluruh Riwayat →</button>
                        </div>
                    @else
                        <div class="text-center py-6 text-gray-600 italic">Belum ada catatan prestasi.</div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Pelanggaran Tab -->
        <div x-show="activeTab === 'violations'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
            <div class="bg-gray-800/50 backdrop-blur-xl border border-gray-700/50 rounded-3xl shadow-2xl p-6">
                <div class="flex items-center justify-between mb-8 px-2">
                    <h3 class="text-xl font-bold text-white flex items-center gap-3">
                        <div class="w-10 h-10 bg-rose-500/10 rounded-xl flex items-center justify-center text-rose-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        Riwayat Pelanggaran Lengkap
                    </h3>
                    <div class="px-4 py-2 bg-rose-500/10 border border-rose-500/20 rounded-xl text-center">
                        <p class="text-[9px] font-black text-rose-400/60 uppercase tracking-widest">Total Catatan</p>
                        <p class="text-white font-bold text-lg leading-none">{{ $student->violations->count() }}</p>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr class="text-xs font-semibold tracking-wider text-left text-gray-400 uppercase border-b border-gray-700/50">
                                <th class="px-5 py-4 font-bold text-gray-400">NO</th>
                                <th class="px-5 py-4 font-bold text-gray-400">JENIS PELANGGARAN</th>
                                <th class="px-5 py-4 font-bold text-gray-400 text-center">POIN</th>
                                <th class="px-5 py-4 font-bold text-gray-400">STATUS</th>
                                <th class="px-5 py-4 font-bold text-gray-400">TANGGAL</th>
                                <th class="px-5 py-4 font-bold text-gray-400 text-center">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700/30">
                            @forelse ($student->violations->sortByDesc('violation_date') as $index => $v)
                                <tr class="hover:bg-white/5 transition duration-150">
                                    <td class="px-5 py-5 text-sm text-gray-500 font-mono">{{ $loop->iteration }}</td>
                                    <td class="px-5 py-5 text-sm">
                                        <span class="text-white font-bold block">{{ $v->rule->name ?? 'Pelanggaran' }}</span>
                                        <span class="text-[10px] text-gray-500 italic mt-0.5 block max-w-xs truncate">{{ $v->description }}</span>
                                    </td>
                                    <td class="px-5 py-5 text-sm text-center">
                                        <span class="px-3 py-1 bg-rose-500/10 text-rose-500 font-black rounded-lg border border-rose-500/20">
                                            -{{ $v->score ?? ($v->rule->points ?? 0) }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-5 text-sm">
                                        @if($v->status == 'resolved')
                                            <span class="px-2 py-0.5 bg-green-500/10 text-green-500 text-[10px] font-bold rounded-lg border border-green-500/20 uppercase tracking-tighter">
                                                Selesai
                                            </span>
                                        @elseif($v->status == 'pending')
                                            <span class="px-2 py-0.5 bg-yellow-500/10 text-yellow-500 text-[10px] font-bold rounded-lg border border-yellow-500/20 uppercase tracking-tighter">
                                                Menunggu
                                            </span>
                                        @else
                                            <span class="px-2 py-0.5 bg-gray-500/10 text-gray-400 text-[10px] font-bold rounded-lg border border-gray-500/20 uppercase tracking-tighter">
                                                {{ ucfirst($v->status ?? 'Catatan') }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-5 text-sm">
                                        <span class="text-gray-300 font-medium">{{ $v->violation_date->format('d M Y') }}</span>
                                    </td>
                                    <td class="px-5 py-5 text-sm text-center">
                                        <button @click="openDetail('Detail Pelanggaran', {
                                            'Nama Pelanggaran': '{{ $v->rule->name ?? 'Pelanggaran' }}',
                                            'Tanggal': '{{ $v->violation_date->format('d F Y') }}',
                                            'Poin Pelanggaran': '{{ $v->score ?? ($v->rule->points ?? 0) }} Poin',
                                            'Deskripsi': '{{ addslashes($v->description) }}',
                                            'Catatan Tambahan': '{{ addslashes($v->notes ?? '-') }}'
                                        })" class="inline-flex items-center px-3 py-1.5 bg-rose-500/10 text-rose-400 border border-rose-500/20 rounded-lg hover:bg-rose-500 hover:text-white transition-all text-[10px] font-black uppercase tracking-widest">
                                            Detail
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-5 py-20 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <div class="w-16 h-16 bg-emerald-500/10 rounded-full flex items-center justify-center text-emerald-400 shadow-[0_0_20px_rgba(16,185,129,0.1)]">
                                                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </div>
                                            <p class="text-gray-400 italic font-bold">Luar biasa! Tidak ada catatan pelanggaran.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Prestasi Tab -->
        <div x-show="activeTab === 'achievements'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
            <div class="bg-gray-800/50 backdrop-blur-xl border border-gray-700/50 rounded-3xl shadow-2xl p-6">
                <div class="flex items-center justify-between mb-8 px-2">
                    <h3 class="text-xl font-bold text-white flex items-center gap-3">
                        <div class="w-10 h-10 bg-emerald-500/10 rounded-xl flex items-center justify-center text-emerald-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                            </svg>
                        </div>
                        Riwayat Prestasi Lengkap
                    </h3>
                    <div class="px-4 py-2 bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-center">
                        <p class="text-[9px] font-black text-emerald-400/60 uppercase tracking-widest">Total Prestasi</p>
                        <p class="text-white font-bold text-lg leading-none">{{ $student->achievements->count() }}</p>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr class="text-xs font-semibold tracking-wider text-left text-gray-400 uppercase border-b border-gray-700/50">
                                <th class="px-5 py-4 font-bold text-gray-400">NO</th>
                                <th class="px-5 py-4 font-bold text-gray-400">NAMA PRESTASI</th>
                                <th class="px-5 py-4 font-bold text-gray-400">TINGKAT</th>
                                <th class="px-5 py-4 font-bold text-gray-400 text-center">POIN</th>
                                <th class="px-5 py-4 font-bold text-gray-400">TANGGAL</th>
                                <th class="px-5 py-4 font-bold text-gray-400 text-center">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700/30">
                            @forelse ($student->achievements->sortByDesc('achievement_date') as $index => $a)
                                <tr class="hover:bg-white/5 transition duration-150">
                                    <td class="px-5 py-5 text-sm text-gray-500 font-mono">{{ $loop->iteration }}</td>
                                    <td class="px-5 py-5 text-sm">
                                        <span class="text-white font-bold block">{{ $a->name }}</span>
                                    </td>
                                    <td class="px-5 py-5 text-sm">
                                        <span class="px-3 py-1 bg-indigo-500/10 text-indigo-400 text-[10px] font-black rounded-lg border border-indigo-500/20 uppercase tracking-widest">
                                            {{ $a->level }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-5 text-sm text-center">
                                        <span class="text-emerald-400 font-black">+{{ $a->point }}</span>
                                    </td>
                                    <td class="px-5 py-5 text-sm">
                                        <span class="text-gray-300 font-medium">{{ $a->achievement_date->format('d M Y') }}</span>
                                    </td>
                                    <td class="px-5 py-5 text-sm text-center">
                                        <button @click="openDetail('Detail Prestasi', {
                                            'Nama Prestasi': '{{ $a->name }}',
                                            'Tanggal': '{{ $a->achievement_date->format('d F Y') }}',
                                            'Poin Didapat': '+{{ $a->point }} Poin',
                                            'Tingkat/Level': '{{ $a->level }}',
                                            'Keterangan': '{{ addslashes($a->description ?? '-') }}',
                                            'Catatan': '{{ addslashes($a->notes ?? '-') }}'
                                        })" class="inline-flex items-center px-3 py-1.5 bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 rounded-lg hover:bg-emerald-500 hover:text-white transition-all text-[10px] font-black uppercase tracking-widest">
                                            Detail
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-5 py-12 text-center text-gray-500 italic font-bold">
                                        Belum ada catatan prestasi yang dicapai.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Konseling Tab -->
        <div x-show="activeTab === 'counseling'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
            <div class="bg-gray-800/50 backdrop-blur-xl border border-gray-700/50 rounded-3xl shadow-2xl p-6">
                <div class="flex items-center justify-between mb-8 px-2">
                    <h3 class="text-xl font-bold text-white flex items-center gap-3">
                        <div class="w-10 h-10 bg-sky-500/10 rounded-xl flex items-center justify-center text-sky-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
                            </svg>
                        </div>
                        Riwayat Konseling Lengkap
                    </h3>
                    <div class="px-4 py-2 bg-sky-500/10 border border-sky-500/20 rounded-xl text-center">
                        <p class="text-[9px] font-black text-sky-400/60 uppercase tracking-widest">Total Pertemuan</p>
                        <p class="text-white font-bold text-lg leading-none">{{ $student->sessions->count() }}</p>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr class="text-xs font-semibold tracking-wider text-left text-gray-400 uppercase border-b border-gray-700/50">
                                <th class="px-5 py-4 font-bold text-gray-400">NO</th>
                                <th class="px-5 py-4 font-bold text-gray-400">TIPE SESI</th>
                                <th class="px-5 py-4 font-bold text-gray-400">TANGGAL & WAKTU</th>
                                <th class="px-5 py-4 font-bold text-gray-400">KONSELOR</th>
                                <th class="px-5 py-4 font-bold text-gray-400">STATUS</th>
                                <th class="px-5 py-4 font-bold text-gray-400 text-center">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700/30">
                            @forelse ($student->sessions->sortByDesc('session_date') as $index => $s)
                                <tr class="hover:bg-white/5 transition duration-150">
                                    <td class="px-5 py-5 text-sm text-gray-500 font-mono">{{ $loop->iteration }}</td>
                                    <td class="px-5 py-5 text-sm">
                                        <span class="px-2.5 py-1 bg-sky-500/10 text-sky-400 text-[10px] font-black rounded-lg border border-sky-500/20 uppercase tracking-widest leading-none">
                                            {{ $s->session_type }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-5 text-sm">
                                        <span class="text-gray-300 font-bold block">{{ \Carbon\Carbon::parse($s->session_date)->format('d M Y') }}</span>
                                        <span class="text-[10px] text-gray-500 font-mono mt-0.5 block">
                                            {{ \Carbon\Carbon::parse($s->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($s->end_time)->format('H:i') }} WIB
                                        </span>
                                    </td>
                                    <td class="px-5 py-5 text-sm">
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 rounded-lg bg-sky-500/10 flex items-center justify-center text-sky-400 font-black text-xs border border-sky-500/20">
                                                {{ substr($s->counselor->name ?? 'A', 0, 1) }}
                                            </div>
                                            <span class="text-white font-medium">{{ $s->counselor->name ?? 'Admin' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-5 py-5 text-sm">
                                        <span class="px-3 py-1 bg-emerald-500/10 text-emerald-400 text-[10px] font-bold rounded-lg border border-emerald-500/20 uppercase">
                                            Selesai
                                        </span>
                                    </td>
                                    <td class="px-5 py-5 text-sm text-center">
                                        <button @click="openDetail('Detail Konseling', {
                                            'Tipe Sesi': '{{ $s->session_type }}',
                                            'Tanggal': '{{ \Carbon\Carbon::parse($s->session_date)->format('d F Y') }}',
                                            'Waktu': '{{ \Carbon\Carbon::parse($s->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($s->end_time)->format('H:i') }} WIB',
                                            'Konselor': '{{ $s->counselor->name ?? 'Admin' }}',
                                            'Lokasi': '{{ $s->location ?? 'Ruang BK' }}',
                                            'Catatan Konseling': '{{ addslashes($s->notes) }}'
                                        })" class="inline-flex items-center px-3 py-1.5 bg-sky-500/10 text-sky-400 border border-sky-500/20 rounded-lg hover:bg-sky-500 hover:text-white transition-all text-[10px] font-black uppercase tracking-widest">
                                            Catatan
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-5 py-20 text-center text-gray-600 italic font-bold">
                                        Tidak ada riwayat konseling yang telah diselesaikan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Alpine.js Modal Detail -->
    <div x-show="showModal" 
         class="fixed inset-0 z-[9999] overflow-y-auto" 
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="showModal = false">
                <div class="absolute inset-0 bg-black/90 backdrop-blur-sm"></div>
            </div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-[#0f172a] border border-gray-800 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                
                <!-- Modal Header -->
                <div class="px-6 py-5 border-b border-gray-800 flex justify-between items-center bg-[#1e293b]/50">
                    <h3 class="text-xl font-bold text-white tracking-tight" x-text="modalTitle"></h3>
                    <button @click="showModal = false" class="text-gray-400 hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="px-6 py-6 space-y-4 max-h-[70vh] overflow-y-auto custom-scrollbar bg-[#0f172a]">
                    <template x-for="(value, key) in modalData" :key="key">
                        <div class="bg-[#1e293b] rounded-2xl p-5 border border-gray-800 hover:border-brand-teal/20 transition-colors">
                            <div class="mb-3">
                                <span class="px-3 py-1 rounded-lg bg-brand-teal/10 text-brand-teal text-[10px] font-black uppercase tracking-widest border border-brand-teal/20" x-text="key"></span>
                            </div>
                            <p class="text-sm font-medium text-gray-300 leading-relaxed whitespace-pre-wrap font-sans break-words break-all" x-text="value"></p>
                        </div>
                    </template>
                </div>

                <!-- Modal Footer -->
                <div class="bg-[#1e293b]/50 px-6 py-4 border-t border-gray-800 flex justify-end">
                    <button @click="showModal = false" 
                            class="px-6 py-2 bg-gray-800 text-gray-300 hover:text-white rounded-xl text-xs font-bold uppercase tracking-widest border border-gray-700 hover:bg-gray-700 transition-all">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.02);
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(45, 212, 191, 0.2);
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(45, 212, 191, 0.4);
        }
    </style>
</div>

@endsection
