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
                        <th class="px-5 py-3 text-gray-400 font-bold uppercase">NO</th>
                        <th class="px-5 py-3 text-gray-400 font-bold uppercase">SISWA</th>
                        <th class="px-5 py-3 text-gray-400 font-bold uppercase">KELAS</th>
                        <th class="px-5 py-3 text-gray-400 font-bold uppercase">JENIS PELANGGARAN</th>
                        <th class="px-5 py-3 text-gray-400 font-bold uppercase">POIN</th>
                        <th class="px-5 py-3 text-gray-400 font-bold uppercase">STATUS</th>
                        <th class="px-5 py-3 text-gray-400 font-bold uppercase">TANGGAL</th>
                        <th class="px-5 py-3 text-gray-400 font-bold uppercase">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($violations as $violation)
                        <tr class="hover:bg-gray-700 transition duration-150 border-b border-gray-700">
                            <td class="px-5 py-5 text-sm">{{ $loop->iteration }}</td>
                            <td class="px-5 py-5 text-sm font-medium text-white">{{ $violation->student->name ?? 'N/A' }}</td>
                            <td class="px-5 py-5 text-sm">{{ $violation->student->schoolClass->name ?? 'N/A' }}</td>
                            <td class="px-5 py-5 text-sm text-red-400 font-medium">{{ $violation->rule->name ?? 'Aturan Dihapus' }}</td>
                            <td class="px-5 py-5 text-sm text-red-500 font-bold">{{ $violation->rule->points ?? 0 }}</td>
                            <td class="px-5 py-5 text-sm">
                                @if($violation->status == 'resolved')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-green-500/20 text-green-500">
                                        Selesai
                                    </span>
                                @elseif($violation->status == 'pending')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-yellow-500/20 text-yellow-500">
                                        Menunggu
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-gray-500/20 text-brand-light">
                                        {{ ucfirst($violation->status) }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-5 text-sm">{{ \Carbon\Carbon::parse($violation->violation_date)->format('d M Y') }}</td>
                            <td class="px-5 py-5 text-sm">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.violations.edit', $violation) }}" 
                                       class="inline-flex items-center px-3 py-1 bg-yellow-600/20 text-yellow-500 border border-yellow-500/50 rounded-md hover:bg-yellow-600 hover:text-white transition text-xs font-bold">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.violations.destroy', $violation) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center px-3 py-1 bg-red-600/10 text-red-500 border border-red-600/30 rounded-md hover:bg-red-600 hover:text-white transition text-xs font-bold"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus pelanggaran ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
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