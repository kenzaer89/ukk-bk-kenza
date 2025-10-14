@extends('layouts.app')
@section('title', 'Jadwal Konseling')

@section('content')
<h1 class="text-2xl font-semibold text-white mb-6">📅 Jadwal Konseling</h1>

<div class="mb-4">
    <a href="{{ route('admin.schedules.create') }}" class="btn-primary">+ Tambah Jadwal</a>
</div>

<div class="overflow-x-auto">
    <table class="w-full text-gray-300 border-collapse">
        <thead>
            <tr class="text-gray-400 uppercase text-sm border-b border-gray-700">
                <th class="py-3">Tanggal</th>
                <th>Topik</th>
                <th>Siswa</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($schedules as $schedule)
            <tr class="border-b border-gray-800 hover:bg-white/5">
                <td class="py-2">{{ $schedule->tanggal }}</td>
                <td>{{ $schedule->topik }}</td>
                <td>{{ $schedule->siswa->name ?? '-' }}</td>
                <td><span class="text-indigo-400">{{ $schedule->status }}</span></td>
                <td class="space-x-2">
                    <a href="{{ route('admin.schedules.edit', $schedule->id) }}" class="btn-primary text-sm">Edit</a>
                    <form action="{{ route('admin.schedules.destroy', $schedule->id) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Hapus jadwal ini?')" class="text-sm bg-rose-600 py-1 px-3 rounded-lg hover:opacity-90">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
