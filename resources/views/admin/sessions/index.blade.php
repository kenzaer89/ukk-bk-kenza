@extends('layouts.app')
@section('title', 'Sesi Konseling')

@section('content')
<h1 class="text-2xl font-semibold text-white mb-6">💬 Sesi Konseling</h1>

<div class="mb-4">
    <a href="{{ route('admin.sessions.create') }}" class="btn-primary">+ Tambah Sesi</a>
</div>

<table class="w-full text-gray-300 border-collapse">
    <thead>
        <tr class="text-gray-400 uppercase text-sm border-b border-gray-700">
            <th class="py-3">Siswa</th>
            <th>Topik</th>
            <th>Tanggal</th>
            <th>Hasil</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($sessions as $session)
        <tr class="border-b border-gray-800 hover:bg-white/5">
            <td class="py-2">{{ $session->siswa->name ?? '-' }}</td>
            <td>{{ $session->topik }}</td>
            <td>{{ $session->tanggal }}</td>
            <td class="text-indigo-400">{{ Str::limit($session->hasil, 30) }}</td>
            <td>
                <a href="{{ route('admin.sessions.edit', $session->id) }}" class="btn-primary text-sm">Edit</a>
                <form method="POST" action="{{ route('admin.sessions.destroy', $session->id) }}" class="inline">
                    @csrf @method('DELETE')
                    <button onclick="return confirm('Hapus sesi ini?')" class="text-sm bg-rose-600 py-1 px-3 rounded-lg hover:opacity-90">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
