@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto p-6 bg-gray-800 rounded-2xl shadow-lg text-white">
<h2 class="text-2xl font-semibold mb-6 text-center">Tambah Jadwal Konseling</h2>

{{-- Tampilkan error ringkasan jika ada --}}
@if ($errors->any())
    <div class="mb-4 p-3 bg-red-800 text-red-100 rounded-lg border border-red-700">
        <p class="font-bold">Ada Kesalahan:</p>
        <ul class="mt-1 list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.schedules.store') }}" method="POST" class="space-y-4">
    @csrf

    <div>
        <label for="scheduled_date" class="block mb-1 font-medium">Tanggal</label>
        <input type="date" id="scheduled_date" name="scheduled_date"
               class="w-full p-2 rounded-lg bg-gray-700 border @error('scheduled_date') border-red-500 @else border-gray-600 @enderror"
               value="{{ old('scheduled_date') }}" required>
        @error('scheduled_date')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="topic" class="block mb-1 font-medium">Topik</label>
        <input type="text" id="topic" name="topic"
               class="w-full p-2 rounded-lg bg-gray-700 border @error('topic') border-red-500 @else border-gray-600 @enderror"
               value="{{ old('topic') }}" placeholder="Masukkan topik konseling">
        @error('topic')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="student_name" class="block mb-1 font-medium">Nama Siswa</label>
        <input type="text" id="student_name" name="student_name"
               class="w-full p-2 rounded-lg bg-gray-700 border @error('student_name') border-red-500 @else border-gray-600 @enderror"
               value="{{ old('student_name') }}" placeholder="Ketik nama siswa secara manual" required>
        @error('student_name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="teacher_id" class="block mb-1 font-medium">Guru BK</label>
        <select id="teacher_id" name="teacher_id"
                class="w-full p-2 rounded-lg bg-gray-700 border @error('teacher_id') border-red-500 @else border-gray-600 @enderror">
            <option value="">-- Pilih Guru BK --</option>
            @foreach ($teachers as $teacher)
                <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                    {{ $teacher->name }}
                </option>
            @endforeach
        </select>
        @error('teacher_id')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label for="start_time" class="block mb-1 font-medium">Waktu Mulai</label>
            <input type="time" id="start_time" name="start_time"
                    class="w-full p-2 rounded-lg bg-gray-700 border @error('start_time') border-red-500 @else border-gray-600 @enderror"
                    value="{{ old('start_time') }}" required>
            @error('start_time')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="end_time" class="block mb-1 font-medium">Waktu Selesai</label>
            <input type="time" id="end_time" name="end_time"
                    class="w-full p-2 rounded-lg bg-gray-700 border @error('end_time') border-red-500 @else border-gray-600 @enderror"
                    value="{{ old('end_time') }}">
            @error('end_time')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
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