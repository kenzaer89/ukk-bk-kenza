@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="text-white">
    <h1 class="text-3xl font-semibold mb-4">Selamat Datang, Admin / Guru BK 👋</h1>
    <p class="text-gray-300 mb-8">Kelola pengguna, jadwal konseling, dan laporan di sini.</p>

    {{-- Statistik Utama --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="glass p-5 rounded-xl text-center">
            <h2 class="text-lg text-gray-300">Total Siswa</h2>
            <p class="text-3xl font-bold text-indigo-400 mt-2">124</p>
        </div>
        <div class="glass p-5 rounded-xl text-center">
            <h2 class="text-lg text-gray-300">Sesi Konseling</h2>
            <p class="text-3xl font-bold text-purple-400 mt-2">38</p>
        </div>
        <div class="glass p-5 rounded-xl text-center">
            <h2 class="text-lg text-gray-300">Pelanggaran</h2>
            <p class="text-3xl font-bold text-rose-400 mt-2">12</p>
        </div>
        <div class="glass p-5 rounded-xl text-center">
            <h2 class="text-lg text-gray-300">Laporan Bulanan</h2>
            <p class="text-3xl font-bold text-emerald-400 mt-2">6</p>
        </div>
    </div>

    {{-- Jadwal Konseling Terbaru --}}
    <div class="glass p-6 rounded-2xl mb-8">
        <h2 class="text-2xl font-semibold mb-4 text-indigo-300">📅 Jadwal Konseling Terbaru</h2>
        <table class="w-full text-left border-collapse text-gray-300">
            <thead>
                <tr class="text-sm uppercase text-gray-400 border-b border-gray-700">
                    <th class="py-2">Tanggal</th>
                    <th>Siswa</th>
                    <th>Topik</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b border-gray-800 hover:bg-white/5">
                    <td class="py-2">13 Okt 2025</td>
                    <td>Ahmad Rizky</td>
                    <td>Kedisiplinan</td>
                    <td><span class="text-emerald-400">Selesai</span></td>
                </tr>
                <tr class="border-b border-gray-800 hover:bg-white/5">
                    <td class="py-2">15 Okt 2025</td>
                    <td>Rani Putri</td>
                    <td>Motivasi belajar</td>
                    <td><span class="text-yellow-400">Menunggu</span></td>
                </tr>
                <tr class="hover:bg-white/5">
                    <td class="py-2">17 Okt 2025</td>
                    <td>Dewi Lestari</td>
                    <td>Masalah pertemanan</td>
                    <td><span class="text-indigo-400">Terjadwal</span></td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Laporan Singkat --}}
    <div class="glass p-6 rounded-2xl">
        <h2 class="text-2xl font-semibold mb-4 text-indigo-300">📊 Ringkasan Laporan Bulan Ini</h2>
        <p class="text-gray-300 leading-relaxed">
            Terdapat peningkatan <span class="text-emerald-400 font-semibold">25%</span> dalam jumlah sesi konseling dibandingkan bulan lalu.
            Mayoritas topik berkaitan dengan <span class="text-indigo-400 font-semibold">motivasi belajar</span> dan <span class="text-purple-400 font-semibold">kedisiplinan</span>.
        </p>
        <div class="mt-4">
            <a href="{{ route('admin.reports.index') }}" class="btn-primary inline-block">Lihat Detail Laporan</a>
        </div>
    </div>
</div>
@endsection
