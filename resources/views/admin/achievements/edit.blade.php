@extends('layouts.app')

@section('title', 'Edit Prestasi')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6 text-white">✏️ Edit Prestasi Siswa</h1>

    <div class="bg-gray-800 rounded-xl shadow-lg p-8 max-w-xl">
        <form action="{{ route('admin.achievements.update', $achievement) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div>
                <label for="student_id" class="block text-sm font-medium text-gray-300 mb-2">Pilih Siswa</label>
                <select name="student_id" id="student_id" required
                        class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-yellow-500 focus:border-yellow-500 text-sm text-white">
                    <option value="">-- Cari Siswa --</option>
                    @foreach ($students as $student)
                        <option value="{{ $student->id }}" {{ old('student_id', $achievement->student_id) == $student->id ? 'selected' : '' }}>
                            {{ $student->name }} ({{ $student->nis }}) - {{ $student->schoolClass->name ?? 'Tanpa Kelas' }}
                        </option>
                    @endforeach
                </select>
                @error('student_id') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Nama Prestasi</label>
                <input type="text" name="name" id="name" value="{{ old('name', $achievement->name) }}" required
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
                            <option value="{{ $level }}" {{ old('level', $achievement->level) == $level ? 'selected' : '' }}>
                                {{ ucfirst($level) }}
                            </option>
                        @endforeach
                    </select>
                    @error('level') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="achievement_date" class="block text-sm font-medium text-gray-300 mb-2">Tanggal Dicapai (Opsional)</label>
                    <input type="date" name="achievement_date" id="achievement_date" value="{{ old('achievement_date', $achievement->achievement_date ? $achievement->achievement_date->format('Y-m-d') : null) }}"
                           class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white">
                    @error('achievement_date') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="point" class="block text-sm font-medium text-gray-300 mb-2">Poin Prestasi</label>
                <input type="number" name="point" id="point" value="{{ old('point', $achievement->point) }}" required min="1"
                       class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white">
                <p class="text-xs text-gray-400 mt-1">Mengubah poin akan menyesuaikan total poin siswa secara otomatis</p>
                @error('point') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-300 mb-2">Deskripsi Prestasi</label>
                <textarea name="description" id="description" rows="3" required
                          class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white">{{ old('description', $achievement->description) }}</textarea>
                @error('description') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end space-x-3 pt-4">
                <a href="{{ route('admin.achievements.index') }}" 
                   class="py-2 px-4 border border-gray-600 rounded-lg text-gray-300 hover:bg-gray-700 transition">Batal</a>
                <button type="submit" 
                        class="py-2 px-4 bg-yellow-600 text-white font-semibold rounded-lg hover:bg-yellow-700 transition duration-300">
                    Perbarui Prestasi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection