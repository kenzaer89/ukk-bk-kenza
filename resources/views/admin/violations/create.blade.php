@extends('layouts.app')
@section('title', 'Tambah Data Pelanggaran')

@section('content')
<h1 class="text-2xl font-semibold text-white mb-6">Tambah Pelanggaran</h1>

<form method="POST" action="{{ route('admin.violations.store') }}" class="space-y-4">
    @csrf
    <div>
        <label class="block text-gray-300">Tanggal</label>
        <input type="date" name="tanggal" class="w-full glass p-2 rounded text-white" required>
    </div>
    <div>
        <label class="block text-gray-300">Siswa</label>
        <select name="id_siswa" class="w-full glass p-2 rounded text-white">
            @foreach($students as $student)
                <option value="{{ $student->id }}">{{ $student->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-gray-300">Jenis Pelanggaran</label>
        <input type="text" name="jenis" class="w-full glass p-2 rounded text-white" required>
    </div>
    <div>
        <label class="block text-gray-300">Tingkat Pelanggaran</label>
        <select name="tingkat" class="w-full glass p-2 rounded text-white">
            <option value="Ringan">Ringan</option>
            <option value="Sedang">Sedang</option>
            <option value="Berat">Berat</option>
        </select>
    </div>
    <button type="submit" class="btn-primary">Simpan</button>
</form>
@endsection
