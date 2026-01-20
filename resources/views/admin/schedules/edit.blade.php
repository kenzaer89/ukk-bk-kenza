@extends('layouts.app')

@section('title', 'Edit Jadwal Konseling')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6 text-white">Edit Jadwal Konseling {{ $schedule->id }}</h1>

    <div class="bg-gray-800 rounded-xl shadow-lg p-8 max-w-3xl">
        <form action="{{ route('admin.schedules.update', $schedule) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            @if ($schedule->counselingRequest)
                <div class="bg-indigo-900/50 p-4 rounded-lg mb-6 border-l-4 border-indigo-500">
                    <p class="font-bold text-indigo-300">Jadwal ini berasal dari Permintaan {{ $schedule->counselingRequest->id }}.</p>
                </div>
            @endif

            <div>
                <label for="student_id" class="block text-sm font-medium text-gray-300 mb-2">Pilih Siswa <span class="text-red-500">*</span></label>
                <select name="student_id" id="student_id" required
                        oninvalid="this.setCustomValidity('Silakan pilih siswa dalam daftar')"
                        oninput="this.setCustomValidity('')"
                        class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm text-white">
                    <option value="">-- Pilih Siswa --</option>
                    @foreach ($students as $student)
                        <option value="{{ $student->id }}" 
                            {{ old('student_id', $schedule->student_id) == $student->id ? 'selected' : '' }}>
                            {{ $student->name }} ({{ $student->nis }}) - {{ $student->schoolClass->name ?? 'Tanpa Kelas' }}
                        </option>
                    @endforeach
                </select>
                @error('student_id') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="teacher_name" class="block text-sm font-medium text-gray-300 mb-2">Guru BK Penanggung Jawab <span class="text-red-500">*</span></label>
                <input type="text" name="teacher_name" id="teacher_name" 
                       list="teacher_list"
                       value="{{ old('teacher_name', $schedule->teacher_name ?? $schedule->teacher->name) }}" 
                       placeholder="Ketik nama guru penanggung jawab..." 
                       required
                       class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm text-white">
                <datalist id="teacher_list">
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->name }}">{{ $teacher->role_display_name }}</option>
                    @endforeach
                </datalist>
                @error('teacher_name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="topic_id" class="block text-sm font-medium text-gray-300 mb-2">Topik Konseling <span class="text-red-500">*</span></label>
                <select name="topic_id" id="topic_id" required
                        oninvalid="this.setCustomValidity('Silakan pilih topik dalam daftar')"
                        oninput="this.setCustomValidity('')"
                        class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm text-white">
                    <option value="">-- Pilih Topik --</option>
                    <option value="custom" {{ (old('topic_id', $schedule->topic?->is_custom ? 'custom' : $schedule->topic_id)) == 'custom' ? 'selected' : '' }}>-- Custom (Tulis Sendiri) --</option>
                    @foreach ($topics as $topic)
                        <option value="{{ $topic->id }}" 
                            {{ old('topic_id', $schedule->topic_id) == $topic->id ? 'selected' : '' }}>
                            {{ $topic->name }}
                        </option>
                    @endforeach
                </select>
                @error('topic_id') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div id="custom-topic-field" class="mt-3 {{ (old('topic_id', $schedule->topic?->is_custom ? 'custom' : $schedule->topic_id)) == 'custom' ? '' : 'hidden' }}">
                <label for="custom_topic" class="block text-sm font-medium text-gray-300 mb-2 font-bold text-indigo-400">📝 Tulis Topik Baru <span class="text-red-500">*</span></label>
                <input type="text" name="custom_topic" id="custom_topic" value="{{ old('custom_topic', $schedule->topic?->is_custom ? $schedule->topic->name : '') }}"
                       placeholder="Masukkan nama topik baru..."
                       maxlength="50"
                       oninvalid="this.setCustomValidity('Tuliskan nama topik baru')"
                       oninput="this.setCustomValidity('')"
                       class="w-full p-3 bg-gray-700 border border-indigo-500/50 rounded-lg text-sm text-white focus:ring-indigo-500 focus:border-indigo-500">
                <p class="mt-2 text-[10px] text-brand-light/40 uppercase tracking-widest font-bold italic">Maksimal 50 karakter</p>
                @error('custom_topic') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label for="scheduled_date" class="block text-sm font-medium text-gray-300 mb-2">Tanggal Sesi <span class="text-red-500">*</span></label>
                    <input type="date" name="scheduled_date" id="scheduled_date" value="{{ old('scheduled_date', $schedule->scheduled_date->format('Y-m-d')) }}" 
                        min="{{ date('Y-m-d') }}" required style="color-scheme: dark;"
                        oninvalid="this.setCustomValidity('Pilih tanggal sesi yang valid')"
                        oninput="this.setCustomValidity('')"
                        class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm text-white">
                    @error('scheduled_date') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="start_time" class="block text-sm font-medium text-gray-300 mb-2">Mulai Pukul <span class="text-red-500">*</span></label>
                    <input type="time" name="start_time" id="start_time" value="{{ old('start_time', \Carbon\Carbon::parse($schedule->start_time)->format('H:i')) }}" required
                        oninvalid="this.setCustomValidity('Harap isi waktu mulai')"
                        oninput="this.setCustomValidity('')"
                        style="color-scheme: dark;"
                        class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm text-white">
                    @error('start_time') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="end_time" class="block text-sm font-medium text-gray-300 mb-2">Selesai Pukul <span class="text-red-500">*</span></label>
                    <input type="time" name="end_time" id="end_time" value="{{ old('end_time', \Carbon\Carbon::parse($schedule->end_time)->format('H:i')) }}" required
                        oninvalid="this.setCustomValidity('Harap isi waktu selesai')"
                        oninput="this.setCustomValidity('')"
                        style="color-scheme: dark;"
                        class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm text-white disabled:opacity-50 disabled:cursor-not-allowed">
                    @error('end_time') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="location" class="block text-sm font-medium text-gray-300 mb-2">Lokasi <span class="text-red-500">*</span></label>
                <input type="text" name="location" id="location" value="{{ old('location', $schedule->location) }}" 
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
                    Perbarui Jadwal
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
            } else {
                endTimeInput.disabled = true;
                endTimeInput.value = '';
            }
        }

        // Function to validate time difference
        function validateTimeDifference() {
            if (startTimeInput.value && endTimeInput.value) {
                if (endTimeInput.value <= startTimeInput.value) {
                    endTimeInput.setCustomValidity('waktu selesai tidak boleh sama atau kurang dari waktu pukul');
                    return false;
                } else {
                    endTimeInput.setCustomValidity('');
                    return true;
                }
            } else if (startTimeInput.value && !endTimeInput.value) {
                endTimeInput.setCustomValidity('Harap isi waktu selesai');
                return false;
            } else if (!startTimeInput.value && endTimeInput.value) {
                startTimeInput.setCustomValidity('Harap isi waktu mulai');
                return false;
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
        form.addEventListener('submit', async function(e) {
            if (!validateTimeDifference()) {
                e.preventDefault();
                endTimeInput.reportValidity();
                return;
            }

            // Mencegah submit default jika belum dikonfirmasi lewat AJAX
            if (form.dataset.confirmed !== 'true') {
                e.preventDefault();
                
                const requestData = {
                    id: "{{ $schedule->id }}",
                    scheduled_date: document.getElementById('scheduled_date').value,
                    start_time: startTimeInput.value,
                    end_time: endTimeInput.value,
                    student_id: document.getElementById('student_id').value,
                    teacher_name: document.getElementById('teacher_name').value,
                    location: document.getElementById('location').value,
                };

                try {
                    const response = await fetch("{{ route('admin.schedules.check_conflict') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(requestData)
                    });
                    
                    const data = await response.json();
                    
                    if (data.conflict) {
                        const details = data.details;
                        let conflictHtml = '';
                        
                        details.forEach((item, index) => {
                            conflictHtml += `
                                <div style="background: rgba(245, 158, 11, 0.1); border-left: 4px solid #F59E0B; padding: 1rem; border-radius: 0.75rem; margin-bottom: 1rem; border: 1px solid rgba(245, 158, 11, 0.2);">
                                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.5rem;">
                                        <span style="color: #F59E0B; font-weight: 700; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em;">Bentrok #${index + 1}: ${item.conflict_type}</span>
                                        <span style="color: #f8fafc; font-weight: 700; font-size: 0.85rem; background: rgba(245, 158, 11, 0.2); padding: 0.25rem 0.5rem; rounded: 0.375rem;">${item.time_range} WIB</span>
                                    </div>
                                    <div style="grid; grid-template-columns: 1fr 1fr; gap: 0.5rem; font-size: 0.85rem;">
                                        <p style="margin: 0; color: #f8fafc;"><span style="color: #94a3b8;">Siswa:</span> ${item.student_name} (${item.class_name})</p>
                                        <p style="margin: 0.25rem 0 0 0; color: #f8fafc;"><span style="color: #94a3b8;">Guru:</span> ${item.teacher_name}</p>
                                        <p style="margin: 0.25rem 0 0 0; color: #f8fafc;"><span style="color: #94a3b8;">Lokasi:</span> ${item.location}</p>
                                    </div>
                                </div>
                            `;
                        });

                        Swal.fire({
                            title: '⚠️ Jadwal Bentrok!',
                            html: `
                                <div style="text-align: left; padding: 0.5rem;">
                                    <p style="color: #f8fafc; font-size: 0.95rem; margin-bottom: 1.25rem; opacity: 0.8;">
                                        Ditemukan <strong>${data.count}</strong> jadwal yang bertabrakan dengan waktu yang Anda pilih:
                                    </p>
                                    
                                    <div style="max-height: 300px; overflow-y: auto; padding-right: 0.5rem; margin-bottom: 1.5rem;">
                                        ${conflictHtml}
                                    </div>

                                    <div style="background: rgba(255, 255, 255, 0.05); padding: 1rem; border-radius: 0.75rem; border: 1px solid rgba(255, 255, 255, 0.1); margin-bottom: 1.5rem;">
                                        <p style="margin: 0 0 0.5rem 0; color: #94a3b8; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 700;">
                                            ⏰ Waktu yang Anda Pilih
                                        </p>
                                        <p style="margin: 0; color: #2dd4bf; font-size: 1.1rem; font-weight: 700;">
                                            ${requestData.start_time} - ${requestData.end_time} WIB
                                        </p>
                                    </div>

                                    <div style="padding: 1rem; background: rgba(45, 212, 191, 0.1); border-radius: 0.75rem; border: 1px solid rgba(45, 212, 191, 0.2);">
                                        <p style="margin: 0; color: #2dd4bf; font-size: 0.85rem; font-weight: 500; line-height: 1.5;">
                                            💡 <strong>Tips:</strong> Silakan pilih waktu lain, atau klik <strong>"Lanjutkan"</strong> jika Anda yakin ingin memperbarui jadwal ini meskipun bertabrakan.
                                        </p>
                                    </div>
                                </div>
                            `,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#2dd4bf',
                            cancelButtonColor: '#64748b',
                            confirmButtonText: '✓ Lanjutkan Tetap',
                            cancelButtonText: '✕ Batal',
                            customClass: {
                                popup: 'swal-conflict-popup',
                                title: 'swal-conflict-title',
                                htmlContainer: 'swal-conflict-content',
                                confirmButton: 'swal-confirm-btn',
                                cancelButton: 'swal-cancel-btn'
                            },
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Add bypass flag
                                const hiddenInput = document.createElement('input');
                                hiddenInput.type = 'hidden';
                                hiddenInput.name = 'ignore_conflict';
                                hiddenInput.value = '1';
                                form.appendChild(hiddenInput);
                                
                                form.dataset.confirmed = 'true';
                                form.submit();
                            }
                        });
                    } else {
                        form.dataset.confirmed = 'true';
                        form.submit();
                    }
                } catch (error) {
                    console.error('Error checking conflict:', error);
                    form.dataset.confirmed = 'true';
                    form.submit();
                }
            }
        });

        // Check on page load
        toggleEndTime();
    });
</script>
@endpush
@endsection