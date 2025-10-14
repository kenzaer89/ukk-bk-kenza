@extends('layouts.app')
@section('title', 'Edit Sesi Konseling')

@section('content')
<h1 class="text-2xl font-semibold text-white mb-6">Edit Sesi Konseling</h1>

<form method="POST" action="{{ route('admin.sessions.update', $session->id) }}" class="space-y-4">
    @csrf @method('PUT')
    <div>
        <label class="block text-gray-300">Topik</label>
        <input type="text" name="topik" value="{{ $session->topik }}" class="w-full glass p-2 rounded text-white">
    </div>
    <div>
        <label class="block text-gray-300">Tanggal</label>
        <input type="date" name="tanggal" value="{{ $session->tanggal }}" class="w-full glass p-2 rounded text-white">
    </div>
    <div>
        <label class="block text-gray-300">Hasil Konseling</label>
        <textarea name="hasil" rows="4" class="w-full glass p-2 rounded text-white">{{ $session->hasil }}</textarea>
    </div>
    <button type="submit" class="btn-primary">Perbarui</button>
</form>
@endsection
