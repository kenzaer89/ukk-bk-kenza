@extends('layouts.app')

@section('title', 'Ajukan Permintaan Konseling')

@section('content')
<div class="min-h-screen bg-brand-dark p-6">
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('student.counseling_requests.index') }}" class="inline-flex items-center text-brand-teal hover:text-brand-teal/80 transition-colors mb-4">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
        <h1 class="text-3xl font-bold text-brand-light mb-2">Ajukan Permintaan Konseling</h1>
        <p class="text-brand-light/60">Sampaikan kebutuhan konseling Anda kepada Guru BK</p>
    </div>

    <!-- Form Card -->
    <div class="max-w-2xl">
        <div class="bg-brand-gray rounded-xl border border-brand-light/10 p-8">
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-500/10 border border-red-500/30 rounded-lg">
                    <ul class="text-red-400 text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('student.counseling_requests.store') }}" class="space-y-6">
                @csrf

                <!-- Reason -->
                <div>
                    <label for="reason" class="block text-brand-light font-medium mb-2">
                        Alasan Permintaan Konseling <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        id="reason" 
                        name="reason" 
                        rows="6" 
                        required
                        class="w-full px-4 py-3 bg-brand-dark border border-brand-light/10 rounded-lg text-brand-light placeholder-brand-light/40 focus:outline-none focus:border-brand-teal/50 focus:ring-2 focus:ring-brand-teal/20 transition-all"
                        placeholder="Jelaskan alasan Anda membutuhkan konseling..."
                    >{{ old('reason') }}</textarea>
                    <p class="mt-2 text-sm text-brand-light/50">Maksimal 500 karakter</p>
                </div>

                <!-- Info Box -->
                <div class="p-4 bg-brand-teal/10 border border-brand-teal/30 rounded-lg">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-brand-teal flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="text-sm text-brand-teal">
                            <p class="font-medium mb-1">Informasi Penting:</p>
                            <ul class="list-disc list-inside space-y-1 text-brand-teal/80">
                                <li>Permintaan akan ditinjau oleh Guru BK</li>
                                <li>Anda akan dihubungi untuk penjadwalan</li>
                                <li>Semua informasi bersifat rahasia</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex gap-4">
                    <button 
                        type="submit" 
                        class="flex-1 px-6 py-3 bg-brand-teal text-brand-dark rounded-lg font-bold hover:bg-[#5a8e91] transition-all shadow-[0_0_20px_rgba(118,171,174,0.3)] hover:shadow-[0_0_30px_rgba(118,171,174,0.5)] transform hover:-translate-y-0.5"
                    >
                        Kirim Permintaan
                    </button>
                    <a 
                        href="{{ route('student.counseling_requests.index') }}" 
                        class="px-6 py-3 bg-brand-dark border border-brand-light/10 text-brand-light rounded-lg font-medium hover:bg-brand-dark/80 hover:border-brand-teal/30 transition-all text-center"
                    >
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection