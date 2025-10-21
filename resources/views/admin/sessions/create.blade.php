@extends('layouts.app')

@section('title', 'Tambah Sesi Konseling')

@section('content')
<h1 class="text-2xl font-semibold text-white mb-6">Tambah Sesi Konseling</h1>

<form method="POST" action="{{ route('admin.sessions.store') }}" class="space-y-4">
    @csrf

    <div>
        <label class="block text-gray-300 mb-1">Pilih Jadwal Konseling</label>
        <select name="schedule_id" class="w-full glass p-2 rounded text-white" required>
            @foreach($schedules as $schedule)
                <option value="{{ $schedule->id }}">
                    {{ $schedule->student->name }} - {{ $schedule->scheduled_date }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-gray-300 mb-1">Tanggal Sesi</label>
        <input type="date" name="session_date" class="w-full glass p-2 rounded text-white" required>
    </div>

    <div>
        <label class="block text-gray-300 mb-1">Catatan Guru BK</label>
        <textarea name="teacher_notes" rows="4" class="w-full glass p-2 rounded text-white" required></textarea>
    </div>

    <div>
        <label class="block text-gray-300 mb-1">Rekomendasi Tindak Lanjut</label>
        <textarea name="recommendations" rows="4" class="w-full glass p-2 rounded text-white"></textarea>
    </div>

    <button type="submit" class="btn-primary mt-4">Simpan</button>
</form>
@endsection
