@extends('layouts.app')

@section('title', 'Daftar Topik Konseling')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6 text-white">Data Master Topik Konseling</h1>

    <div class="flex justify-between items-center mb-6">
        <a href="{{ route('admin.topics.create') }}" 
           class="bg-brand-teal hover:bg-brand-teal/90 text-brand-dark font-bold py-2 px-6 rounded-lg transition-all duration-300 shadow-[0_0_20px_rgba(45,212,191,0.2)]">
            + Tambah Topik Baru
        </a>
    </div>



    <div class="bg-gray-800 rounded-xl shadow-lg p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr class="text-xs font-semibold tracking-wider text-left text-gray-400 uppercase border-b border-gray-700">
                        <th class="px-5 py-3">Nama Topik</th>
                        <th class="px-5 py-3">Deskripsi</th>
                        <th class="px-5 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($topics as $topic)
                        <tr class="hover:bg-gray-700 transition duration-150 border-b border-gray-700">
                            <td class="px-5 py-5 text-sm font-medium text-white">{{ $topic->name }}</td>
                            <td class="px-5 py-5 text-sm text-gray-400">{{ $topic->description ?? '-' }}</td>
                            <td class="px-5 py-5 text-sm space-x-2">
                                <a href="{{ route('admin.topics.edit', $topic) }}" 
                                   class="text-yellow-400 hover:text-yellow-300">Edit</a>
                                <form action="{{ route('admin.topics.destroy', $topic) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-400 hover:text-red-300"
                                            onclick="return confirmAction(event, 'Hapus Topik', 'Hapus topik ini? Pastikan tidak ada sesi yang menggunakannya.', 'warning', 'Ya, Hapus')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-5 py-5 text-center text-gray-400 italic">Belum ada topik konseling yang dicatat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $topics->links() }}
        </div>
    </div>
</div>
@endsection