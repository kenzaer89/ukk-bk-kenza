@extends('layouts.app')

@section('title', 'Edit Aturan Pelanggaran ' . $rule->name)

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6 text-white">Edit Aturan Pelanggaran: {{ $rule->name }}</h1>

    <div class="bg-gray-800 rounded-xl shadow-lg p-8 max-w-xl">
        <form action="{{ route('admin.rules.update', $rule) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div>
                <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Nama Aturan</label>
                <input type="text" name="name" id="name" value="{{ old('name', $rule->name) }}" required
                       class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-red-500 focus:border-red-500 text-sm text-white">
                @error('name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="points" class="block text-sm font-medium text-gray-300 mb-2">Poin Dikurangi</label>
                    <input type="number" name="points" id="points" value="{{ old('points', $rule->points) }}" required min="1"
                           class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-red-500 focus:border-red-500 text-sm text-white">
                    @error('points') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-300 mb-2">Kategori</label>
                    <select name="category" id="category"
                            class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-red-500 focus:border-red-500 text-sm text-white">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category }}" {{ old('category', $rule->category) == $category ? 'selected' : '' }}>
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>
                    @error('category') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-300 mb-2">Deskripsi Detail (Opsional)</label>
                <textarea name="description" id="description" rows="3"
                          class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-red-500 focus:border-red-500 text-sm text-white">{{ old('description', $rule->description) }}</textarea>
                @error('description') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end space-x-3 pt-4">
                <a href="{{ route('admin.rules.index') }}" 
                   class="py-2 px-4 border border-gray-600 rounded-lg text-gray-300 hover:bg-gray-700 transition">Batal</a>
                <button type="submit" 
                        class="py-2 px-4 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition duration-300">
                    Perbarui Aturan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection