@extends('layouts.app')

@section('title', 'Daftar Kelas')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6 text-white">🏢 Data Master Kelas</h1>

    <div class="flex justify-between items-center mb-6">
        <a href="{{ route('admin.classes.create') }}" 
           class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-300">
            + Tambah Kelas Baru
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-500 p-4 rounded-lg mb-6 text-white">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="bg-red-500 p-4 rounded-lg mb-6 text-white">{{ session('error') }}</div>
    @endif

    <div class="bg-gray-800 rounded-xl shadow-lg p-6">
        <table class="min-w-full leading-normal">
            <thead>
                <tr class="text-xs font-semibold tracking-wider text-left text-gray-400 uppercase border-b border-gray-700">
                    <th class="px-5 py-3">Nama Kelas</th>
                    <th class="px-5 py-3">Jurusan</th>
                    <th class="px-5 py-3">Wali Kelas</th>
                    <th class="px-5 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($classes as $class)
                    <tr class="hover:bg-gray-700 transition duration-150 border-b border-gray-700">
                        <td class="px-5 py-5 text-sm font-medium text-white">{{ $class->name }}</td>
                        <td class="px-5 py-5 text-sm">{{ $class->jurusan ?? '-' }}</td>
                        <td class="px-5 py-5 text-sm text-sky-400">{{ $class->waliKelas->name ?? 'Belum Ditentukan' }}</td>
                        <td class="px-5 py-5 text-sm space-x-2">
                            <a href="{{ route('admin.classes.edit', $class) }}" 
                               class="text-yellow-400 hover:text-yellow-300">Edit</a>
                            <form action="{{ route('admin.classes.destroy', $class) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="text-red-400 hover:text-red-300"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus kelas ini? Tindakan ini tidak dapat dibatalkan.')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-5 py-5 text-center text-gray-400 italic">Belum ada data kelas yang dicatat.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">{{ $classes->links() }}</div>
    </div>
</div>
@endsection