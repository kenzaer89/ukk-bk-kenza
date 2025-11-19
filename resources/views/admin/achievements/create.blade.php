@extends('layouts.app')

@section('title', 'Catat Prestasi Baru')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6 text-white">➕ Catat Prestasi Siswa</h1>

    <div class="bg-gray-800 rounded-xl shadow-lg p-8 max-w-xl">
        <form action="{{ route('admin.achievements.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div>
                <label for="student_id" class="block text-sm font-medium text-gray-300 mb-2">Pilih Siswa</label>
                <select name="student_id" id="student_id" required
                        class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-green-500 focus:border-green-500 text-sm text-white">
                    <option value="">-- Cari Siswa --</option>
                    @foreach ($students as $student)
                        <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                            {{ $student->name }} ({{ $student->nis }}) - {{ $student->studentClass->name ?? 'Tanpa Kelas' }}
                        </option>
                    @endforeach
                </select>
                @error('student_id') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Nama Prestasi</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                       placeholder="Contoh: Juara 1 Lomba Sains Tingkat Nasional"
                       class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white">
                @error('name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="level" class="block text-sm font-medium text-gray-300 mb-2">Tingkat Prestasi</label>
                    <select name="level" id="level" required
                            class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white">
                        <option value="">-- Pilih Tingkat --</option>
                        @foreach ($levels as $level)
                            <option value="{{ $level }}" {{ old('level') == $level ? 'selected' : '' }}>
                                {{ ucfirst($level) }}
                            </option>
                        @endforeach
                    </select>
                    @error('level') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="achievement_date" class="block text-sm font-medium text-gray-300 mb-2">Tanggal Dicapai (Opsional)</label>
                    <input type="date" name="achievement_date" id="achievement_date" value="{{ old('achievement_date') }}"
                           class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white">
                    @error('achievement_date') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="notes" class="block text-sm font-medium text-gray-300 mb-2">Catatan (Opsional)</label>
                <textarea name="notes" id="notes" rows="3"
                          class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white">{{ old('notes') }}</textarea>
                @error('notes') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end space-x-3 pt-4">
                <a href="{{ route('admin.achievements.index') }}" 
                   class="py-2 px-4 border border-gray-600 rounded-lg text-gray-300 hover:bg-gray-700 transition">Batal</a>
                <button type="submit" 
                        class="py-2 px-4 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition duration-300">
                    Simpan Prestasi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection