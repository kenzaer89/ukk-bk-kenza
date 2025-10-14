@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-gray-800 rounded-2xl shadow-lg text-white">
    <h2 class="text-2xl font-semibold mb-6 text-center">Tambah Jadwal Konseling</h2>

    <form action="{{ route('admin.schedules.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label for="scheduled_date" class="block mb-1 font-medium">Tanggal</label>
            <input type="date" id="scheduled_date" name="scheduled_date"
                   class="w-full p-2 rounded-lg bg-gray-700 border border-gray-600"
                   value="{{ old('scheduled_date') }}" required>
        </div>

        <div>
            <label for="topic" class="block mb-1 font-medium">Topik</label>
            <input type="text" id="topic" name="topic"
                   class="w-full p-2 rounded-lg bg-gray-700 border border-gray-600"
                   value="{{ old('topic') }}" placeholder="Masukkan topik konseling">
        </div>

        <div>
            <label for="student_name" class="block mb-1 font-medium">Nama Siswa</label>
            <input type="text" id="student_name" name="student_name"
                   class="w-full p-2 rounded-lg bg-gray-700 border border-gray-600"
                   value="{{ old('student_name') }}" placeholder="Ketik nama siswa secara manual" required>
        </div>

        <div>
            <label for="teacher_id" class="block mb-1 font-medium">Guru BK</label>
            <select id="teacher_id" name="teacher_id"
                    class="w-full p-2 rounded-lg bg-gray-700 border border-gray-600">
                <option value="">-- Pilih Guru BK --</option>
                @foreach ($teachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                        {{ $teacher->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="start_time" class="block mb-1 font-medium">Waktu Mulai</label>
                <input type="time" id="start_time" name="start_time"
                       class="w-full p-2 rounded-lg bg-gray-700 border border-gray-600"
                       value="{{ old('start_time') }}" required>
            </div>
            <div>
                <label for="end_time" class="block mb-1 font-medium">Waktu Selesai</label>
                <input type="time" id="end_time" name="end_time"
                       class="w-full p-2 rounded-lg bg-gray-700 border border-gray-600"
                       value="{{ old('end_time') }}">
            </div>
        </div>

        <div class="text-center mt-6">
            <button type="submit"
                    class="bg-purple-600 hover:bg-purple-700 px-6 py-2 rounded-lg font-semibold">
                Simpan
            </button>
            <a href="{{ route('admin.schedules.index') }}"
               class="ml-3 bg-gray-600 hover:bg-gray-700 px-6 py-2 rounded-lg font-semibold">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
