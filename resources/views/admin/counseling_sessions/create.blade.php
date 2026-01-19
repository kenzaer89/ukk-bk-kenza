@extends('layouts.app')

@section('title', 'Catat Sesi Konseling Baru')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6 text-white flex items-center gap-3">
        <span class="p-2 bg-indigo-500/20 rounded-lg">
            <svg class="w-8 h-8 text-brand-teal" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
        </span>
        Catat Sesi Konseling Baru
    </h1>

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
                    <div class="flex items-center justify-between mb-4 border-b border-white/10 pb-2">
                        <h3 class="text-lg font-bold text-white flex items-center gap-3">
                            <span class="p-1.5 bg-white/10 rounded-lg">
                                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </span>
                            Informasi Jadwal Konseling
                        </h3>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-y-4 gap-x-8 text-sm">
                        <div class="space-y-1">
                            <p class="text-white/60 uppercase text-[10px] font-bold tracking-wider">Tanggal Konseling</p>
                            <p class="text-white font-medium italic">{{ $schedule->scheduled_date->format('d M Y') }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-white/60 uppercase text-[10px] font-bold tracking-wider">Waktu</p>
                            <p class="text-white font-medium">{{ substr($schedule->start_time, 0, 5) }} - {{ substr($schedule->end_time, 0, 5) }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-white/60 uppercase text-[10px] font-bold tracking-wider">Siswa</p>
                            <p class="text-white font-bold text-base leading-tight">{{ $schedule->student->name }}</p>
                            <div class="flex gap-2 mt-1">
                                <span class="bg-white/5 text-white/80 text-[10px] px-1.5 py-0.5 rounded border border-white/10">
                                    Kelas: {{ $schedule->student->schoolClass->name ?? '-' }}
                                </span>
                                <span class="bg-white/5 text-white/80 text-[10px] px-1.5 py-0.5 rounded border border-white/10">
                                    Absen: {{ $schedule->student->absen ?? '-' }}
                                </span>
                            </div>
                        </div>
                        <div class="space-y-1">
                            <p class="text-white/60 uppercase text-[10px] font-bold tracking-wider">Guru BK / Konselor</p>
                            <p class="text-white font-bold text-base">{{ $schedule->teacher_name ?? $schedule->teacher->name }}</p>
                            <input type="hidden" name="counselor_name" value="{{ $schedule->teacher_name ?? $schedule->teacher->name }}">
                        </div>
                        <div class="space-y-1 mt-2 pt-2 border-t border-white/10">
                            <p class="text-white/60 uppercase text-[10px] font-bold tracking-wider">Lokasi Konseling</p>
                            <p class="text-white font-medium flex items-center gap-2">
                                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $schedule->location ?? 'Belum ditentukan' }}
                            </p>
                            <input type="hidden" name="location" value="{{ $schedule->location }}">
                        </div>
                        <div class="space-y-1 mt-2 pt-2 border-t border-white/10 overflow-hidden">
                            <p class="text-white/60 uppercase text-[10px] font-bold tracking-wider">Topik Konseling</p>
                            <p class="text-white font-medium flex items-start gap-2 break-all">
                                <svg class="w-4 h-4 text-white mt-1 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                                <span class="leading-relaxed">{{ $schedule->topic->name ?? '-' }}</span>
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
                                    {{ $student->name }} - {{ $student->schoolClass->name ?? 'Tanpa Kelas' }} (Absen: {{ $student->absen ?? '-' }})
                                </option>
                            @endforeach
                        </select>
                        @error('student_id') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="counselor_name" class="block text-sm font-medium text-gray-300 mb-2">Konselor <span class="text-red-500">*</span></label>
                        <input type="text" name="counselor_name" id="counselor_name" 
                               value="{{ old('counselor_name') }}" 
                               placeholder="Ketik nama konselor..." 
                               required
                               class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white focus:ring-blue-500 focus:border-blue-500">
                        @error('counselor_name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>
            </section>
            @endif
            
            {{-- Bagian III: Catatan --}}
            <section class="space-y-4">
                <h3 class="text-xl font-bold text-green-400 mb-3 border-b border-gray-700 pb-2">Catatan</h3>



                @if(!$schedule)
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label for="session_date" class="block text-sm font-medium text-gray-300 mb-2">Tanggal Sesi <span class="text-red-500">*</span></label>
                        <input type="date" name="session_date" id="session_date" value="{{ old('session_date', date('Y-m-d')) }}" required
                               style="color-scheme: dark;"
                               class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white">
                        @error('session_date') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="start_time" class="block text-sm font-medium text-gray-300 mb-2">Waktu Mulai <span class="text-red-500">*</span></label>
                        <input type="time" name="start_time" id="start_time" value="{{ old('start_time') }}" required
                               style="color-scheme: dark;"
                               class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white">
                        @error('start_time') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="end_time" class="block text-sm font-medium text-gray-300 mb-2">Waktu Selesai <span class="text-red-500">*</span></label>
                        <input type="time" name="end_time" id="end_time" value="{{ old('end_time') }}" required
                               style="color-scheme: dark;"
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
                           maxlength="50"
                           oninvalid="this.setCustomValidity('Tuliskan topik custom')"
                           oninput="this.setCustomValidity('')"
                           placeholder="Masukkan nama topik baru..."
                           class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white focus:ring-blue-500 focus:border-blue-500">
                    <p class="mt-2 text-[10px] text-brand-light/40 uppercase tracking-widest font-bold italic">Maksimal 50 karakter</p>
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
                <button type="submit" id="submit-button"
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
        if (topicSelect) toggleCustomTopic();

        // Run on change
        if (topicSelect) topicSelect.addEventListener('change', toggleCustomTopic);

        // Status Based Button Visibility
        const statusSelect = document.getElementById('status');
        const submitButton = document.getElementById('submit-button');

        function toggleSubmitButton() {
            if (!statusSelect || !submitButton) return;
            if (statusSelect.value === 'scheduled') {
                submitButton.style.display = 'none';
            } else {
                submitButton.style.display = 'inline-flex';
            }
        }

        if (statusSelect && submitButton) {
            statusSelect.addEventListener('change', toggleSubmitButton);
            toggleSubmitButton();
        }

        // Time Validation
        const startTimeInput = document.getElementById('start_time');
        const endTimeInput = document.getElementById('end_time');
        const sessionForm = document.querySelector('form');

        function validateTime() {
            if (startTimeInput && endTimeInput && startTimeInput.value && endTimeInput.value) {
                if (endTimeInput.value <= startTimeInput.value) {
                    endTimeInput.setCustomValidity('waktu selesai tidak boleh sama atau kurang dari waktu pukul');
                } else {
                    endTimeInput.setCustomValidity('');
                }
            }
        }

        if (startTimeInput && endTimeInput) {
            startTimeInput.addEventListener('change', validateTime);
            endTimeInput.addEventListener('change', validateTime);
            
            sessionForm.addEventListener('submit', async function(e) {
                if (sessionForm.dataset.confirmed === 'true') {
                    return;
                }
                
                validateTime();
                if (!endTimeInput.checkValidity()) {
                    e.preventDefault();
                    endTimeInput.reportValidity();
                    return;
                }

                // Conflict check ONLY for manual recording (no pre-existing schedule)
                if (!document.querySelector('input[name="schedule_id"]') && sessionForm.dataset.confirmed !== 'true') {
                    e.preventDefault();
                    
                    try {
                        const response = await fetch("{{ route('admin.schedules.check_conflict') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                session_date: document.getElementById('session_date').value,
                                start_time: startTimeInput.value,
                                end_time: endTimeInput.value,
                            })
                        });
                        
                        const data = await response.json();
                        
                        if (data.conflict) {
                            Swal.fire({
                                title: 'Jadwal Bentrok!',
                                text: data.message,
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Iya, Tetap Catat',
                                cancelButtonText: 'Tidak, Batalkan'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    sessionForm.dataset.confirmed = 'true';
                                    sessionForm.submit();
                                }
                            });
                        } else {
                            sessionForm.dataset.confirmed = 'true';
                            sessionForm.submit();
                        }
                    } catch (error) {
                        console.error('Error checking conflict:', error);
                        sessionForm.dataset.confirmed = 'true';
                        sessionForm.submit();
                    }
                }
            });
        }
    });
</script>
@endpush