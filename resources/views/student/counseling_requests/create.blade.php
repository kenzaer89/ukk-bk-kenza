@extends('layouts.app')

@section('title', 'Ajukan Permintaan Konseling')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6 text-white">✉️ Ajukan Permintaan Konseling Baru</h1>

    <div class="bg-gray-800 rounded-xl shadow-lg p-8 max-w-xl">
        <form action="{{ route('student.counseling_requests.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="bg-blue-900/50 p-4 rounded-lg border-l-4 border-blue-400">
                <p class="text-sm text-blue-300">Permintaan ini akan diteruskan ke Guru BK. Anda akan menerima notifikasi jika sesi sudah dijadwalkan.</p>
            </div>

            <div>
                <label for="request_reason" class="block text-sm font-medium text-gray-300 mb-2">Jelaskan Alasan Permintaan Konseling Anda (Singkat)</label>
                <textarea name="request_reason" id="request_reason" rows="4" required
                          placeholder="Contoh: Saya kesulitan mengatur waktu belajar sehingga nilai saya menurun."
                          class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white focus:ring-blue-500 focus:border-blue-500">{{ old('request_reason') }}</textarea>
                @error('request_reason') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>
            
            <div>
                <label for="topic_ids" class="block text-sm font-medium text-gray-300 mb-2">Pilih Topik Konseling yang Relevan (Bisa lebih dari satu)</label>
                <select name="topic_ids[]" id="topic_ids" multiple required
                        class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white focus:ring-blue-500 focus:border-blue-500 h-40">
                    @foreach ($topics as $topic)
                        <option value="{{ $topic->id }}" {{ in_array($topic->id, old('topic_ids', [])) ? 'selected' : '' }}>
                            {{ $topic->name }}
                        </option>
                    @endforeach
                </select>
                @error('topic_ids') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                @error('topic_ids.*') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>


            <div class="flex justify-end space-x-3 pt-4">
                <a href="{{ route('student.counseling_requests.index') }}" 
                   class="py-2 px-4 border border-gray-600 rounded-lg text-gray-300 hover:bg-gray-700 transition">Batal</a>
                <button type="submit" 
                        class="py-2 px-4 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition duration-300">
                    Kirim Permintaan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection