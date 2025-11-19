@extends('layouts.app')

@section('title', 'Detail Sesi Konseling')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6 text-white">Detail Sesi Konseling #{{ $session->id }}</h1>

    <div class="bg-gray-800 rounded-xl shadow-lg p-8 max-w-4xl space-y-6">
        
        <div class="grid grid-cols-2 gap-4 border-b border-gray-700 pb-4">
            <div>
                <p class="text-sm font-medium text-gray-400">Siswa</p>
                <p class="text-white text-lg font-semibold">{{ $session->schedule->student->name ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-400">Guru BK</p>
                <p class="text-white text-lg">{{ $session->schedule->teacher->name ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-400">Tanggal Sesi</p>
                <p class="text-white text-lg">{{ $session->session_date->format('d F Y') }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-400">Jadwal Asal</p>
                <p class="text-white text-lg">ID #{{ $session->schedule->id }} ({{ \Carbon\Carbon::parse($session->schedule->start_time)->format('H:i') }})</p>
            </div>
        </div>

        <div>
            <p class="text-sm font-medium text-gray-400">Topik Dibahas</p>
            <div class="flex flex-wrap gap-2 mt-2">
                @forelse($session->topics as $topic)
                    <span class="bg-indigo-600 text-white text-xs font-semibold px-3 py-1 rounded-full">{{ $topic->name }}</span>
                @empty
                    <span class="text-gray-500 italic">Tidak ada topik dicatat.</span>
                @endforelse
            </div>
        </div>

        <div class="pt-4 border-t border-gray-700">
            <p class="text-sm font-medium text-gray-400">Catatan Guru BK</p>
            <pre class="whitespace-pre-wrap text-white bg-gray-700 p-3 rounded-lg mt-2">{{ $session->teacher_notes }}</pre>
        </div>

        <div class="pt-4 border-t border-gray-700">
            <p class="text-sm font-medium text-gray-400">Rekomendasi / Rencana Aksi</p>
            <pre class="whitespace-pre-wrap text-white bg-gray-700 p-3 rounded-lg mt-2">{{ $session->recommendations ?? 'Tidak ada rekomendasi tambahan.' }}</pre>
        </div>
        
        @if ($session->follow_up_date)
            <div class="pt-4 border-t border-gray-700">
                <p class="text-sm font-medium text-gray-400">Jadwal Tindak Lanjut</p>
                <p class="text-green-400 text-lg font-semibold">{{ $session->follow_up_date->format('d F Y') }}</p>
            </div>
        @endif
        
    </div>

    <div class="mt-6 flex space-x-3">
        <a href="{{ route('admin.sessions.edit', $session) }}" 
           class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded-lg transition">Edit Sesi</a>
        <a href="{{ route('admin.sessions.index') }}" 
           class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg transition">← Kembali ke Riwayat</a>
    </div>
</div>
@endsection