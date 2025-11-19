@extends('layouts.app')

@section('title', 'Detail Permintaan Konseling')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6 text-white">Detail Permintaan Konseling #{{ $request->id }}</h1>

    <div class="bg-gray-800 rounded-xl shadow-lg p-8 max-w-3xl space-y-4">
        
        <div class="grid grid-cols-2 gap-4 pb-4 border-b border-gray-700">
            <div>
                <p class="text-sm font-medium text-gray-400">Status</p>
                @php
                    $colorClass = [
                        'pending' => 'bg-yellow-600',
                        'approved' => 'bg-green-600',
                        'rejected' => 'bg-red-600',
                    ][$request->status] ?? 'bg-gray-600';
                @endphp
                <span class="{{ $colorClass }} text-white text-sm font-bold px-3 py-1 rounded-full uppercase">{{ $request->status }}</span>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-400">Diajukan Pada</p>
                <p class="text-white text-lg">{{ $request->requested_at->format('d F Y, H:i') }}</p>
            </div>
        </div>

        <div class="pt-4">
            <p class="text-sm font-medium text-gray-400">Guru BK yang Menangani</p>
            <p class="text-white text-lg font-semibold">{{ $request->teacher->name ?? 'Belum Ditentukan' }}</p>
        </div>

        <div class="pt-4 border-t border-gray-700">
            <p class="text-sm font-medium text-gray-400">Alasan Permintaan (Topik/Deskripsi)</p>
            <pre class="whitespace-pre-wrap text-white bg-gray-700 p-3 rounded-lg mt-2 italic">{{ $request->reason ?? 'Tidak ada alasan.' }}</pre>
        </div>
        
        @if ($request->status === 'approved' && $request->schedule)
            <div class="pt-4 border-t border-indigo-700 bg-indigo-900/50 p-4 rounded-lg">
                <h3 class="text-lg font-bold text-indigo-400 mb-2">✅ Jadwal Konseling Telah Ditetapkan</h3>
                <p class="text-sm font-medium text-gray-300">Tanggal:</p>
                <p class="text-white text-lg font-semibold">{{ \Carbon\Carbon::parse($request->schedule->scheduled_date)->format('d F Y') }}</p>
                <p class="text-sm font-medium text-gray-300">Waktu:</p>
                <p class="text-white text-lg font-semibold">{{ \Carbon\Carbon::parse($request->schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($request->schedule->end_time)->format('H:i') }}</p>
            </div>
        @endif
        
    </div>

    <div class="mt-6">
        <a href="{{ route('student.requests.index') }}" 
           class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg transition">← Kembali ke Daftar Permintaan</a>
    </div>
</div>
@endsection