@extends('layouts.app')

@section('title', 'Tambah Topik Konseling')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6 text-white">➕ Tambah Topik Konseling Baru</h1>

    <div class="bg-gray-800 rounded-xl shadow-lg p-8 max-w-xl">
        <form action="{{ route('admin.topics.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div>
                <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Nama Topik (Contoh: Masalah Belajar)</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                       class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white focus:ring-blue-500 focus:border-blue-500">
                @error('name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-300 mb-2">Deskripsi (Opsional)</label>
                <textarea name="description" id="description" rows="3"
                          class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white focus:ring-blue-500 focus:border-blue-500">{{ old('description') }}</textarea>
                @error('description') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end space-x-3 pt-4">
                <a href="{{ route('admin.topics.index') }}" 
                   class="py-2 px-4 border border-gray-600 rounded-lg text-gray-300 hover:bg-gray-700 transition">Batal</a>
                <button type="submit" 
                        class="py-2 px-4 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition duration-300">
                    Simpan Topik
                </button>
            </div>
        </form>
    </div>
</div>
@endsection