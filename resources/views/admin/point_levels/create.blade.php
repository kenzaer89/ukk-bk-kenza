@extends('layouts.app')

@section('title', 'Tambah Tingkat Poin')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6 text-white">➕ Tambah Ambang Batas Poin Baru</h1>

    <div class="bg-gray-800 rounded-xl shadow-lg p-8 max-w-xl">
        <form action="{{ route('admin.point_levels.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div>
                <label for="point_threshold" class="block text-sm font-medium text-gray-300 mb-2">Ambang Batas Poin Pelanggaran</label>
                <input type="number" name="point_threshold" id="point_threshold" value="{{ old('point_threshold') }}" required min="1"
                       placeholder="Contoh: 50"
                       class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-red-500 focus:border-red-500 text-sm text-white">
                <p class="mt-1 text-xs text-gray-400">Tindakan ini akan dipicu ketika total poin pelanggaran siswa mencapai atau melampaui angka ini.</p>
                @error('point_threshold') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="action" class="block text-sm font-medium text-gray-300 mb-2">Tindakan / Konsekuensi</label>
                <textarea name="action" id="action" rows="4" required
                          placeholder="Contoh: Panggilan orang tua, surat peringatan pertama."
                          class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-red-500 focus:border-red-500 text-sm text-white">{{ old('action') }}</textarea>
                @error('action') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end space-x-3 pt-4">
                <a href="{{ route('admin.point_levels.index') }}" 
                   class="py-2 px-4 border border-gray-600 rounded-lg text-gray-300 hover:bg-gray-700 transition">Batal</a>
                <button type="submit" 
                        class="py-2 px-4 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition duration-300">
                    Simpan Ambang Batas
                </button>
            </div>
        </form>
    </div>
</div>
@endsection