@extends('layouts.app')
@section('title', 'Laporan Bulanan')

@section('content')
<h1 class="text-2xl font-semibold text-white mb-6">📊 Laporan Bulanan</h1>

<a href="{{ route('admin.reports.create') }}" class="btn-primary mb-4 inline-block">+ Buat Laporan Baru</a>

<table class="w-full text-gray-300 border-collapse">
    <thead>
        <tr class="text-gray-400 uppercase text-sm border-b border-gray-700">
            <th class="py-3">Bulan</th>
            <th>Tahun</th>
            <th>Total Sesi</th>
            <th>Tindakan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($reports as $r)
        <tr class="border-b border-gray-800 hover:bg-white/5">
            <td class="py-2">{{ $r->bulan }}</td>
            <td>{{ $r->tahun }}</td>
            <td class="text-indigo-400">{{ $r->total_sesi }}</td>
            <td>{{ Str::limit($r->tindakan, 40) }}</td>
            <td>
                <a href="{{ route('admin.reports.show', $r->id) }}" class="btn-primary text-sm">Lihat</a>
                <a href="{{ route('admin.reports.edit', $r->id) }}" class="btn-primary text-sm">Edit</a>
                <form method="POST" action="{{ route('admin.reports.destroy', $r->id) }}" class="inline">
                    @csrf @method('DELETE')
                    <button onclick="return confirm('Hapus laporan ini?')" class="text-sm bg-rose-600 py-1 px-3 rounded-lg hover:opacity-90">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
