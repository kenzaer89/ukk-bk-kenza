@extends('layouts.app')

@section('title', 'Buat Jadwal Konseling')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6 text-white">
        {{ $requestData ? 'Jadwalkan Permintaan #' . $requestData->id : 'Buat Jadwal Konseling Baru' }}
    </h1>

    @if ($requestData)
        <div class="bg-indigo-900/50 p-4 rounded-lg mb-6 border-l-4 border-indigo-500">
            <p class="font-bold text-indigo-300">Dari Permintaan Siswa:</p>
            <p class="text-white">Siswa: {{ $requestData->student->name }}</p>
            <p class="text-white">Alasan: {{ Str::limit($requestData->reason, 100) }}</p>
            <input type="hidden" name="counseling_request_id" value="{{ $requestData->id }}">
        </div>
    @endif

    <div class="bg-gray-800 rounded-xl shadow-lg p-8 max-w-3xl">
        <form action="{{ route('admin.schedules.store') }}" method="POST" class="space-y-6">
            @csrf
            
            {{-- Hidden field jika ada request_id --}}
            @if ($requestData)
                <input type="hidden" name="counseling_request_id" value="{{ $requestData->id }}">
            @endif

            <div>
                <label for="student_id" class="block text-sm font-medium text-gray-300 mb-2">Pilih Siswa</label>
                <select name="student_id" id="student_id" required {{ $requestData ? 'disabled' : '' }}
                        class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm text-white">
                    <option value="">-- Pilih Siswa --</option>
                    @foreach ($students as $student)
                        <option value="{{ $student->id }}" 
                            {{ (old('student_id') == $student->id || ($requestData && $requestData->student_id == $student->id)) ? 'selected' : '' }}>
                            {{ $student->name }} - {{ $student->schoolClass->name ?? 'Tanpa Kelas' }} (Absen: {{ $student->absen ?? '-' }}) - {{ $student->specialization ?? '-' }}
                        </option>
                    @endforeach
                </select>
                {{-- Jika disabled, tambahkan input hidden agar data tetap terkirim --}}
                @if ($requestData)
                    <input type="hidden" name="student_id" value="{{ $requestData->student_id }}">
                @endif
                @error('student_id') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="teacher_id" class="block text-sm font-medium text-gray-300 mb-2">Guru BK Penanggung Jawab</label>
                <select name="teacher_id" id="teacher_id" required
                        class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm text-white">
                    <option value="">-- Pilih Guru BK --</option>
                    @foreach ($teachers as $teacher)
                        <option value="{{ $teacher->id }}" 
                            {{ (old('teacher_id') == $teacher->id || Auth::id() == $teacher->id) ? 'selected' : '' }}>
                            {{ $teacher->name }}
                        </option>
                    @endforeach
                </select>
                @error('teacher_id') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label for="scheduled_date" class="block text-sm font-medium text-gray-300 mb-2">Tanggal Sesi</label>
                    <input type="date" name="scheduled_date" id="scheduled_date" value="{{ old('scheduled_date', date('Y-m-d')) }}" required
                        class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm text-white">
                    @error('scheduled_date') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="start_time" class="block text-sm font-medium text-gray-300 mb-2">Mulai Pukul</label>
                    <input type="time" name="start_time" id="start_time" value="{{ old('start_time', '10:00') }}" required
                        class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm text-white">
                    @error('start_time') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="end_time" class="block text-sm font-medium text-gray-300 mb-2">Selesai Pukul</label>
                    <input type="time" name="end_time" id="end_time" value="{{ old('end_time', '11:00') }}" required
                        class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm text-white">
                    @error('end_time') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex justify-end space-x-3 pt-4">
                <a href="{{ route('admin.schedules.index') }}" 
                   class="py-2 px-4 border border-gray-600 rounded-lg text-gray-300 hover:bg-gray-700 transition">Batal</a>
                <button type="submit" 
                        class="py-2 px-4 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition duration-300">
                    Konfirmasi Jadwal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection