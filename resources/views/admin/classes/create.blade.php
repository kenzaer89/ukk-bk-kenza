
@extends('layouts.app')

@section('title', isset($class) ? 'Edit Kelas ' . $class->name : 'Tambah Kelas Baru')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6 text-white">{{ isset($class) ? 'Edit Kelas ' . $class->name : 'Tambah Kelas Baru' }}</h1>

    <div class="bg-gray-800 rounded-xl shadow-lg p-8 max-w-xl">
        <form action="{{ isset($class) ? route('admin.classes.update', $class) : route('admin.classes.store') }}" method="POST" class="space-y-6">
            @csrf
            @if (isset($class))
                @method('PUT')
            @endif
            
            <div>
                <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Nama Kelas (Contoh: X RPL 1)</label>
                <input type="text" name="name" id="name" value="{{ old('name', $class->name ?? '') }}" required
                       class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-green-500 focus:border-green-500 text-sm text-white">
                @error('name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="jurusan" class="block text-sm font-medium text-gray-300 mb-2">Jurusan (Contoh: Rekayasa Perangkat Lunak)</label>
                <input type="text" name="jurusan" id="jurusan" value="{{ old('jurusan', $class->jurusan ?? '') }}"
                       class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-green-500 focus:border-green-500 text-sm text-white">
                @error('jurusan') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="wali_kelas_id" class="block text-sm font-medium text-gray-300 mb-2">Wali Kelas</label>
                <select name="wali_kelas_id" id="wali_kelas_id"
                        class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-green-500 focus:border-green-500 text-sm text-white">
                    <option value="">-- Tidak Ada Wali Kelas --</option>
                    @foreach ($waliKelas as $wali)
                        <option value="{{ $wali->id }}" {{ old('wali_kelas_id', $class->wali_kelas_id ?? '') == $wali->id ? 'selected' : '' }}>
                            {{ $wali->name }}
                        </option>
                    @endforeach
                </select>
                @error('wali_kelas_id') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end space-x-3 pt-4">
                <a href="{{ route('admin.classes.index') }}" 
                   class="py-2 px-4 border border-gray-600 rounded-lg text-gray-300 hover:bg-gray-700 transition">Batal</a>
                <button type="submit" 
                        class="py-2 px-4 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition duration-300">
                    {{ isset($class) ? 'Perbarui Kelas' : 'Simpan Kelas' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection