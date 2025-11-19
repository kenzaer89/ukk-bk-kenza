@extends('layouts.app')

@section('title', 'Detail Laporan Bulanan')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6 text-white">📊 Laporan BK Bulan {{ $monthly_report->report_date->isoFormat('MMMM Y') }}</h1>

    <div class="flex justify-between items-center mb-6">
        <a href="{{ route('admin.monthly_reports.index') }}" 
           class="py-2 px-4 border border-gray-600 rounded-lg text-gray-300 hover:bg-gray-700 transition">
            &larr; Kembali ke Daftar Laporan
        </a>
        <div class="space-x-2">
            <a href="{{ route('admin.monthly_reports.edit', $monthly_report) }}" 
               class="py-2 px-4 bg-yellow-600 text-white font-semibold rounded-lg hover:bg-yellow-700 transition">Edit Laporan</a>
            {{-- Tombol Cetak/PDF (Gunakan fungsi browser print) --}}
            <button class="py-2 px-4 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition print:hidden" onclick="window.print()">
                Cetak Laporan
            </button>
        </div>
    </div>

    <div class="bg-gray-800 rounded-xl shadow-lg p-8 space-y-8">
        
        {{-- Header Data --}}
        <div class="border-b border-gray-700 pb-4 text-sm">
            <p class="text-gray-400">Penyusun: <span class="text-white font-semibold">{{ $monthly_report->teacher->name ?? 'N/A' }}</span></p>
            <p class="text-gray-400">Tanggal Penyusunan: <span class="text-white">{{ $monthly_report->created_at->isoFormat('D MMMM Y') }}</span></p>
            <p class="text-gray-400">Status: 
                <span class="px-2 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full {{ $monthly_report->status === 'submitted' ? 'bg-green-600' : 'bg-yellow-600' }} text-white capitalize">
                    {{ $monthly_report->status }}
                </span>
            </p>
        </div>

        {{-- I. Ringkasan Manual --}}
        <section>
            <h2 class="text-2xl font-bold text-indigo-400 mb-4 border-b border-indigo-700 pb-2">I. Ringkasan Kegiatan (Input Manual)</h2>
            <div class="prose prose-invert max-w-none text-gray-300">
                <p>{!! nl2br(e($monthly_report->summary)) !!}</p>
            </div>
        </section>

        <hr class="border-gray-700">

        {{-- II. Statistik Pelanggaran --}}
        <section>
            <h2 class="text-2xl font-bold text-red-400 mb-4 border-b border-red-700 pb-2">II. Statistik Pelanggaran Siswa</h2>
            <div class="grid grid-cols-3 gap-6 text-center mb-6">
                <div class="bg-gray-700 p-4 rounded-lg shadow-md">
                    <p class="text-sm text-gray-400">Total Pelanggaran</p>
                    <p class="text-3xl font-extrabold text-red-500">{{ $violationStats['totalViolations'] }} Kasus</p>
                </div>
                <div class="bg-gray-700 p-4 rounded-lg shadow-md">
                    <p class="text-sm text-gray-400">Total Poin Terkumpul</p>
                    <p class="text-3xl font-extrabold text-red-500">{{ $violationStats['totalPoints'] }} Poin</p>
                </div>
                <div class="bg-gray-700 p-4 rounded-lg shadow-md">
                    <p class="text-sm text-gray-400">Rata-rata Poin per Pelanggaran</p>
                    <p class="text-3xl font-extrabold text-red-500">{{ number_format($violationStats['totalViolations'] > 0 ? $violationStats['totalPoints'] / $violationStats['totalViolations'] : 0, 1) }}</p>
                </div>
            </div>

            <h3 class="text-xl font-bold text-gray-300 mt-6 mb-3">5 Aturan Paling Sering Dilanggar:</h3>
            @if ($violationStats['topRules']->count() > 0)
                <ul class="space-y-2 list-disc list-inside bg-gray-700 p-4 rounded-lg">
                    @foreach ($violationStats['topRules'] as $ruleName => $count)
                        <li class="flex justify-between text-gray-300">
                            <span>{{ $loop->iteration }}. {{ $ruleName }}</span>
                            <span class="font-bold text-red-400">{{ $count }} kali</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500 italic">Tidak ada catatan pelanggaran di bulan ini.</p>
            @endif
        </section>

        <hr class="border-gray-700">

        {{-- III. Statistik Konseling --}}
        <section>
            <h2 class="text-2xl font-bold text-blue-400 mb-4 border-b border-blue-700 pb-2">III. Statistik Sesi Konseling</h2>
            
            <div class="grid grid-cols-2 gap-6 text-center mb-6">
                <div class="bg-gray-700 p-4 rounded-lg shadow-md">
                    <p class="text-sm text-gray-400">Total Sesi Konseling</p>
                    <p class="text-3xl font-extrabold text-blue-500">{{ $sessionStats['totalSessions'] }} Sesi</p>
                </div>
                <div class="bg-gray-700 p-4 rounded-lg shadow-md">
                    <p class="text-sm text-gray-400">Pembagian Tipe Sesi</p>
                    <ul class="text-left mt-2 space-y-1 text-gray-300">
                        @forelse ($sessionStats['sessionTypes'] as $type => $count)
                            <li>{{ ucfirst($type) }}: <span class="font-bold">{{ $count }}</span></li>
                        @empty
                            <li><span class="text-gray-500 italic">Tidak ada sesi tercatat.</span></li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </section>

        <hr class="border-gray-700">
        
        {{-- IV. Dampak Siswa --}}
        <section>
            <h2 class="text-2xl font-bold text-yellow-400 mb-4 border-b border-yellow-700 pb-2">IV. Dampak Siswa (5 Siswa Poin Pelanggaran Terbanyak)</h2>
            
            @if ($topViolatingStudents->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full leading-normal bg-gray-700 rounded-lg">
                        <thead>
                            <tr class="text-xs font-semibold tracking-wider text-left text-gray-400 uppercase border-b border-gray-600">
                                <th class="px-5 py-3">Peringkat</th>
                                <th class="px-5 py-3">Nama Siswa</th>
                                <th class="px-5 py-3">Kelas</th>
                                <th class="px-5 py-3 text-right">Total Poin Bulan Ini</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($topViolatingStudents as $item)
                                <tr class="border-b border-gray-600 last:border-b-0">
                                    <td class="px-5 py-4 text-sm font-bold text-yellow-400">{{ $loop->iteration }}</td>
                                    <td class="px-5 py-4 text-sm text-white">{{ $item->student->name ?? 'N/A' }}</td>
                                    <td class="px-5 py-4 text-sm text-gray-300">{{ $item->student->studentClass->name ?? '-' }}</td>
                                    <td class="px-5 py-4 text-sm font-extrabold text-red-500 text-right">{{ $item->total_points_deducted }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 italic">Tidak ada siswa yang tercatat melakukan pelanggaran signifikan di bulan ini.</p>
            @endif
        </section>

    </div>
</div>
@endsection