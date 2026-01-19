@extends('layouts.app')

@section('title', 'Catat Prestasi Baru')

@section('content')
<div class="p-6">
    <div class="flex items-center gap-4 mb-6">
        <span class="p-2 bg-indigo-500/20 rounded-lg">
            <svg class="w-8 h-8 text-brand-teal" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
            </svg>
        </span>
        <h1 class="text-3xl font-bold text-white uppercase tracking-tight">Catat Prestasi Siswa</h1>
    </div>

    <div class="bg-gray-800 rounded-xl shadow-lg p-8 max-w-xl">
        <form action="{{ route('admin.achievements.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div>
                <label for="student_id" class="block text-sm font-medium text-gray-300 mb-2">Pilih Siswa <span class="text-red-500">*</span></label>
                <select name="student_id" id="student_id" required
                        oninvalid="this.setCustomValidity('Silakan pilih siswa dalam daftar')"
                        oninput="this.setCustomValidity('')"
                        class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-green-500 focus:border-green-500 text-sm text-white">
                    <option value="">-- Cari Siswa --</option>
                    @foreach ($students as $student)
                        <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                            {{ $student->name }} (Absen: {{ $student->absen ?? '-' }}) - {{ $student->schoolClass->name ?? 'Tanpa Kelas' }}
                        </option>
                    @endforeach
                </select>
                @error('student_id') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Nama Prestasi <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                       placeholder="Contoh: Juara 1 Lomba Sains Tingkat Nasional"
                       oninvalid="this.setCustomValidity('Harap isi nama prestasi')"
                       oninput="this.setCustomValidity('')"
                       class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white focus:ring-green-500 focus:border-green-500">
                @error('name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="level" class="block text-sm font-medium text-gray-300 mb-2">Tingkat Prestasi <span class="text-red-500">*</span></label>
                    <select name="level" id="level" required
                            oninvalid="this.setCustomValidity('Pilih tingkat prestasi')"
                            oninput="this.setCustomValidity('')"
                            class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white focus:ring-green-500 focus:border-green-500">
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
                    <label for="achievement_date" class="block text-sm font-medium text-gray-300 mb-2">Tanggal Dicapai <span class="text-red-500">*</span></label>
                    <input type="date" name="achievement_date" id="achievement_date" value="{{ old('achievement_date') }}" required
                           max="{{ date('Y-m-d') }}"
                           style="color-scheme: dark;"
                           oninvalid="this.setCustomValidity('Pilih tanggal pencapaian prestasi')"
                           oninput="this.setCustomValidity('')"
                           class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white focus:ring-green-500 focus:border-green-500">
                    @error('achievement_date') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="point" class="block text-sm font-medium text-gray-300 mb-2">Poin Prestasi</label>
                <input type="number" name="point" id="point" value="{{ old('point') }}" min="0" max="150"
                       placeholder="Contoh: 10 (Kosongkan jika tidak ada poin)"
                       oninvalid="this.setCustomValidity('Masukkan jumlah poin (0-150)')"
                       oninput="this.setCustomValidity('')"
                       class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white focus:ring-green-500 focus:border-green-500">
                <p class="text-xs text-gray-400 mt-1 italic">Opsional: Poin akan ditambahkan ke total poin siswa</p>
                @error('point') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-300 mb-2">Deskripsi Prestasi <span class="text-red-500">*</span></label>
                <textarea name="description" id="description" rows="3" required maxlength="500"
                          placeholder="Jelaskan detail prestasi yang diraih..."
                          oninvalid="this.setCustomValidity('Harap isi deskripsi prestasi')"
                          oninput="this.setCustomValidity('')"
                          class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white">{{ old('description') }}</textarea>
                @error('description') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
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