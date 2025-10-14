@extends('layouts.app')
@section('title', 'Tambah Sesi Konseling')

@section('content')
<h1 class="text-2xl font-semibold text-white mb-6">Tambah Sesi Konseling</h1>

<form method="POST" action="{{ route('admin.sessions.store') }}" class="space-y-4">
    @csrf
    <div>
        <label class="block text-gray-300">Siswa</label>
        <select name="id_siswa" class="w-full glass p-2 rounded text-white">
            @foreach($students as $student)
                <option value="{{ $student->id }}">{{ $student->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-gray-300">Topik</label>
        <input type="text" name="topik" class="w-full glass p-2 rounded text-white" required>
    </div>
    <div>
        <label class="block text-gray-300">Tanggal</label>
        <input type="date" name="tanggal" class="w-full glass p-2 rounded text-white" required>
    </div>
    <div>
        <label class="block text-gray-300">Hasil Konseling</label>
        <textarea name="hasil" rows="4" class="w-full glass p-2 rounded text-white" required></textarea>
    </div>
    <button type="submit" class="btn-primary">Simpan</button>
</form>
@endsection
