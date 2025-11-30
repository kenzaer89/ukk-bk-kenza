@extends('layouts.app')

@section('title', 'Edit Data Pelanggaran')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6 text-white">Edit Data Pelanggaran</h1>

    <div class="bg-gray-800 rounded-xl shadow-lg p-8 max-w-2xl">
        <form action="{{ route('admin.violations.update', $violation->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div>
                <label for="student_id" class="block text-sm font-medium text-gray-300 mb-2">Pilih Siswa</label>
                <select name="student_id" id="student_id" required
                        class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-red-500 focus:border-red-500 text-sm text-white">
                    <option value="">-- Pilih Siswa --</option>
                    @foreach ($students as $student)
                        <option value="{{ $student->id }}" {{ old('student_id', $violation->student_id) == $student->id ? 'selected' : '' }}>
                            {{ $student->name }} ({{ $student->nis }}) - {{ $student->schoolClass->name ?? 'Tanpa Kelas' }}
                        </option>
                    @endforeach
                </select>
                @error('student_id') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="rule_id" class="block text-sm font-medium text-gray-300 mb-2">Pilih Jenis Pelanggaran</label>
                <select name="rule_id" id="rule_id" required
                        class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-red-500 focus:border-red-500 text-sm text-white">
                    <option value="">-- Pilih Aturan Pelanggaran --</option>
                    @foreach ($rules as $rule)
                        <option value="{{ $rule->id }}" {{ old('rule_id', $violation->rule_id) == $rule->id ? 'selected' : '' }}>
                            {{ $rule->name }} (Poin: -{{ $rule->points }})
                        </option>
                    @endforeach
                </select>
                @error('rule_id') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>
            
            <div>
                <label for="violation_date" class="block text-sm font-medium text-gray-300 mb-2">Tanggal Pelanggaran</label>
                <input type="date" name="violation_date" id="violation_date" value="{{ old('violation_date', $violation->violation_date->format('Y-m-d')) }}" required
                       class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-red-500 focus:border-red-500 text-sm text-white">
                @error('violation_date') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-300 mb-2">Catatan Tambahan (Opsional)</label>
                <textarea name="description" id="description" rows="4"
                          class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-red-500 focus:border-red-500 text-sm text-white">{{ old('description', $violation->description) }}</textarea>
                @error('description') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-300 mb-2">Status</label>
                <select name="status" id="status" required
                        class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-red-500 focus:border-red-500 text-sm text-white">
                    <option value="pending" {{ old('status', $violation->status) == 'pending' ? 'selected' : '' }}>Pending (Menunggu Tindakan)</option>
                    <option value="resolved" {{ old('status', $violation->status) == 'resolved' ? 'selected' : '' }}>Resolved (Selesai)</option>
                    <option value="escalated" {{ old('status', $violation->status) == 'escalated' ? 'selected' : '' }}>Escalated (Diteruskan ke Pihak Lain)</option>
                </select>
                @error('status') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.violations.index') }}" 
                   class="py-2 px-4 border border-gray-600 rounded-lg text-gray-300 hover:bg-gray-700 transition">Batal</a>
                <button type="submit" 
                        class="py-2 px-4 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition duration-300">
                    Perbarui Pelanggaran
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
