@extends('layouts.app')

@section('title', 'Tingkat Poin Pelanggaran')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6 text-white">⚠️ Ambang Batas Poin & Tindakan</h1>

    <div class="flex justify-between items-center mb-6">
        <a href="{{ route('admin.point_levels.create') }}" 
           class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-300">
            + Tambah Ambang Batas Baru
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
                        <th class="px-5 py-3 text-center">Batas Poin (Threshold)</th>
                        <th class="px-5 py-3">Tindakan/Konsekuensi</th>
                        <th class="px-5 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($levels as $level)
                        <tr class="hover:bg-gray-700 transition duration-150 border-b border-gray-700">
                            <td class="px-5 py-5 text-sm font-bold text-red-500 text-center">
                                {{ $level->point_threshold }} Poin
                            </td>
                            <td class="px-5 py-5 text-sm text-white">
                                {{ $level->action }}
                            </td>
                            <td class="px-5 py-5 text-sm space-x-2">
                                <a href="{{ route('admin.point_levels.edit', $level) }}" 
                                   class="text-yellow-400 hover:text-yellow-300">Edit</a>
                                <form action="{{ route('admin.point_levels.destroy', $level) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-400 hover:text-red-300"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus ambang batas ini? Pastikan tidak ada data yang bergantung pada ini.')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-5 py-5 text-center text-gray-400 italic">Belum ada ambang batas poin yang dicatat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $levels->links() }}
        </div>
    </div>
</div>
@endsection