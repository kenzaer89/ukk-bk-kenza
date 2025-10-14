@extends('layouts.app')
@section('title', 'Data Pelanggaran')

@section('content')
<h1 class="text-2xl font-semibold text-white mb-6">⚠️ Data Pelanggaran</h1>

<a href="{{ route('admin.violations.create') }}" class="btn-primary mb-4 inline-block">+ Tambah Pelanggaran</a>

<table class="w-full text-gray-300 border-collapse">
    <thead>
        <tr class="text-gray-400 uppercase text-sm border-b border-gray-700">
            <th class="py-3">Tanggal</th>
            <th>Siswa</th>
            <th>Jenis Pelanggaran</th>
            <th>Tingkat</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($violations as $v)
        <tr class="border-b border-gray-800 hover:bg-white/5">
            <td class="py-2">{{ $v->tanggal }}</td>
            <td>{{ $v->siswa->name ?? '-' }}</td>
            <td>{{ $v->jenis }}</td>
            <td class="text-rose-400">{{ $v->tingkat }}</td>
            <td>
                <a href="{{ route('admin.violations.edit', $v->id) }}" class="btn-primary text-sm">Edit</a>
                <form method="POST" action="{{ route('admin.violations.destroy', $v->id) }}" class="inline">
                    @csrf @method('DELETE')
                    <button onclick="return confirm('Hapus data ini?')" class="text-sm bg-rose-600 py-1 px-3 rounded-lg hover:opacity-90">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
