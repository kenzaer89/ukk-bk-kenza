@extends('layouts.app')
@section('title', 'Edit Data Pelanggaran')

@section('content')
<h1 class="text-2xl font-semibold text-white mb-6">Edit Data Pelanggaran</h1>

<form method="POST" action="{{ route('admin.violations.update', $violation->id) }}" class="space-y-4">
    @csrf @method('PUT')
    <div>
        <label class="block text-gray-300">Jenis Pelanggaran</label>
        <input type="text" name="jenis" value="{{ $violation->jenis }}" class="w-full glass p-2 rounded text-white" required>
    </div>
    <div>
        <label class="block text-gray-300">Tingkat</label>
        <select name="tingkat" class="w-full glass p-2 rounded text-white">
            <option value="Ringan" {{ $violation->tingkat == 'Ringan' ? 'selected' : '' }}>Ringan</option>
            <option value="Sedang" {{ $violation->tingkat == 'Sedang' ? 'selected' : '' }}>Sedang</option>
            <option value="Berat" {{ $violation->tingkat == 'Berat' ? 'selected' : '' }}>Berat</option>
        </select>
    </div>
    <button type="submit" class="btn-primary">Perbarui</button>
</form>
@endsection
