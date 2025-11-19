@extends('layouts.app')

@section('title', 'Laporan Bulanan Guru BK')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6 text-white">📑 Laporan Bulanan Guru BK</h1>

    <div class="flex justify-between items-center mb-6">
        <a href="{{ route('admin.monthly_reports.create') }}" 
           class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-300">
            + Buat Laporan Baru
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
                        <th class="px-5 py-3">Bulan & Tahun</th>
                        <th class="px-5 py-3">Penyusun</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reports as $report)
                        <tr class="hover:bg-gray-700 transition duration-150 border-b border-gray-700">
                            <td class="px-5 py-5 text-sm font-medium text-white">
                                {{ $report->report_date->isoFormat('MMMM Y') }}
                            </td>
                            <td class="px-5 py-5 text-sm text-gray-300">{{ $report->teacher->name ?? 'N/A' }}</td>
                            <td class="px-5 py-5 text-sm capitalize">
                                @php
                                    $statusClass = $report->status === 'submitted' ? 'bg-green-600' : 'bg-yellow-600';
                                @endphp
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }} text-white">
                                    {{ $report->status }}
                                </span>
                            </td>
                            <td class="px-5 py-5 text-sm space-x-2 flex">
                                <a href="{{ route('admin.monthly_reports.show', $report) }}" 
                                   class="text-blue-400 hover:text-blue-300">Lihat Detail</a>
                                <a href="{{ route('admin.monthly_reports.edit', $report) }}" 
                                   class="text-yellow-400 hover:text-yellow-300">Edit</a>
                                <form action="{{ route('admin.monthly_reports.destroy', $report) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-400 hover:text-red-300"
                                            onclick="return confirm('Hapus laporan bulanan ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-5 text-center text-gray-400 italic">Belum ada laporan bulanan yang dicatat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $reports->links() }}
        </div>
    </div>
</div>
@endsection