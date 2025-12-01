@extends('layouts.app')

@section('title', 'Tangani Sesi Konseling')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6 text-white">🛠️ Tangani Sesi Konseling</h1>

    <div class="bg-gray-800 rounded-xl shadow-lg p-8 max-w-3xl">
        <h2 class="text-2xl font-bold mb-6 text-blue-400 border-b border-gray-700 pb-2">Siswa: {{ $session->student->name ?? 'N/A' }} ({{ $session->student->schoolClass->name ?? '-' }})</h2>

        <form action="{{ route('admin.counseling_sessions.update', $session->id) }}" method="POST" class="space-y-6">
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
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="counselor_id" class="block text-sm font-medium text-gray-300 mb-2">Konselor yang Menangani</label>
                        <select name="counselor_id" id="counselor_id" required
                                class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white focus:ring-blue-500 focus:border-blue-500">
                            @foreach ($counselors as $counselor)
                                <option value="{{ $counselor->id }}" {{ old('counselor_id', $session->counselor_id ?? auth()->id()) == $counselor->id ? 'selected' : '' }}>
                                    {{ $counselor->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('counselor_id') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label for="session_type" class="block text-sm font-medium text-gray-300 mb-2">Jenis Sesi</label>
                        <select name="session_type" id="session_type" required
                                class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white focus:ring-blue-500 focus:border-blue-500">
                            <option value="individual" {{ old('session_type', $session->session_type) == 'individual' ? 'selected' : '' }}>Individual</option>
                            <option value="group" {{ old('session_type', $session->session_type) == 'group' ? 'selected' : '' }}>Kelompok</option>
                            <option value="referral" {{ old('session_type', $session->session_type) == 'referral' ? 'selected' : '' }}>Rujukan (Referral)</option>
                        </select>
                        @error('session_type') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label for="session_date" class="block text-sm font-medium text-gray-300 mb-2">Tanggal Sesi</label>
                        <input type="date" name="session_date" id="session_date" value="{{ old('session_date', $session->session_date ? $session->session_date->format('Y-m-d') : null) }}"
                               class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white">
                    </div>
                    <div>
                        <label for="start_time" class="block text-sm font-medium text-gray-300 mb-2">Waktu Mulai</label>
                        <input type="time" name="start_time" id="start_time" value="{{ old('start_time', $session->start_time ? substr($session->start_time, 0, 5) : null) }}"
                               class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white">
                    </div>
                    <div>
                        <label for="end_time" class="block text-sm font-medium text-gray-300 mb-2">Waktu Selesai</label>
                        <input type="time" name="end_time" id="end_time" value="{{ old('end_time', $session->end_time ? substr($session->end_time, 0, 5) : null) }}"
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
                    <label for="notes" class="block text-sm font-medium text-gray-300 mb-2">Catatan / Hasil Tindakan Konseling</label>
                    <textarea name="notes" id="notes" rows="6"
                              placeholder="Contoh: Siswa menunjukkan hambatan X. Diberikan teknik Z. Perlu monitoring 1 minggu ke depan."
                              class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white">{{ old('notes', $session->notes) }}</textarea>
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
                
                <div class="flex items-center">
                    <input type="hidden" name="follow_up_required" value="0">
                    <input type="checkbox" name="follow_up_required" id="follow_up_required" value="1" {{ old('follow_up_required', $session->follow_up_required) ? 'checked' : '' }}
                           class="h-5 w-5 text-green-600 bg-gray-700 border-gray-600 rounded focus:ring-green-500">
                    <label for="follow_up_required" class="ml-2 text-sm font-medium text-gray-300">Perlu Tindak Lanjut (Follow Up Required)</label>
                </div>
            </section>
            
            {{-- Bagian IV: Topik Sesi (Dapat Diubah oleh BK) --}}
            <section>
                <h3 class="text-xl font-bold text-purple-400 mb-3 border-b border-gray-700 pb-2">Topik Sesi (Final)</h3>
                <div>
                    <label for="topic_ids" class="block text-sm font-medium text-gray-300 mb-2">Pilih Topik Konseling</label>
                    <select name="topic_ids[]" id="topic_ids" multiple required
                            class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white h-40">
                        @php
                            $selectedTopics = old('topic_ids', $session->topics->pluck('id')->toArray());
                        @endphp
                        @foreach ($topics as $topic)
                            <option value="{{ $topic->id }}" {{ in_array($topic->id, $selectedTopics) ? 'selected' : '' }}>
                                {{ $topic->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('topic_ids') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
            </section>

            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-700 mt-6">
                <a href="{{ route('admin.counseling_sessions.index') }}" 
                   class="py-2 px-4 border border-gray-600 rounded-lg text-gray-300 hover:bg-gray-700 transition">Batal</a>
                <button type="submit" 
                        class="py-2 px-4 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition duration-300">
                    Simpan & Perbarui Sesi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection