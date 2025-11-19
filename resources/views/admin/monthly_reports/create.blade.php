@extends('layouts.app')

@section('title', 'Buat Laporan Bulanan Baru')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6 text-white">📝 Buat Laporan Bulanan</h1>

    <div class="bg-gray-800 rounded-xl shadow-lg p-8 max-w-xl">
        @if (session('error'))
            <div class="bg-red-500 p-4 rounded-lg mb-6 text-white">{{ session('error') }}</div>
        @endif
        
        <form action="{{ route('admin.monthly_reports.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="month" class="block text-sm font-medium text-gray-300 mb-2">Bulan</label>
                    <select name="month" id="month" required
                            class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white">
                        <option value="">-- Pilih Bulan --</option>
                        @foreach ($months as $num => $name)
                            <option value="{{ $num }}" {{ old('month', now()->month) == $num ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                    @error('month') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="year" class="block text-sm font-medium text-gray-300 mb-2">Tahun</label>
                    <select name="year" id="year" required
                            class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white">
                        @foreach ($years as $year)
                            <option value="{{ $year }}" {{ old('year', now()->year) == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                    @error('year') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="summary" class="block text-sm font-medium text-gray-300 mb-2">Ringkasan Kegiatan BK Bulan Ini</label>
                <textarea name="summary" id="summary" rows="8" required
                          placeholder="Tulis ringkasan laporan di sini, meliputi evaluasi, intervensi, dan rekomendasi bulanan."
                          class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white">{{ old('summary') }}</textarea>
                @error('summary') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-300 mb-2">Status Laporan</label>
                <select name="status" id="status" required
                        class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white">
                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draf (Belum Selesai)</option>
                    <option value="submitted" {{ old('status') == 'submitted' ? 'selected' : '' }}>Kirim (Siap Dievaluasi)</option>
                </select>
                @error('status') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end space-x-3 pt-4">
                <a href="{{ route('admin.monthly_reports.index') }}" 
                   class="py-2 px-4 border border-gray-600 rounded-lg text-gray-300 hover:bg-gray-700 transition">Batal</a>
                <button type="submit" 
                        class="py-2 px-4 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition duration-300">
                    Simpan Laporan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection