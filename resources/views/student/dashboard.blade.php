@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-bold text-white mb-2">Halo, {{ Auth::user()->name }}</h2>
    <p class="text-gray-400">Selamat datang di dashboard siswa BK System.</p>
</div>

<!-- STATISTICS CARDS -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Sesi Terjadwal -->
    <div class="bg-gray-800 rounded-lg p-6 shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-400 text-sm">Sesi Terjadwal</p>
                <p class="text-3xl font-bold text-blue-400">{{ $stats['scheduled_sessions'] }}</p>
            </div>
            <i class="fas fa-calendar-check text-blue-400 text-2xl"></i>
        </div>
    </div>

    <!-- Permintaan Pending -->
    <div class="bg-gray-800 rounded-lg p-6 shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-400 text-sm">Permintaan Pending</p>
                <p class="text-3xl font-bold text-yellow-400">{{ $stats['pending_requests'] }}</p>
            </div>
            <i class="fas fa-clock text-yellow-400 text-2xl"></i>
        </div>
    </div>

    <!-- Pelanggaran -->
    <div class="bg-gray-800 rounded-lg p-6 shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-400 text-sm">Pelanggaran</p>
                <p class="text-3xl font-bold text-red-400">{{ $stats['violations'] }}</p>
            </div>
            <i class="fas fa-exclamation-triangle text-red-400 text-2xl"></i>
        </div>
    </div>

    <!-- Prestasi -->
    <div class="bg-gray-800 rounded-lg p-6 shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-400 text-sm">Prestasi</p>
                <p class="text-3xl font-bold text-green-400">{{ $stats['achievements'] }}</p>
            </div>
            <i class="fas fa-trophy text-green-400 text-2xl"></i>
        </div>
    </div>
</div>

<!-- MAIN CONTENT -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    
    <!-- JADWAL KONSELING MENDATANG -->
    <div class="bg-gray-800 rounded-lg p-6 shadow-lg">
        <h3 class="text-xl font-bold text-white mb-4 flex items-center">
            <i class="fas fa-calendar-alt mr-2 text-blue-400"></i>
            Jadwal Konseling Mendatang
        </h3>
        
        @if($upcomingSessions->count() > 0)
        <div class="space-y-3">
            @foreach($upcomingSessions as $session)
            <div class="bg-gray-700 p-4 rounded-lg">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="font-semibold text-white">{{ $session->scheduled_date->format('d M Y') }}</p>
                        <p class="text-sm text-gray-300">Dengan: {{ $session->teacher->name }}</p>
                        <p class="text-xs text-gray-400">{{ $session->start_time }} - {{ $session->end_time }}</p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs 
                        @if($session->status == 'scheduled') bg-blue-500
                        @elseif($session->status == 'completed') bg-green-500
                        @else bg-yellow-500 @endif text-white">
                        {{ ucfirst($session->status) }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-gray-400 text-center py-4">Tidak ada jadwal konseling mendatang.</p>
        @endif
    </div>

    <!-- RIWAYAT KONSELING -->
    <div class="bg-gray-800 rounded-lg p-6 shadow-lg">
        <h3 class="text-xl font-bold text-white mb-4 flex items-center">
            <i class="fas fa-history mr-2 text-green-400"></i>
            Riwayat Konseling Terbaru
        </h3>
        
        @if($recentSessions->count() > 0)
        <div class="space-y-3">
            @foreach($recentSessions as $session)
            <div class="bg-gray-700 p-4 rounded-lg">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="font-semibold text-white">{{ $session->scheduled_date->format('d M Y') }}</p>
                        <p class="text-sm text-gray-300">Dengan: {{ $session->teacher->name }}</p>
                        @if($session->teacher_notes)
                        <p class="text-xs text-gray-400 mt-1">{{ Str::limit($session->teacher_notes, 50) }}</p>
                        @endif
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs 
                        @if($session->status == 'completed') bg-green-500
                        @elseif($session->status == 'cancelled') bg-red-500
                        @else bg-yellow-500 @endif text-white">
                        {{ ucfirst($session->status) }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-gray-400 text-center py-4">Belum ada riwayat konseling.</p>
        @endif
    </div>
</div>

<!-- PELANGGARAN TERBARU -->
<div class="mt-6 bg-gray-800 rounded-lg p-6 shadow-lg">
    <h3 class="text-xl font-bold text-white mb-4 flex items-center">
        <i class="fas fa-exclamation-circle mr-2 text-red-400"></i>
        Pelanggaran Terbaru
    </h3>
    
    @if($recentViolations->count() > 0)
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-700">
                <tr>
                    <th class="px-4 py-2 text-left">Tanggal</th>
                    <th class="px-4 py-2 text-left">Pelanggaran</th>
                    <th class="px-4 py-2 text-left">Poin</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentViolations as $violation)
                <tr class="border-b border-gray-700 hover:bg-gray-700">
                    <td class="px-4 py-3">{{ $violation->violation_date->format('d M Y') }}</td>
                    <td class="px-4 py-3">{{ $violation->rule->name }}</td>
                    <td class="px-4 py-3 text-red-400 font-semibold">-{{ $violation->rule->points }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <p class="text-gray-400 text-center py-4">Tidak ada pelanggaran.</p>
    @endif
</div>

<!-- QUICK ACTIONS -->
<div class="mt-8 bg-gray-800 rounded-lg p-6 shadow-lg">
    <h3 class="text-xl font-bold text-white mb-4">Aksi Cepat</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <a href="{{ route('student.counseling_requests.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white p-4 rounded-lg text-center transition duration-200">
            <i class="fas fa-plus-circle text-2xl mb-2"></i>
            <p>Ajukan Permintaan Konseling</p>
        </a>
        <a href="{{ route('student.counseling_requests.index') }}" class="bg-green-600 hover:bg-green-700 text-white p-4 rounded-lg text-center transition duration-200">
            <i class="fas fa-list text-2xl mb-2"></i>
            <p>Lihat Permintaan Saya</p>
        </a>
    </div>
</div>
@endsection