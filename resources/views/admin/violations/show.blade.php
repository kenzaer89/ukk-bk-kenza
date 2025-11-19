@extends('layouts.app')

@section('title', 'Detail Pelanggaran')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6 text-white">Detail Pelanggaran</h1>

    <div class="bg-gray-800 rounded-xl shadow-lg p-8 max-w-2xl space-y-4">
        <div class="border-b border-gray-700 pb-3">
            <h2 class="text-xl font-bold text-red-400">Detail Pelanggaran #{{ $violation->id }}</h2>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-sm font-medium text-gray-400">Siswa</p>
                <p class="text-white text-lg font-semibold">{{ $violation->student->name ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-400">Kelas</p>
                <p class="text-white text-lg">{{ $violation->student->studentClass->name ?? 'N/A' }}</p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-700">
            <div>
                <p class="text-sm font-medium text-gray-400">Jenis Aturan</p>
                <p class="text-red-400 text-lg font-semibold">{{ $violation->rule->name ?? 'Aturan Dihapus' }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-400">Poin Pelanggaran</p>
                <p class="text-red-500 text-lg font-semibold">-{{ $violation->rule->points ?? 0 }}</p>
            </div>
        </div>

        <div class="pt-4 border-t border-gray-700">
            <p class="text-sm font-medium text-gray-400">Tanggal Pelanggaran</p>
            <p class="text-white text-lg">{{ \Carbon\Carbon::parse($violation->violation_date)->format('d F Y') }}</p>
        </div>

        <div class="pt-4 border-t border-gray-700">
            <p class="text-sm font-medium text-gray-400">Catatan Guru BK</p>
            <p class="text-white text-lg italic">{{ $violation->notes ?? '-' }}</p>
        </div>
    </div>

    <div class="mt-6 flex space-x-3">
        <a href="{{ route('admin.violations.edit', $violation) }}" 
           class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded-lg transition">Edit</a>
        <a href="{{ route('admin.violations.index') }}" 
           class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg transition">Kembali</a>
    </div>
</div>
@endsection