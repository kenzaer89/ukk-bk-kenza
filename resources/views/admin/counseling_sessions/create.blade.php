@extends('layouts.app')

@section('title', 'Catat Sesi Konseling')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6 text-white">✍️ Catat Sesi Konseling Selesai</h1>

    <div class="bg-indigo-900/50 p-4 rounded-lg mb-6 border-l-4 border-indigo-500">
        <p class="font-bold text-indigo-300">Jadwal Sesi:</p>
        <p class="text-white">Siswa: <span class="font-semibold">{{ $schedule->student->name }}</span> (Kelas: {{ $schedule->student->studentClass->name ?? 'N/A' }})</p>
        <p class="text-white">Guru BK: {{ $schedule->teacher->name }}</p>
        <p class="text-white">Waktu: {{ \Carbon\Carbon::parse($schedule->scheduled_date)->format('d F Y') }}, {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</p>
    </div>
    
    <div class="bg-gray-800 rounded-xl shadow-lg p-8 max-w-4xl">
        <form action="{{ route('admin.sessions.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label for="session_date" class="block text-sm font-medium text-gray-300 mb-2">Tanggal Sesi Dilaksanakan</label>
                    <input type="date" name="session_date" id="session_date" 
                           value="{{ old('session_date', $schedule->scheduled_date->format('Y-m-d')) }}" required
                           class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm text-white">
                    @error('session_date') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="follow_up_date" class="block text-sm font-medium text-gray-300 mb-2">Tanggal Tindak Lanjut (Opsional)</label>
                    <input type="date" name="follow_up_date" id="follow_up_date" value="{{ old('follow_up_date') }}"
                           class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm text-white">
                    @error('follow_up_date') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="topic_ids" class="block text-sm font-medium text-gray-300 mb-2">Topik yang Dibahas (Pilih minimal satu)</label>
                <div class="grid grid-cols-3 gap-3 bg-gray-700 p-4 rounded-lg">
                    @foreach ($topics as $topic)
                        <div class="flex items-center">
                            <input type="checkbox" name="topic_ids[]" id="topic_{{ $topic->id }}" value="{{ $topic->id }}"
                                   {{ is_array(old('topic_ids')) && in_array($topic->id, old('topic_ids')) ? 'checked' : '' }}
                                   class="form-checkbox h-5 w-5 text-indigo-600 bg-gray-600 border-gray-500 rounded focus:ring-indigo-500">
                            <label for="topic_{{ $topic->id }}" class="ml-2 text-gray-300">{{ $topic->name }}</label>
                        </div>
                    @endforeach
                </div>
                @error('topic_ids') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="teacher_notes" class="block text-sm font-medium text-gray-300 mb-2">Catatan Guru BK (Wajib)</label>
                <textarea name="teacher_notes" id="teacher_notes" rows="6" required
                          class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm text-white">{{ old('teacher_notes') }}</textarea>
                @error('teacher_notes') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="recommendations" class="block text-sm font-medium text-gray-300 mb-2">Rekomendasi / Rencana Aksi</label>
                <textarea name="recommendations" id="recommendations" rows="4"
                          class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm text-white">{{ old('recommendations') }}</textarea>
                @error('recommendations') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end space-x-3 pt-4">
                <a href="{{ route('admin.schedules.index') }}" 
                   class="py-2 px-4 border border-gray-600 rounded-lg text-gray-300 hover:bg-gray-700 transition">Batal</a>
                <button type="submit" 
                        class="py-2 px-4 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition duration-300">
                    Selesaikan & Catat Sesi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection