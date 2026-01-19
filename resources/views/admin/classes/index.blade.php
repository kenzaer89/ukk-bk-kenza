@extends('layouts.app')

@section('title', 'Daftar Kelas')

@section('content')
<div class="p-6">
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-white flex items-center gap-3">
                <span class="p-2 bg-indigo-500/20 rounded-lg">
                    <svg class="w-8 h-8 text-brand-teal" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </span>
                Data Master Kelas
            </h1>
            <p class="text-gray-400 mt-1">Manajemen data kelas, jurusan, dan wali kelas.</p>
        </div>
        
        <div class="flex flex-col sm:flex-row items-center gap-4">
            <form action="{{ route('admin.classes.index') }}" method="GET" class="relative group w-full sm:w-64">
                <input type="text" name="search" value="{{ request('search') }}" 
                    placeholder="Cari kelas..." 
                    class="w-full bg-gray-900/50 border border-gray-700/50 text-white text-sm rounded-xl px-4 py-3 pl-10 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 outline-none group-hover:bg-gray-800/80">
                <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 group-hover:text-indigo-400 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </form>

            <a href="{{ route('admin.classes.create') }}" 
               class="w-full sm:w-auto group relative inline-flex items-center justify-center px-6 py-3 font-bold text-brand-dark transition-all duration-200 bg-brand-teal font-pj rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-teal hover:bg-brand-teal/90 shadow-lg shadow-brand-teal/30">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Kelas Baru
            </a>
        </div>
    </div>



    <div class="relative overflow-hidden bg-gray-800/50 backdrop-blur-xl border border-gray-700/50 rounded-2xl shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-900/50">
                        <th class="px-6 py-4 text-sm font-semibold text-gray-400 uppercase tracking-wider border-b border-gray-700">Nama Kelas</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-400 uppercase tracking-wider border-b border-gray-700">Jurusan</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-400 uppercase tracking-wider border-b border-gray-700">Wali Kelas</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-400 uppercase tracking-wider border-b border-gray-700 text-center">Total Siswa</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-400 uppercase tracking-wider border-b border-gray-700 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700/50">
                    @forelse ($classes as $class)
                        <tr class="group hover:bg-gray-700/30 transition-colors duration-200">
                            <td class="px-6 py-4">
                                <span class="text-white font-bold text-base">{{ $class->name }}</span>
                            </td>
                            <td class="px-6 py-4 text-gray-300">
                                <span class="font-medium text-brand-teal">{{ strtoupper($class->jurusan ?? '-') }}</span>
                                <span class="text-xs text-gray-400 block">{{ $class->jurusan_full_name }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-indigo-500/20 flex items-center justify-center text-indigo-400 font-bold text-xs">
                                        {{ substr($class->waliKelas->name ?? '?', 0, 1) }}
                                    </div>
                                    <span class="text-sky-400 font-medium">{{ $class->waliKelas->name ?? 'Belum Ditentukan' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center justify-center px-3 py-1 text-sm font-bold leading-none text-emerald-400 bg-emerald-400/10 rounded-full border border-emerald-400/20">
                                    {{ $class->students_count ?? $class->students->count() }} Siswa
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-3 transition-opacity duration-200">
                                    <a href="{{ route('admin.classes.show', $class) }}" 
                                       class="p-2 text-indigo-400 hover:bg-indigo-400/10 rounded-lg transition-colors"
                                       title="Lihat Siswa">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.classes.edit', $class) }}" 
                                       class="p-2 text-yellow-400 hover:bg-yellow-400/10 rounded-lg transition-colors"
                                       title="Edit Kelas">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.classes.destroy', $class) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="p-2 text-red-400 hover:bg-red-400/10 rounded-lg transition-colors"
                                                onclick="return confirmAction(event, 'Hapus Kelas', 'Apakah Anda yakin ingin menghapus kelas ini? Perkembangan ini tidak dapat dibatalkan.', 'warning', 'Ya, Hapus')"
                                                title="Hapus Kelas">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <svg class="w-16 h-16 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                    @if(request('search'))
                                        <p class="text-gray-500 text-lg">Tidak ada kelas yang cocok dengan kata kunci "{{ request('search') }}".</p>
                                        <a href="{{ route('admin.classes.index') }}" class="text-indigo-400 hover:underline font-semibold mt-2">Hapus pencarian</a>
                                    @else
                                        <p class="text-gray-500 text-lg">Belum ada data kelas yang dicatat.</p>
                                        <a href="{{ route('admin.classes.create') }}" class="text-indigo-400 hover:underline font-semibold mt-2">Tambah kelas pertama Anda</a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($classes->hasPages())
            <div class="px-6 py-4 bg-gray-900/30 border-t border-gray-700/50">
                {{ $classes->links() }}
            </div>
        @endif
    </div>
</div>

<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fade-in 0.3s ease-out forwards;
    }
</style>
@endsection