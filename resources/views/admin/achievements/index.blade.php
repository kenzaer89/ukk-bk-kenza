@extends('layouts.app')

@section('title', 'Daftar Prestasi Siswa')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6 text-white">🏆 Data Master Prestasi Siswa</h1>

    <div class="flex justify-between items-center mb-6">
        <a href="{{ route('admin.achievements.create') }}" 
           class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-300">
            + Catat Prestasi Baru
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-500 p-4 rounded-lg mb-6 text-white">{{ session('success') }}</div>
    @endif

    <div class="bg-gray-800 rounded-xl shadow-lg p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr class="text-xs font-semibold tracking-wider text-left text-gray-400 uppercase border-b border-gray-700">
                        <th class="px-5 py-3">Siswa</th>
                        <th class="px-5 py-3">Nama Prestasi</th>
                        <th class="px-5 py-3">Tingkat</th>
                        <th class="px-5 py-3">Tanggal</th>
                        <th class="px-5 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($achievements as $achievement)
                        <tr class="hover:bg-gray-700 transition duration-150 border-b border-gray-700">
                            <td class="px-5 py-5 text-sm font-medium text-white">
                                {{ $achievement->student->name ?? 'Siswa Terhapus' }}
                                <span class="text-xs text-gray-400 block">{{ $achievement->student->studentClass->name ?? '-' }}</span>
                            </td>
                            <td class="px-5 py-5 text-sm">{{ $achievement->name }}</td>
                            <td class="px-5 py-5 text-sm capitalize">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-700 text-blue-100">
                                    {{ $achievement->level }}
                                </span>
                            </td>
                            <td class="px-5 py-5 text-sm">{{ $achievement->achievement_date ? $achievement->achievement_date->format('d M Y') : '-' }}</td>
                            <td class="px-5 py-5 text-sm space-x-2">
                                <a href="{{ route('admin.achievements.edit', $achievement) }}" 
                                   class="text-yellow-400 hover:text-yellow-300">Edit</a>
                                <form action="{{ route('admin.achievements.destroy', $achievement) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-400 hover:text-red-300"
                                            onclick="return confirm('Hapus catatan prestasi ini?')">Hapus</button>
                                </form>
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
@endsection