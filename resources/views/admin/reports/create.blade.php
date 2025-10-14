@extends('layouts.app')
@section('title', 'Buat Laporan Bulanan')

@section('content')
<h1 class="text-2xl font-semibold text-white mb-6">Buat Laporan Bulanan</h1>

<form method="POST" action="{{ route('admin.reports.store') }}" class="space-y-4">
    @csrf
    <div>
        <label class="block text-gray-300">Bulan</label>
        <input type="text" name="bulan" placeholder="Contoh: Oktober" class="w-full glass p-2 rounded text-white" required>
    </div>
    <div>
        <label class="block text-gray-300">Tahun</label>
        <input type="number" name="tahun" value="{{ date('Y') }}" class="w-full glass p-2 rounded text-white" required>
    </div>
    <div>
        <label class="block text-gray-300">Total Sesi Konseling</label>
        <input type="number" name="total_sesi" class="w-full glass p-2 rounded text-white" required>
    </div>
    <div>
        <label class="block text-gray-300">Rangkuman / Tindakan</label>
        <textarea name="tindakan" rows="5" class="w-full glass p-2 rounded text-white" required></textarea>
    </div>
    <button type="submit" class="btn-primary">Simpan</button>
</form>
@endsection
