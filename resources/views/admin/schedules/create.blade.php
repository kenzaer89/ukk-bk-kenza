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
                <label for="student_id" class="block text-sm font-medium text-gray-300 mb-2">Pilih Siswa <span class="text-red-500">*</span></label>
                <select name="student_id" id="student_id" required {{ $requestData ? 'disabled' : '' }}
                        oninvalid="this.setCustomValidity('Silakan pilih siswa dalam daftar')"
                        oninput="this.setCustomValidity('')"
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
                <label for="teacher_id" class="block text-sm font-medium text-gray-300 mb-2">Guru BK Penanggung Jawab <span class="text-red-500">*</span></label>
                <select name="teacher_id" id="teacher_id" required
                        oninvalid="this.setCustomValidity('Silakan pilih guru BK dalam daftar')"
                        oninput="this.setCustomValidity('')"
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

            <div>
                <label for="topic_id" class="block text-sm font-medium text-gray-300 mb-2">Topik Konseling <span class="text-red-500">*</span></label>
                <select name="topic_id" id="topic_id" required
                        oninvalid="this.setCustomValidity('Silakan pilih topik dalam daftar')"
                        oninput="this.setCustomValidity('')"
                        class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm text-white">
                    <option value="">-- Pilih Topik --</option>
                    <option value="custom" {{ old('topic_id') == 'custom' ? 'selected' : '' }}>-- Custom (Tulis Sendiri) --</option>
                    @foreach ($topics as $topic)
                        <option value="{{ $topic->id }}" 
                            {{ (old('topic_id') == $topic->id || ($requestData && $requestData->topic_id == $topic->id)) ? 'selected' : '' }}>
                            {{ $topic->name }}
                        </option>
                    @endforeach
                </select>
                @error('topic_id') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div id="custom-topic-field" class="mt-3 {{ old('topic_id') == 'custom' ? '' : 'hidden' }}">
                <label for="custom_topic" class="block text-sm font-medium text-gray-300 mb-2 font-bold text-indigo-400">📝 Tulis Topik Baru <span class="text-red-500">*</span></label>
                <input type="text" name="custom_topic" id="custom_topic" value="{{ old('custom_topic') }}"
                       placeholder="Masukkan nama topik baru..."
                       oninvalid="this.setCustomValidity('Tuliskan nama topik baru')"
                       oninput="this.setCustomValidity('')"
                       class="w-full p-3 bg-gray-700 border border-indigo-500/50 rounded-lg text-sm text-white focus:ring-indigo-500 focus:border-indigo-500">
                @error('custom_topic') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label for="scheduled_date" class="block text-sm font-medium text-gray-300 mb-2">Tanggal Sesi <span class="text-red-500">*</span></label>
                    <input type="date" name="scheduled_date" id="scheduled_date" value="{{ old('scheduled_date', date('Y-m-d')) }}" 
                        min="{{ date('Y-m-d') }}" required
                        oninvalid="this.setCustomValidity('Pilih tanggal sesi yang valid')"
                        oninput="this.setCustomValidity('')"
                        class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm text-white">
                    @error('scheduled_date') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="start_time" class="block text-sm font-medium text-gray-300 mb-2">Mulai Pukul <span class="text-red-500">*</span></label>
                    <input type="time" name="start_time" id="start_time" value="{{ old('start_time') }}" required
                        oninvalid="this.setCustomValidity('Isi waktu mulai')"
                        oninput="this.setCustomValidity('')"
                        class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm text-white">
                    @error('start_time') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="end_time" class="block text-sm font-medium text-gray-300 mb-2">Selesai Pukul <span class="text-red-500">*</span></label>
                    <input type="time" name="end_time" id="end_time" value="{{ old('end_time') }}" required disabled
                        oninvalid="this.setCustomValidity('Isi waktu selesai')"
                        oninput="this.setCustomValidity('')"
                        class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm text-white disabled:opacity-50 disabled:cursor-not-allowed">
                    @error('end_time') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="location" class="block text-sm font-medium text-gray-300 mb-2">Lokasi <span class="text-red-500">*</span></label>
                <input type="text" name="location" id="location" value="{{ old('location') }}" 
                    placeholder="Contoh: Ruang BK, Ruang Konseling 1" required
                    oninvalid="this.setCustomValidity('Lokasi wajib diisi')"
                    oninput="this.setCustomValidity('')"
                    class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm text-white">
                @error('location') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const startTimeInput = document.getElementById('start_time');
        const endTimeInput = document.getElementById('end_time');
        const topicSelect = document.getElementById('topic_id');
        const customTopicField = document.getElementById('custom-topic-field');
        const customTopicInput = document.getElementById('custom_topic');
        const form = startTimeInput.closest('form');

        // Function to toggle custom topic field
        function toggleCustomTopic() {
            if (topicSelect.value === 'custom') {
                customTopicField.classList.remove('hidden');
                customTopicInput.setAttribute('required', 'required');
            } else {
                customTopicField.classList.add('hidden');
                customTopicInput.removeAttribute('required');
            }
        }

        // Run on load
        toggleCustomTopic();

        // Run on change
        topicSelect.addEventListener('change', toggleCustomTopic);

        // Function to toggle end_time field
        function toggleEndTime() {
            if (startTimeInput.value && startTimeInput.value.trim() !== '') {
                endTimeInput.disabled = false;
                // Set minimum value for end_time to be greater than start_time
                endTimeInput.min = startTimeInput.value;
            } else {
                endTimeInput.disabled = true;
                endTimeInput.value = '';
                endTimeInput.removeAttribute('min');
            }
        }

        // Function to validate time difference
        function validateTimeDifference() {
            if (startTimeInput.value && endTimeInput.value) {
                if (endTimeInput.value <= startTimeInput.value) {
                    endTimeInput.setCustomValidity('Waktu selesai harus lebih besar dari waktu mulai');
                    return false;
                } else {
                    endTimeInput.setCustomValidity('');
                    return true;
                }
            }
            return true;
        }

        // Listen to input changes on start_time
        startTimeInput.addEventListener('input', function() {
            toggleEndTime();
            validateTimeDifference();
        });
        
        startTimeInput.addEventListener('change', function() {
            toggleEndTime();
            validateTimeDifference();
        });

        // Listen to input changes on end_time
        endTimeInput.addEventListener('input', validateTimeDifference);
        endTimeInput.addEventListener('change', validateTimeDifference);

        // Validate on form submit
        form.addEventListener('submit', function(e) {
            if (!validateTimeDifference()) {
                e.preventDefault();
                endTimeInput.reportValidity();
            }
        });

        // Check on page load
        toggleEndTime();
    });
</script>
@endpush
@endsection