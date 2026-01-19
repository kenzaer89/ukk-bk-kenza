@extends('layouts.app')

@section('title', 'Ajukan Permintaan Konseling')

@section('content')
<div class="min-h-screen p-6">
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('student.counseling_requests.index') }}" class="inline-flex items-center text-brand-teal hover:text-brand-teal/80 transition-colors mb-4">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
        <h1 class="text-3xl font-bold text-brand-light mb-2 flex items-center gap-3">
            <span class="p-2 bg-indigo-500/20 rounded-lg">
                <svg class="w-8 h-8 text-brand-teal" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </span> Ajukan Permintaan Konseling
        </h1>
        <p class="text-brand-light/60">Sampaikan kebutuhan konseling Anda kepada Guru BK</p>
    </div>

    <!-- Form Card -->
    <div class="max-w-2xl">
        <div class="bg-gray-800 rounded-2xl border border-brand-light/10 p-8 shadow-2xl">
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-500/10 border border-red-500/30 rounded-xl">
                    <ul class="text-red-400 text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('student.counseling_requests.store') }}" class="space-y-6">
                @csrf

                <!-- Topic Selection -->
                <div>
                    <label for="topic_id" class="block text-brand-light font-bold text-sm uppercase tracking-wider mb-2">
                        Topik Konseling <span class="text-red-500">*</span>
                    </label>
                    <select 
                        id="topic_id" 
                        name="topic_id" 
                        required
                        class="w-full px-4 py-3 bg-brand-dark/50 border border-brand-light/10 rounded-xl text-brand-light focus:outline-none focus:border-brand-teal/50 focus:ring-2 focus:ring-brand-teal/20 transition-all font-medium"
                    >
                        <option value="">-- Pilih Topik --</option>
                        <option value="custom" {{ old('topic_id') == 'custom' ? 'selected' : '' }}>-- Custom: Buat Topik Baru --</option>
                        @foreach ($topics as $topic)
                            <option value="{{ $topic->id }}" {{ old('topic_id') == $topic->id ? 'selected' : '' }}>
                                {{ $topic->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Custom Topic Field (Hidden by default) -->
                <div id="custom-topic-field" class="hidden">
                    <label for="custom_topic_name" class="block text-brand-light font-bold text-sm uppercase tracking-wider mb-2">
                        Nama Topik Baru <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="custom_topic_name" 
                        name="custom_topic_name" 
                        value="{{ old('custom_topic_name') }}"
                        maxlength="50"
                        class="w-full px-4 py-3 bg-brand-dark/50 border border-brand-light/10 rounded-xl text-brand-light placeholder-brand-light/40 focus:outline-none focus:border-brand-teal/50 focus:ring-2 focus:ring-brand-teal/20 transition-all font-medium"
                        placeholder="Masukkan nama topik konseling baru..."
                    >
                    <p class="mt-2 text-[10px] text-brand-light/40 uppercase tracking-widest font-bold">Maksimal 50 karakter</p>
                </div>

                <!-- Reason -->
                <div>
                    <label for="reason" class="block text-brand-light font-bold text-sm uppercase tracking-wider mb-2">
                        Alasan Permintaan Konseling <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        id="reason" 
                        name="reason" 
                        rows="6" 
                        required
                        class="w-full px-4 py-3 bg-brand-dark/50 border border-brand-light/10 rounded-xl text-brand-light placeholder-brand-light/40 focus:outline-none focus:border-brand-teal/50 focus:ring-2 focus:ring-brand-teal/20 transition-all font-medium"
                        placeholder="Jelaskan alasan Anda membutuhkan konseling..."
                    >{{ old('reason') }}</textarea>
                    <p class="mt-2 text-[10px] text-brand-light/40 uppercase tracking-widest font-bold">Maksimal 500 karakter</p>
                </div>

                <!-- Info Box -->
                <div class="p-5 bg-brand-teal/5 border border-brand-teal/20 rounded-xl">
                    <div class="flex flex-col gap-3">
                        <svg class="w-6 h-6 text-brand-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        
                        <div class="text-sm">
                            <p class="font-bold text-brand-teal uppercase tracking-widest text-xs mb-2">Informasi Penting:</p>
                            <ul class="space-y-1.5 text-brand-light/60">
                                <li class="flex items-center gap-2"><span class="w-1 h-1 rounded-full bg-brand-teal"></span> Permintaan akan ditinjau oleh Guru BK</li>
                                <li class="flex items-center gap-2"><span class="w-1 h-1 rounded-full bg-brand-teal"></span> Anda akan dihubungi untuk penjadwalan</li>
                                <li class="flex items-center gap-2"><span class="w-1 h-1 rounded-full bg-brand-teal"></span> Semua informasi bersifat rahasia</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex flex-col sm:flex-row gap-4 pt-4">
                    <button 
                        type="submit" 
                        onclick="return confirmAction(event, 'Konfirmasi Pengiriman', 'Apakah Anda yakin ingin mengirim permintaan konseling ini?', 'question', 'Ya, Kirim', 'Batal')"
                        class="flex-1 px-8 py-4 bg-brand-teal text-brand-dark rounded-xl font-bold hover:bg-[#5a8e91] transition-all shadow-[0_0_20px_rgba(118,171,174,0.3)] hover:shadow-[0_0_30px_rgba(118,171,174,0.5)] transform hover:-translate-y-0.5 active:scale-95"
                    >
                        Kirim Permintaan
                    </button>
                    <a 
                        href="{{ route('student.counseling_requests.index') }}" 
                        class="px-8 py-4 bg-brand-light/5 border border-brand-light/10 text-brand-light rounded-xl font-bold hover:bg-brand-light/10 transition-all text-center"
                    >
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const topicSelect = document.getElementById('topic_id');
        const customTopicField = document.getElementById('custom-topic-field');
        const customTopicInput = document.getElementById('custom_topic_name');

        function toggleCustomTopic() {
            if (topicSelect.value === 'custom') {
                customTopicField.classList.remove('hidden');
                customTopicInput.required = true;
            } else {
                customTopicField.classList.add('hidden');
                customTopicInput.required = false;
            }
        }

        // Run on load to handle old input or pre-selection
        toggleCustomTopic();

        // Run on change
        topicSelect.addEventListener('change', toggleCustomTopic);
    });
</script>
@endpush