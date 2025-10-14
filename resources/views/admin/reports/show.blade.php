@extends('layouts.app')
@section('title', 'Detail Laporan')

@section('content')
<h1 class="text-2xl font-semibold text-white mb-6">📄 Detail Laporan Bulan {{ $report->bulan }}</h1>

<div class="space-y-4 text-gray-300">
    <p><strong>Bulan:</strong> {{ $report->bulan }}</p>
    <p><strong>Tahun:</strong> {{ $report->tahun }}</p>
    <p><strong>Total Sesi:</strong> {{ $report->total_sesi }}</p>
    <div>
        <strong>Rangkuman / Tindakan:</strong>
        <p class="glass p-4 rounded-xl mt-2">{{ $report->tindakan }}</p>
    </div>
</div>

<div class="mt-6">
    <a href="{{ route('admin.reports.index') }}" class="btn-primary">⬅ Kembali</a>
</div>
@endsection
