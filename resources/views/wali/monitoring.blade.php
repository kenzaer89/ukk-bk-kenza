@extends('layouts.app')

@section('title', 'Monitoring Siswa')

@section('content')
<div class="p-6">
    @if (!$class)
        <div class="bg-yellow-500/10 border border-yellow-500/30 rounded-2xl p-8 text-center">
            <div class="w-20 h-20 bg-yellow-500/20 rounded-full flex items-center justify-center mx-auto mb-4 text-yellow-400 text-4xl">
                ⚠️
            </div>
            <h2 class="text-2xl font-bold text-white mb-2">Akses Terbatas</h2>
            <p class="text-gray-400">
                Anda belum ditugaskan sebagai Wali Kelas untuk kelas manapun. Silakan hubungi Administrator.
            </p>
        </div>
    @else
        <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <span class="text-indigo-400 font-semibold uppercase tracking-widest text-xs">Monitoring Siswa</span>
                <h1 class="text-3xl font-bold text-white mt-1 flex items-center gap-3">
                    <span class="p-2 bg-indigo-500/20 rounded-lg">
                        <svg class="w-8 h-8 text-brand-teal" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </span>
                    {{ $class->name }} <span class="text-gray-500 font-medium">| Student List</span>
                </h1>
                <p class="text-gray-400 mt-2 flex items-center gap-2 text-sm">
                    <span class="w-1.5 h-1.5 bg-brand-teal rounded-full animate-pulse"></span>
                    Pantau poin kedisiplinan dan data siswa kelas Anda.
                </p>
            </div>
        </div>

        <!-- Monitoring Table -->
        <div class="bg-gray-800/50 backdrop-blur-xl border border-gray-700/50 rounded-3xl shadow-2xl overflow-hidden">
            <div class="p-6 border-b border-gray-700/50 flex items-center justify-between">
                <h2 class="text-xl font-bold text-white flex items-center gap-3">
                    <span class="p-2 bg-brand-teal/20 rounded-lg text-brand-teal">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </span>
                    Monitoring Poin Kedisiplinan
                </h2>
                <span class="text-xs text-gray-500 italic">Diurutkan dari poin terendah</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-900/50">
                            <th class="px-6 py-4 text-[10px] font-semibold text-gray-500 uppercase tracking-widest leading-none">Absen</th>
                            <th class="px-6 py-4 text-[10px] font-semibold text-gray-500 uppercase tracking-widest leading-none">Identitas Siswa</th>
                            <th class="px-6 py-4 text-[10px] font-semibold text-gray-500 uppercase tracking-widest leading-none text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700/30">
                        @forelse ($students as $student)
                            <tr class="group hover:bg-gray-700/20 transition-colors">
                                <td class="px-6 py-4 text-gray-400 font-mono text-sm leading-none">{{ str_pad($student->absen ?? '0', 2, '0', STR_PAD_LEFT) }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-indigo-500/20 flex items-center justify-center text-indigo-400 border border-indigo-500/30 font-bold text-xs">
                                            {{ substr($student->name, 0, 1) }}
                                        </div>
                                        <div class="leading-none">
                                            <span class="text-white font-bold block">{{ $student->name }}</span>
                                            <span class="text-[10px] text-gray-500 font-mono">{{ $student->email }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('wali.monitoring.show', $student) }}" class="inline-flex items-center gap-2 px-3 py-1.5 bg-brand-teal/10 hover:bg-brand-teal text-brand-teal hover:text-brand-dark rounded-xl border border-brand-teal/20 transition-all font-semibold text-[10px] uppercase tracking-widest">
                                        Detail
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-12 text-center text-gray-500 italic">Belum ada data siswa.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection
