@extends('layouts.app')

@section('title', 'Daftar Pelanggaran')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6 text-white">⚠️ Daftar Pelanggaran Siswa</h1>

    <div class="flex justify-between items-center mb-6">
        <a href="{{ route('admin.violations.create') }}" 
           class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-300">
            + Catat Pelanggaran Baru
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-500 p-4 rounded-lg mb-6 text-white">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-gray-800 rounded-xl shadow-lg p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr class="text-xs font-semibold tracking-wider text-left text-gray-400 uppercase border-b border-gray-700">
                        <th class="px-5 py-3">No</th>
                        <th class="px-5 py-3">Siswa</th>
                        <th class="px-5 py-3">Kelas</th>
                        <th class="px-5 py-3">Jenis Pelanggaran</th>
                        <th class="px-5 py-3">Poin</th>
                        <th class="px-5 py-3">Tanggal</th>
                        <th class="px-5 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($violations as $violation)
                        <tr class="hover:bg-gray-700 transition duration-150 border-b border-gray-700">
                            <td class="px-5 py-5 text-sm">{{ $loop->iteration }}</td>
                            <td class="px-5 py-5 text-sm font-medium text-white">{{ $violation->student->name ?? 'N/A' }}</td>
                            <td class="px-5 py-5 text-sm">{{ $violation->student->schoolClass->name ?? 'N/A' }}</td>
                            <td class="px-5 py-5 text-sm text-red-400">{{ $violation->rule->name ?? 'Aturan Dihapus' }}</td>
                            <td class="px-5 py-5 text-sm text-red-500 font-bold">{{ $violation->rule->points ?? 0 }}</td>
                            <td class="px-5 py-5 text-sm">{{ \Carbon\Carbon::parse($violation->violation_date)->format('d M Y') }}</td>
                            <td class="px-5 py-5 text-sm space-x-2">
                                <a href="{{ route('admin.violations.edit', $violation) }}" 
                                   class="text-yellow-400 hover:text-yellow-300">Edit</a>
                                <form action="{{ route('admin.violations.destroy', $violation) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-400 hover:text-red-300"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus pelanggaran ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-5 text-center text-gray-400 italic">Belum ada pelanggaran yang dicatat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $violations->links() }}
        </div>
    </div>
</div>
@endsection