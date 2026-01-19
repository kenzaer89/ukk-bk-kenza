@extends('layouts.app')

@section('title', 'Daftar Aturan Pelanggaran')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6 text-white">📜 Data Master Aturan Pelanggaran</h1>

    <div class="flex justify-between items-center mb-6">
        <a href="{{ route('admin.rules.create') }}" 
           class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-300">
            + Tambah Aturan Baru
        </a>
    </div>




    <div class="bg-gray-800 rounded-xl shadow-lg p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr class="text-xs font-semibold tracking-wider text-left text-gray-400 uppercase border-b border-gray-700">
                        <th class="px-5 py-3">Aturan Pelanggaran</th>
                        <th class="px-5 py-3 text-center">Poin Dikurangi</th>
                        <th class="px-5 py-3">Kategori</th>
                        <th class="px-5 py-3">Deskripsi Singkat</th>
                        <th class="px-5 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rules as $rule)
                        <tr class="hover:bg-gray-700 transition duration-150 border-b border-gray-700">
                            <td class="px-5 py-5 text-sm font-medium text-white">{{ $rule->name }}</td>
                            <td class="px-5 py-5 text-sm font-bold text-red-500 text-center">{{ $rule->points }}</td>
                            <td class="px-5 py-5 text-sm">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $rule->category == 'Berat' ? 'bg-red-800 text-red-100' : 
                                       ($rule->category == 'Sedang' ? 'bg-yellow-700 text-yellow-100' : 'bg-green-700 text-green-100') }}">
                                    {{ $rule->category ?? 'Lainnya' }}
                                </span>
                            </td>
                            <td class="px-5 py-5 text-sm text-gray-400 italic">{{ Str::limit($rule->description, 50) }}</td>
                            <td class="px-5 py-5 text-sm space-x-2">
                                <a href="{{ route('admin.rules.edit', $rule) }}" 
                                   class="text-yellow-400 hover:text-yellow-300">Edit</a>
                                <form action="{{ route('admin.rules.destroy', $rule) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-400 hover:text-red-300"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus aturan ini? Semua catatan pelanggaran terkait harus diperiksa.')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-5 text-center text-gray-400 italic">Belum ada aturan pelanggaran yang dicatat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $rules->links() }}
        </div>
    </div>
</div>
@endsection