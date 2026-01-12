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
                <input type="hidden" name="student_id" value="{{ $schedule->student_id }}">
                <input type="hidden" name="counselor_id" value="{{ $schedule->teacher_id }}">
                <input type="hidden" name="session_date" value="{{ $schedule->scheduled_date->format('Y-m-d') }}">
                <input type="hidden" name="start_time" value="{{ substr($schedule->start_time, 0, 5) }}">
                <input type="hidden" name="end_time" value="{{ substr($schedule->end_time, 0, 5) }}">
                <input type="hidden" name="topic_id" value="{{ $schedule->topic_id }}">
                
                <div class="bg-blue-900/30 border border-blue-500/30 rounded-lg p-6 mb-8 shadow-inner">
                    <div class="flex items-center justify-between mb-4 border-b border-blue-500/20 pb-2">
                        <h3 class="text-lg font-bold text-blue-400 flex items-center gap-2">
                            <span>📅 Informasi Jadwal Konseling</span>
                        </h3>
                        <span class="text-xs bg-blue-500/20 text-blue-300 px-2 py-1 rounded">ID: #{{ $schedule->id }}</span>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-y-4 gap-x-8 text-sm">
                        <div class="space-y-1">
                            <p class="text-blue-400/60 uppercase text-[10px] font-bold tracking-wider">Tanggal Sesi</p>
                            <p class="text-white font-medium italic">{{ $schedule->scheduled_date->format('d M Y') }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-blue-400/60 uppercase text-[10px] font-bold tracking-wider">Waktu</p>
                            <p class="text-white font-medium">{{ substr($schedule->start_time, 0, 5) }} - {{ substr($schedule->end_time, 0, 5) }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-blue-400/60 uppercase text-[10px] font-bold tracking-wider">Siswa</p>
                            <p class="text-white font-bold text-base leading-tight">{{ $schedule->student->name }}</p>
                            <div class="flex gap-2 mt-1">
                                <span class="bg-blue-500/10 text-blue-300 text-[10px] px-1.5 py-0.5 rounded border border-blue-500/20">
                                    Kelas: {{ $schedule->student->schoolClass->name ?? '-' }}
                                </span>
                                <span class="bg-blue-500/10 text-blue-300 text-[10px] px-1.5 py-0.5 rounded border border-blue-500/20">
                                    Absen: {{ $schedule->student->absen ?? '-' }}
                                </span>
                                <span class="bg-blue-500/10 text-blue-300 text-[10px] px-1.5 py-0.5 rounded border border-blue-500/20">
                                    Jurusan: {{ $schedule->student->specialization ?? '-' }}
                                </span>
                            </div>
                        </div>
                        <div class="space-y-1">
                            <p class="text-blue-400/60 uppercase text-[10px] font-bold tracking-wider">Guru BK / Konselor</p>
                            <p class="text-white font-bold text-base">{{ $schedule->teacher->name }}</p>
                        </div>
                        <div class="space-y-1 mt-2 pt-2 border-t border-blue-500/10">
                            <p class="text-blue-400/60 uppercase text-[10px] font-bold tracking-wider">Lokasi Sesi</p>
                            <p class="text-white font-medium flex items-center gap-2">
                                <span class="text-blue-400">📍</span> {{ $schedule->location ?? 'Belum ditentukan' }}
                            </p>
                            <input type="hidden" name="location" value="{{ $schedule->location }}">
                        </div>
                        <div class="space-y-1 mt-2 pt-2 border-t border-blue-500/10">
                            <p class="text-blue-400/60 uppercase text-[10px] font-bold tracking-wider">Topik Konseling</p>
                            <p class="text-white font-medium flex items-center gap-2">
                                <span class="text-blue-400">📝</span> {{ $schedule->topic->name ?? '-' }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Bagian I: Data Siswa & Konselor (Hanya jika tidak ada jadwal) --}}
            @if(!$schedule)
            <section class="space-y-4">
                <h3 class="text-xl font-bold text-blue-400 mb-3 border-b border-gray-700 pb-2">Informasi Dasar</h3>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="student_id" class="block text-sm font-medium text-gray-300 mb-2">Siswa <span class="text-red-500">*</span></label>
                        <select name="student_id" id="student_id" required
                                oninvalid="this.setCustomValidity('Silakan pilih siswa dalam daftar')"
                                oninput="this.setCustomValidity('')"
                                class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white focus:ring-blue-500 focus:border-blue-500">
                            <option value="">-- Pilih Siswa --</option>
                            @foreach ($students as $student)
                                <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                    {{ $student->name }} - {{ $student->schoolClass->name ?? 'Tanpa Kelas' }} (Absen: {{ $student->absen ?? '-' }}) - {{ $student->specialization ?? '-' }}
                                </option>
                            @endforeach
                        </select>
                        @error('student_id') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="counselor_id" class="block text-sm font-medium text-gray-300 mb-2">Konselor <span class="text-red-500">*</span></label>
                        <select name="counselor_id" id="counselor_id" required
                                oninvalid="this.setCustomValidity('Silakan pilih konselor dalam daftar')"
                                oninput="this.setCustomValidity('')"
                                class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white focus:ring-blue-500 focus:border-blue-500">
                            <option value="">-- Pilih Konselor --</option>
                            @foreach ($counselors as $counselor)
                                <option value="{{ $counselor->id }}" {{ old('counselor_id', auth()->id()) == $counselor->id ? 'selected' : '' }}>
                                    {{ $counselor->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('counselor_id') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>
            </section>
            @endif
            
            {{-- Bagian III: Catatan & Topik --}}
            <section class="space-y-4">
                <h3 class="text-xl font-bold text-green-400 mb-3 border-b border-gray-700 pb-2">Catatan & Topik</h3>

                <div>
                    <label for="session_type" class="block text-sm font-medium text-gray-300 mb-2">Jenis Sesi <span class="text-red-500">*</span></label>
                    <select name="session_type" id="session_type" required
                            oninvalid="this.setCustomValidity('Pilih jenis sesi')"
                            oninput="this.setCustomValidity('')"
                            class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white focus:ring-blue-500 focus:border-blue-500">
                        <option value="individual" {{ old('session_type') == 'individual' ? 'selected' : '' }}>Individual</option>
                        <option value="group" {{ old('session_type') == 'group' ? 'selected' : '' }}>Kelompok</option>
                        <option value="referral" {{ old('session_type') == 'referral' ? 'selected' : '' }}>Rujukan (Referral)</option>
                    </select>
                    @error('session_type') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                @if(!$schedule)
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label for="session_date" class="block text-sm font-medium text-gray-300 mb-2">Tanggal Sesi <span class="text-red-500">*</span></label>
                        <input type="date" name="session_date" id="session_date" value="{{ old('session_date', date('Y-m-d')) }}" required
                               oninvalid="this.setCustomValidity('Pilih tanggal sesi')"
                               oninput="this.setCustomValidity('')"
                               class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white">
                        @error('session_date') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="start_time" class="block text-sm font-medium text-gray-300 mb-2">Waktu Mulai <span class="text-red-500">*</span></label>
                        <input type="time" name="start_time" id="start_time" value="{{ old('start_time') }}" required
                               oninvalid="this.setCustomValidity('Isi waktu mulai')"
                               oninput="this.setCustomValidity('')"
                               class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white">
                        @error('start_time') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="end_time" class="block text-sm font-medium text-gray-300 mb-2">Waktu Selesai <span class="text-red-500">*</span></label>
                        <input type="time" name="end_time" id="end_time" value="{{ old('end_time') }}" required
                               oninvalid="this.setCustomValidity('Isi waktu selesai')"
                               oninput="this.setCustomValidity('')"
                               class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white">
                        @error('end_time') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="location" class="block text-sm font-medium text-gray-300 mb-2">Lokasi Sesi <span class="text-red-500">*</span></label>
                    <input type="text" name="location" id="location" value="{{ old('location') }}" required
                           oninvalid="this.setCustomValidity('Lokasi wajib diisi')"
                           oninput="this.setCustomValidity('')"
                           placeholder="Contoh: Ruang BK 1"
                           class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white focus:ring-blue-500 focus:border-blue-500">
                    @error('location') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
                @endif

                @if(!$schedule)
                <div>
                    <label for="topic_id" class="block text-sm font-medium text-gray-300 mb-2">Topik Konseling <span class="text-red-500">*</span></label>
                    <select name="topic_id" id="topic_id" required
                            oninvalid="this.setCustomValidity('Silakan pilih topik dalam daftar')"
                            oninput="this.setCustomValidity('')"
                            class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Pilih Topik --</option>
                        <option value="custom" {{ old('topic_id') == 'custom' ? 'selected' : '' }}>-- Custom (Tulis Sendiri) --</option>
                        @foreach ($topics as $topic)
                            <option value="{{ $topic->id }}" {{ old('topic_id') == $topic->id ? 'selected' : '' }}>
                                {{ $topic->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('topic_id') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div id="custom-topic-field" class="mt-3 hidden">
                    <label for="custom_topic" class="block text-sm font-medium text-gray-300 mb-2">Topik Custom <span class="text-red-500">*</span></label>
                    <input type="text" name="custom_topic" id="custom_topic" value="{{ old('custom_topic') }}"
                           oninvalid="this.setCustomValidity('Tuliskan topik custom')"
                           oninput="this.setCustomValidity('')"
                           placeholder="Masukkan nama topik baru..."
                           class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white focus:ring-blue-500 focus:border-blue-500">
                    <p class="text-xs text-gray-400 mt-1">Gunakan ini jika topik yang diinginkan tidak ada di daftar atas.</p>
                    @error('custom_topic') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
                @endif

                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-300 mb-2">Catatan / Hasil Konseling <span class="text-red-500">*</span></label>
                    <textarea name="notes" id="notes" rows="4" required
                              oninvalid="this.setCustomValidity('Harap isi catatan hasil konseling')"
                              oninput="this.setCustomValidity('')"
                              placeholder="Catatan hasil sesi konseling..."
                              class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white">{{ old('notes') }}</textarea>
                    @error('notes') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
                
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-300 mb-2">Status Sesi <span class="text-red-500">*</span></label>
                    <select name="status" id="status" required
                            oninvalid="this.setCustomValidity('Pilih status sesi')"
                            oninput="this.setCustomValidity('')"
                            class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white focus:ring-green-500 focus:border-green-500">
                        <option value="scheduled" {{ old('status') == 'scheduled' ? 'selected' : '' }}>Terjadwal</option>
                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                    @error('status') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const topicSelect = document.getElementById('topic_id');
        const customTopicField = document.getElementById('custom-topic-field');
        const customTopicInput = document.getElementById('custom_topic');

        function toggleCustomTopic() {
            if (topicSelect.value === 'custom') {
                customTopicField.classList.remove('hidden');
                customTopicInput.setAttribute('required', 'required');
            } else {
                customTopicField.classList.add('hidden');
                customTopicInput.removeAttribute('required');
                // Optional: clear input when hidden
                // customTopicInput.value = '';
            }
        }

        // Run on load
        toggleCustomTopic();

        // Run on change
        topicSelect.addEventListener('change', toggleCustomTopic);
    });
</script>
@endpush