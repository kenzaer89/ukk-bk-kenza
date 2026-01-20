@extends('layouts.app')

@section('title', 'Tangani Sesi Konseling')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6 text-white">🛠️ Tangani Sesi Konseling</h1>

    <div class="bg-gray-800 rounded-xl shadow-lg p-8 max-w-3xl">
        <h2 class="text-2xl font-bold mb-6 text-blue-400 border-b border-gray-700 pb-2">Siswa: {{ $session->student->name ?? 'N/A' }} ({{ $session->student->schoolClass->name ?? '-' }})</h2>

        <form action="{{ route('admin.counseling_sessions.update', $session) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            {{-- Bagian I: Data Permintaan --}}
            <section class="p-4 bg-gray-700 rounded-lg">
                <h3 class="text-xl font-bold text-yellow-400 mb-3">Data Permintaan Siswa</h3>
                <div class="text-gray-300 space-y-2">
                    <p><span class="font-semibold">Diajukan Pada:</span> {{ $session->created_at->format('d M Y H:i') }}</p>
                    <p><span class="font-semibold">Alasan Permintaan:</span> <span class="italic text-white block mt-1 p-2 bg-gray-800 rounded">{{ $session->request_reason }}</span></p>
                    <p><span class="font-semibold">Topik yang Diajukan:</span> 
                        @foreach ($session->topics as $topic)
                            <span class="inline-block bg-blue-800 text-xs px-2 py-0.5 rounded-full mr-1">{{ $topic->name }}</span>
                        @endforeach
                    </p>
                </div>
            </section>
            
            {{-- Bagian II: Penanganan & Penjadwalan --}}
            <section class="space-y-4">
                <h3 class="text-xl font-bold text-blue-400 mb-3 border-b border-gray-700 pb-2">Penjadwalan & Penugasan Konselor</h3>
                
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label for="counselor_name" class="block text-sm font-medium text-gray-300 mb-2">Konselor yang Menangani</label>
                        <input type="text" name="counselor_name" id="counselor_name" 
                               value="{{ old('counselor_name', $session->counselor_name ?? ($session->counselor->name ?? auth()->user()->name)) }}" 
                               required
                               class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white focus:ring-blue-500 focus:border-blue-500">
                        @error('counselor_name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label for="session_date" class="block text-sm font-medium text-gray-300 mb-2">Tanggal Sesi</label>
                        <input type="date" name="session_date" id="session_date" value="{{ old('session_date', $session->session_date ? $session->session_date->format('Y-m-d') : null) }}"
                               style="color-scheme: dark;"
                               class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white">
                    </div>
                    <div>
                        <label for="start_time" class="block text-sm font-medium text-gray-300 mb-2">Waktu Mulai</label>
                        <input type="time" name="start_time" id="start_time" value="{{ old('start_time', $session->start_time ? substr($session->start_time, 0, 5) : null) }}"
                               style="color-scheme: dark;"
                               class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white">
                    </div>
                    <div>
                        <label for="end_time" class="block text-sm font-medium text-gray-300 mb-2">Waktu Selesai</label>
                        <input type="time" name="end_time" id="end_time" value="{{ old('end_time', $session->end_time ? substr($session->end_time, 0, 5) : null) }}"
                               style="color-scheme: dark;"
                               class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white">
                    </div>
                </div>

                <div>
                    <label for="location" class="block text-sm font-medium text-gray-300 mb-2">Lokasi Sesi</label>
                    <input type="text" name="location" id="location" value="{{ old('location', $session->location) }}"
                           placeholder="Contoh: Ruang BK 1"
                           class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white">
                </div>
            </section>
            
            {{-- Bagian III: Catatan Hasil Sesi --}}
            <section class="space-y-4">
                <h3 class="text-xl font-bold text-green-400 mb-3 border-b border-gray-700 pb-2">Catatan Hasil Sesi</h3>

                <div>
                    <label for="notes" id="notes-label" class="block text-sm font-medium text-gray-300 mb-2">Catatan / Hasil Tindakan Konseling</label>
                    <textarea name="notes" id="notes" rows="6" maxlength="500"
                              oninput="document.getElementById('edit-char-count').innerText = this.value.length;"
                              placeholder="Contoh: Siswa menunjukkan hambatan X. Diberikan teknik Z. Perlu monitoring 1 minggu ke depan."
                              class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white">{{ old('notes', $session->notes) }}</textarea>
                    <div class="flex justify-between items-center mt-1">
                        <p class="text-[10px] text-brand-light/40 uppercase tracking-widest font-bold italic">Maksimal 500 karakter</p>
                        <p class="text-[10px] text-brand-light/60 font-bold"><span id="edit-char-count">{{ strlen($session->notes ?? '') }}</span> / 500</p>
                    </div>
                    @error('notes') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
                
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-300 mb-2">Status Sesi</label>
                    <select name="status" id="status" required
                            class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white focus:ring-green-500 focus:border-green-500">
                        <option value="requested" {{ old('status', $session->status) == 'requested' ? 'selected' : '' }}>Diminta (Baru)</option>
                        <option value="scheduled" {{ old('status', $session->status) == 'scheduled' ? 'selected' : '' }}>Terjadwal</option>
                        <option value="completed" {{ old('status', $session->status) == 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="cancelled" {{ old('status', $session->status) == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                    @error('status') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
                

            </section>
            
            {{-- Bagian IV: Topik Sesi (Dapat Diubah oleh BK) --}}
            <section>
                <h3 class="text-xl font-bold text-purple-400 mb-3 border-b border-gray-700 pb-2">Topik Sesi (Final)</h3>
                <div>
                    <label for="topic_id" class="block text-sm font-medium text-gray-300 mb-2">Pilih Topik Konseling</label>
                    <select name="topic_id" id="topic_id"
                            class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Pilih Topik --</option>
                        <option value="custom" {{ (old('topic_id', optional($session->topics->first())->is_custom ? 'custom' : optional($session->topics->first())->id)) == 'custom' ? 'selected' : '' }}>-- Custom (Tulis Sendiri) --</option>
                        @foreach ($topics as $topic)
                            <option value="{{ $topic->id }}" {{ old('topic_id', optional($session->topics->first())->id) == $topic->id ? 'selected' : '' }}>
                                {{ $topic->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('topic_id') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div id="custom-topic-field" class="mt-3 {{ (old('topic_id', optional($session->topics->first())->is_custom ? 'custom' : optional($session->topics->first())->id)) == 'custom' ? '' : 'hidden' }}">
                    <label for="custom_topic" class="block text-sm font-medium text-gray-300 mb-2">Topik Custom <span class="text-red-500">*</span></label>
                    <input type="text" name="custom_topic" id="custom_topic" value="{{ old('custom_topic', optional($session->topics->first())->is_custom ? $session->topics->first()->name : '') }}"
                           maxlength="50"
                           placeholder="Masukkan nama topik baru..."
                           class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white focus:ring-blue-500 focus:border-blue-500">
                    <p class="mt-2 text-[10px] text-brand-light/40 uppercase tracking-widest font-bold italic">Maksimal 50 karakter</p>
                    @error('custom_topic') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
            </section>

            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-700 mt-6">
                <a href="{{ route('admin.schedules.index') }}" 
                   class="py-2 px-4 border border-gray-600 rounded-lg text-gray-300 hover:bg-gray-700 transition">Batal</a>
                <button type="submit" id="submit-button"
                        class="py-2 px-4 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition duration-300">
                    Simpan & Perbarui Sesi
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

        const statusSelect = document.getElementById('status');
        const submitButton = document.getElementById('submit-button');

        const notesLabel = document.getElementById('notes-label');
        const notesTextarea = document.getElementById('notes');

        function toggleSubmitButton() {
            if (!statusSelect || !submitButton) return;

            // Toggle label and placeholder
            if (statusSelect.value === 'cancelled') {
                if (notesLabel) notesLabel.innerHTML = 'Alasan Dibatalkan <span class="text-red-500">*</span>';
                if (notesTextarea) notesTextarea.placeholder = 'Masukkan alasan pembatalan sesi...';
            } else {
                if (notesLabel) notesLabel.innerHTML = 'Catatan / Hasil Tindakan Konseling';
                if (notesTextarea) notesTextarea.placeholder = 'Contoh: Siswa menunjukkan hambatan X. Diberikan teknik Z. Perlu monitoring 1 minggu ke depan.';
            }

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
    });
</script>
@endpush