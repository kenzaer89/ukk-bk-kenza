@extends('layouts.app')

@section('title', 'Catat Sesi Konseling Baru')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6 text-white">➕ Catat Sesi Konseling Baru</h1>

    <div class="bg-gray-800 rounded-xl shadow-lg p-8 max-w-3xl">
        <form action="{{ route('admin.counseling_sessions.store') }}" method="POST" class="space-y-6">
            @csrf
            
            @if($schedule)
                <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                <div class="bg-blue-900/30 border border-blue-500/30 rounded-lg p-4 mb-6">
                    <h3 class="text-lg font-semibold text-blue-400 mb-2">📅 Berdasarkan Jadwal</h3>
                    <div class="grid grid-cols-2 gap-4 text-sm text-gray-300">
                        <p><span class="text-gray-500">Tanggal:</span> {{ $schedule->scheduled_date->format('d M Y') }}</p>
                        <p><span class="text-gray-500">Waktu:</span> {{ $schedule->start_time }} - {{ $schedule->end_time }}</p>
                        <p><span class="text-gray-500">Siswa:</span> {{ $schedule->student->name }}</p>
                        <p><span class="text-gray-500">Guru BK:</span> {{ $schedule->teacher->name }}</p>
                    </div>
                </div>
            @endif

            {{-- Bagian I: Data Siswa & Konselor --}}
            <section class="space-y-4">
                <h3 class="text-xl font-bold text-blue-400 mb-3 border-b border-gray-700 pb-2">Informasi Dasar</h3>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="student_id" class="block text-sm font-medium text-gray-300 mb-2">Siswa</label>
                        <select name="student_id" id="student_id" required
                                class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white focus:ring-blue-500 focus:border-blue-500">
                            <option value="">-- Pilih Siswa --</option>
                            @foreach ($students as $student)
                                <option value="{{ $student->id }}" {{ old('student_id', $schedule ? $schedule->student_id : '') == $student->id ? 'selected' : '' }}>
                                    {{ $student->name }} - {{ $student->schoolClass->name ?? 'Tanpa Kelas' }} (Absen: {{ $student->absen ?? '-' }}) - {{ $student->specialization ?? '-' }}
                                </option>
                            @endforeach
                        </select>
                        @error('student_id') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="counselor_id" class="block text-sm font-medium text-gray-300 mb-2">Konselor</label>
                        <select name="counselor_id" id="counselor_id" required
                                class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white focus:ring-blue-500 focus:border-blue-500">
                            <option value="">-- Pilih Konselor --</option>
                            @foreach ($counselors as $counselor)
                                <option value="{{ $counselor->id }}" {{ old('counselor_id', $schedule ? $schedule->teacher_id : auth()->id()) == $counselor->id ? 'selected' : '' }}>
                                    {{ $counselor->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('counselor_id') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>
            </section>
            
            {{-- Bagian II: Detail Sesi --}}
            <section class="space-y-4">
                <h3 class="text-xl font-bold text-yellow-400 mb-3 border-b border-gray-700 pb-2">Detail Sesi</h3>
                
                <div>
                    <label for="session_type" class="block text-sm font-medium text-gray-300 mb-2">Jenis Sesi</label>
                    <select name="session_type" id="session_type" required
                            class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white focus:ring-blue-500 focus:border-blue-500">
                        <option value="individual" {{ old('session_type') == 'individual' ? 'selected' : '' }}>Individual</option>
                        <option value="group" {{ old('session_type') == 'group' ? 'selected' : '' }}>Kelompok</option>
                        <option value="referral" {{ old('session_type') == 'referral' ? 'selected' : '' }}>Rujukan (Referral)</option>
                    </select>
                    @error('session_type') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label for="session_date" class="block text-sm font-medium text-gray-300 mb-2">Tanggal Sesi</label>
                        <input type="date" name="session_date" id="session_date" value="{{ old('session_date', $schedule ? $schedule->scheduled_date->format('Y-m-d') : date('Y-m-d')) }}"
                               class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white">
                        @error('session_date') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="start_time" class="block text-sm font-medium text-gray-300 mb-2">Waktu Mulai</label>
                        <input type="time" name="start_time" id="start_time" value="{{ old('start_time', $schedule ? substr($schedule->start_time, 0, 5) : '') }}"
                               class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white">
                        @error('start_time') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="end_time" class="block text-sm font-medium text-gray-300 mb-2">Waktu Selesai</label>
                        <input type="time" name="end_time" id="end_time" value="{{ old('end_time', $schedule ? substr($schedule->end_time, 0, 5) : '') }}"
                               class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white">
                        @error('end_time') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="location" class="block text-sm font-medium text-gray-300 mb-2">Lokasi Sesi</label>
                    <input type="text" name="location" id="location" value="{{ old('location', $schedule ? $schedule->location : '') }}"
                           placeholder="Contoh: Ruang BK 1"
                           {{ $schedule && $schedule->location ? 'readonly' : '' }}
                           class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white {{ $schedule && $schedule->location ? 'cursor-not-allowed opacity-75' : '' }}">
                    @if($schedule && $schedule->location)
                        <p class="text-xs text-gray-400 mt-1">📍 Lokasi dari jadwal konseling</p>
                    @endif
                    @error('location') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
            </section>
            
            {{-- Bagian III: Catatan & Topik --}}
            <section class="space-y-4">
                <h3 class="text-xl font-bold text-green-400 mb-3 border-b border-gray-700 pb-2">Catatan & Topik</h3>

                <div>
                    <label for="topic_ids" class="block text-sm font-medium text-gray-300 mb-2">Topik Konseling</label>
                    <select name="topic_ids[]" id="topic_ids" multiple required
                            class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white h-32">
                        @foreach ($topics as $topic)
                            <option value="{{ $topic->id }}" {{ (collect(old('topic_ids'))->contains($topic->id)) ? 'selected' : '' }}>
                                {{ $topic->name }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-400 mt-1">Tahan tombol Ctrl (Windows) atau Command (Mac) untuk memilih lebih dari satu.</p>
                    @error('topic_ids') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-300 mb-2">Catatan / Hasil Konseling</label>
                    <textarea name="notes" id="notes" rows="4"
                              placeholder="Catatan hasil sesi konseling..."
                              class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white">{{ old('notes') }}</textarea>
                    @error('notes') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-300 mb-2">Status Sesi</label>
                        <select name="status" id="status" required
                                class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white focus:ring-green-500 focus:border-green-500">
                            <option value="scheduled" {{ old('status') == 'scheduled' ? 'selected' : '' }}>Terjadwal</option>
                            <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                            <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                        @error('status') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="flex items-center pt-6">
                        <input type="hidden" name="follow_up_required" value="0">
                        <input type="checkbox" name="follow_up_required" id="follow_up_required" value="1" {{ old('follow_up_required') ? 'checked' : '' }}
                               class="h-5 w-5 text-green-600 bg-gray-700 border-gray-600 rounded focus:ring-green-500">
                        <label for="follow_up_required" class="ml-2 text-sm font-medium text-gray-300">Perlu Tindak Lanjut</label>
                    </div>
                </div>
            </section>

            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-700 mt-6">
                <a href="{{ route('admin.schedules.index') }}" 
                   class="py-2 px-4 border border-gray-600 rounded-lg text-gray-300 hover:bg-gray-700 transition">Batal</a>
                <button type="submit" 
                        class="py-2 px-4 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition duration-300">
                    Simpan Sesi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection