@extends('layouts.app')
@section('title', 'Edit Jadwal Konseling')

@section('content')
<h1 class="text-2xl font-semibold text-white mb-6">Edit Jadwal Konseling</h1>

<form method="POST" action="{{ route('admin.schedules.update', $schedule->id) }}" class="space-y-4">
    @csrf @method('PUT')
    <div>
        <label class="block text-gray-300">Tanggal</label>
        <input type="date" name="tanggal" value="{{ $schedule->tanggal }}" class="w-full glass p-2 rounded text-white">
    </div>
    <div>
        <label class="block text-gray-300">Topik</label>
        <input type="text" name="topik" value="{{ $schedule->topik }}" class="w-full glass p-2 rounded text-white">
    </div>
    <div>
        <label class="block text-gray-300">Status</label>
        <select name="status" class="w-full glass p-2 rounded text-white">
            <option value="Terjadwal" {{ $schedule->status == 'Terjadwal' ? 'selected' : '' }}>Terjadwal</option>
            <option value="Selesai" {{ $schedule->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
        </select>
    </div>
    <button type="submit" class="btn-primary">Update</button>
</form>
@endsection
