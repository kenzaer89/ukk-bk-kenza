@extends('layouts.app')

@section('title', 'Daftar Prestasi Siswa')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6 text-white flex items-center gap-3">
        <span class="p-2 bg-indigo-500/20 rounded-lg">
            <svg class="w-8 h-8 text-brand-teal" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
            </svg>
        </span>
        Data Master Prestasi Siswa
    </h1>

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <!-- Search Form -->
        <form method="GET" action="{{ route('admin.achievements.index') }}" class="flex-1 max-w-md">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}"
                    placeholder="Cari nama siswa, prestasi, atau tingkat..." 
                    class="w-full bg-gray-800/50 border border-gray-700 rounded-lg pl-11 pr-10 py-2.5 text-white placeholder-gray-500 focus:ring-2 focus:ring-brand-teal focus:border-transparent transition-all outline-none"
                >
                @if(request('search'))
                    <a href="{{ route('admin.achievements.index') }}" class="absolute inset-y-0 right-0 flex items-center pr-3">
                        <svg class="w-5 h-5 text-gray-400 hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </a>
                @endif
            </div>
        </form>

        <!-- Create Button -->
        <a href="{{ route('admin.achievements.create') }}" 
           class="bg-brand-teal hover:bg-brand-teal/90 text-brand-dark font-bold py-2.5 px-6 rounded-lg transition-all duration-300 shadow-[0_0_20px_rgba(45,212,191,0.2)] whitespace-nowrap">
            + Catat Prestasi Baru
        </a>
    </div>



    @if(request('search'))
        <div class="bg-brand-gray/50 border border-brand-teal/30 rounded-lg p-4 mb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-brand-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <p class="text-brand-light">
                        Menampilkan <span class="font-bold text-brand-teal">{{ $achievements->total() }}</span> hasil untuk 
                        <span class="font-bold text-brand-teal">"{{ request('search') }}"</span>
                    </p>
                </div>
                <a href="{{ route('admin.achievements.index') }}" class="text-brand-light/60 hover:text-brand-teal transition-colors text-sm font-medium">
                    Hapus Filter
                </a>
            </div>
        </div>
    @endif

    <div class="bg-gray-800 rounded-xl shadow-lg p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr class="text-xs font-semibold tracking-wider text-left text-gray-400 uppercase border-b border-gray-700">
                        <th class="px-5 py-3">Siswa</th>
                        <th class="px-5 py-3">Nama Prestasi</th>
                        <th class="px-5 py-3">Tingkat</th>
                        <th class="px-5 py-3">Poin</th>
                        <th class="px-5 py-3">Tanggal</th>
                        <th class="px-5 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($achievements as $achievement)
                        <tr class="hover:bg-gray-700 transition duration-150 border-b border-gray-700">
                            <td class="px-5 py-5 text-sm font-medium text-white">
                                {{ $achievement->student->name ?? 'Siswa Terhapus' }}
                                <span class="text-xs text-gray-400 block">{{ $achievement->student->schoolClass->name ?? '-' }}</span>
                            </td>
                            <td class="px-5 py-5 text-sm">{{ $achievement->name }}</td>
                            <td class="px-5 py-5 text-sm capitalize">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-700 text-blue-100">
                                    {{ $achievement->level }}
                                </span>
                            </td>
                            <td class="px-5 py-5 text-sm font-bold text-green-400">+{{ $achievement->point }}</td>
                            <td class="px-5 py-5 text-sm">{{ $achievement->achievement_date ? $achievement->achievement_date->format('d M Y') : '-' }}</td>
                            <td class="px-5 py-5 text-sm">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.achievements.edit', $achievement) }}" 
                                       class="inline-flex items-center px-3 py-1 bg-yellow-600/20 text-yellow-500 border border-yellow-500/50 rounded-md hover:bg-yellow-600 hover:text-white transition text-xs font-bold">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.achievements.destroy', $achievement) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center px-3 py-1 bg-red-600/10 text-red-500 border border-red-600/30 rounded-md hover:bg-red-600 hover:text-white transition text-xs font-bold"
                                                onclick="return confirmAction(event, 'Hapus Prestasi', 'Apakah Anda yakin ingin menghapus catatan prestasi ini?', 'warning', 'Ya, Hapus')">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-5 text-center text-gray-400 italic">Belum ada prestasi siswa yang dicatat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $achievements->links() }}
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto-submit search with debounce
    const searchInput = document.querySelector('input[name="search"]');
    let debounceTimer;
    
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                this.form.submit();
            }, 500); // Wait 500ms after user stops typing
        });
    }
</script>
@endpush
@endsection