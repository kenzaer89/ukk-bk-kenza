@extends('layouts.app')

@section('title','Detail Permintaan Konseling')

@section('content')
<div class="max-w-3xl mx-auto">
  <div class="bg-white p-6 rounded shadow">
    <h2 class="text-lg font-semibold mb-4">Detail Permintaan Konseling</h2>

    <div class="space-y-3 text-sm">
      <div><strong>ID:</strong> {{ $requestItem->id }}</div>
      <div><strong>Nama Siswa:</strong> {{ $requestItem->student_name ?? 'Tidak diketahui' }}</div>
      <div><strong>Alasan:</strong> {{ $requestItem->reason }}</div>
      <div><strong>Status:</strong> 
        <span class="px-2 py-1 rounded text-xs bg-gray-100">{{ $requestItem->status }}</span>
      </div>
      <div><strong>Waktu Permintaan:</strong> {{ \Carbon\Carbon::parse($requestItem->requested_at)->translatedFormat('H:i d F Y') }}</div>
    </div>

    <div class="mt-6 flex gap-3 justify-end">
      @if($requestItem->status == 'pending')
      <form method="POST" action="{{ route('counseling.approve', $requestItem->id) }}">
        @csrf
        <button class="px-4 py-2 bg-green-600 text-white rounded">Setujui</button>
      </form>

      <form method="POST" action="{{ route('counseling.reject', $requestItem->id) }}">
        @csrf
        <button class="px-4 py-2 bg-red-600 text-white rounded">Tolak</button>
      </form>
      @endif

      <a href="{{ route('counseling.requests') }}" class="px-4 py-2 bg-gray-100 rounded">Kembali</a>
    </div>
  </div>
</div>
@endsection
