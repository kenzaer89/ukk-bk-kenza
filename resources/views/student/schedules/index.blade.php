@extends('layouts.app')

@section('title', 'Jadwal Konseling Saya')

@section('content')
<div class="min-h-screen p-6">
    <!-- Header -->
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-brand-light mb-2">Jadwal Konseling</h1>
            <p class="text-brand-light/60">Lihat detail jadwal sesi konseling yang telah dijadwalkan</p>
        </div>
        <a href="{{ route('student.dashboard') }}" class="px-4 py-2 bg-brand-gray border border-brand-light/10 rounded-lg text-brand-light hover:bg-brand-light/5 transition-all">
            Kembali ke Dashboard
        </a>
    </div>

    <!-- Filter Tabs -->
    <div class="mb-6 flex gap-2 flex-wrap">
        <a href="{{ route('student.schedules.index') }}" 
           class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all {{ !request('status') ? 'bg-brand-teal text-brand-dark shadow-[0_0_15px_rgba(118,171,174,0.3)]' : 'bg-brand-gray text-brand-light/60 hover:bg-brand-gray/80 border border-brand-light/10' }}">
            Semua ({{ $counts['all'] }})
        </a>
        <a href="{{ route('student.schedules.index', ['status' => 'scheduled']) }}" 
           class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all {{ request('status') == 'scheduled' ? 'bg-brand-teal text-brand-dark shadow-[0_0_15px_rgba(118,171,174,0.3)]' : 'bg-brand-gray text-brand-light/60 hover:bg-brand-gray/80 border border-brand-light/10' }}">
            Terjadwal ({{ $counts['scheduled'] }})
        </a>
        <a href="{{ route('student.schedules.index', ['status' => 'completed']) }}" 
           class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all {{ request('status') == 'completed' ? 'bg-green-500 text-white shadow-[0_0_15px_rgba(34,197,94,0.3)]' : 'bg-brand-gray text-brand-light/60 hover:bg-brand-gray/80 border border-brand-light/10' }}">
            Selesai ({{ $counts['completed'] }})
        </a>
        <a href="{{ route('student.schedules.index', ['status' => 'cancelled']) }}" 
           class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all {{ request('status') == 'cancelled' ? 'bg-red-500 text-white shadow-[0_0_15px_rgba(239,68,68,0.3)]' : 'bg-brand-gray text-brand-light/60 hover:bg-brand-gray/80 border border-brand-light/10' }}">
            Dibatalkan ({{ $counts['cancelled'] }})
        </a>
    </div>

    <!-- Schedules List -->
    <div class="max-w-4xl space-y-4">
        @forelse($schedules as $schedule)
            <div class="bg-brand-gray rounded-xl border border-brand-light/10 p-6 hover:border-brand-teal/30 transition-all">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="flex-1 space-y-3">
                        <div class="flex items-center gap-3">
                            @php
                                // Default status berdasarkan kolom status di DB
                                $currentStatus = $schedule->status;
                                if ($schedule->session) {
                                    $currentStatus = $schedule->session->status;
                                }

                                // Default values
                                $statusLabel = 'Terjadwal';
                                $statusClass = 'bg-yellow-500/20 text-yellow-500';

                                if ($currentStatus == 'completed') {
                                    $statusLabel = 'Selesai';
                                    $statusClass = 'bg-green-500/20 text-green-500';
                                } elseif ($currentStatus == 'cancelled') {
                                    $statusLabel = 'Dibatalkan';
                                    $statusClass = 'bg-red-500/20 text-red-500';
                                } elseif ($schedule->scheduled_date->isFuture() && $currentStatus == 'scheduled') {
                                    $statusLabel = 'Mendatang';
                                    $statusClass = 'bg-brand-teal/20 text-brand-teal';
                                }
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $statusClass }}">
                                {{ $statusLabel }}
                            </span>
                            <span class="text-sm text-brand-light/60">
                                {{ $schedule->scheduled_date->translatedFormat('l, d F Y') }}
                            </span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="flex items-center gap-3 text-brand-light">
                                <div class="w-8 h-8 rounded-lg bg-brand-teal/10 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-brand-teal" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-brand-light/40 uppercase font-bold">Waktu Sesi</p>
                                    <p class="font-medium font-mono text-sm">
                                        {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 text-brand-light">
                                <div class="w-8 h-8 rounded-lg bg-indigo-500/10 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-brand-light/40 uppercase font-bold">Guru BK</p>
                                    <p class="font-medium text-sm">{{ $schedule->teacher->name ?? 'Admin Sekolah' }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 text-brand-light">
                                <div class="w-8 h-8 rounded-lg bg-red-500/10 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-brand-light/40 uppercase font-bold">Lokasi</p>
                                    <p class="font-medium text-sm">{{ $schedule->location ?? 'Ruang BK' }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 text-brand-light">
                                <div class="w-8 h-8 rounded-lg bg-yellow-500/10 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-brand-light/40 uppercase font-bold">Topik</p>
                                    <p class="font-medium text-sm">
                                        @if($schedule->topic)
                                            {{ $schedule->topic->name }}
                                        @elseif($schedule->counselingRequest && str_starts_with($schedule->counselingRequest->reason, '[Topik:'))
                                            @php
                                                preg_match('/^\[Topik:\s*(.*?)\]/s', $schedule->counselingRequest->reason, $matches);
                                                echo $matches[1] ?? 'Custom';
                                            @endphp
                                        @else
                                            {{ $schedule->counselingRequest->topic->name ?? '-' }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Catatan (Hanya tampil jika sudah ada sesi selesai) --}}
                        @if($schedule->session && $schedule->session->notes)
                            <div class="mt-4 pt-4 border-t border-brand-light/5">
                                <p class="text-xs text-brand-light/40 uppercase font-bold mb-2">Catatan Konseling</p>
                                <div class="bg-brand-dark/50 rounded-lg p-4 text-sm text-brand-light/80 leading-relaxed italic border-l-4 border-brand-teal">
                                    "{{ $schedule->session->notes }}"
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-brand-gray rounded-xl border border-brand-light/10 p-12 text-center">
                <div class="w-16 h-16 bg-brand-light/5 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-brand-light/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-brand-light mb-2">Belum Ada Jadwal</h3>
                <p class="text-brand-light/60 mb-6">Anda belum memiliki jadwal sesi konseling saat ini.</p>
                <a href="{{ route('student.counseling_requests.create') }}" class="inline-flex items-center px-6 py-3 bg-brand-teal text-brand-dark rounded-lg font-bold hover:bg-brand-teal/80 transition-all">
                    Buat Permintaan Konseling
                </a>
            </div>
        @endforelse

        <div class="mt-8">
            {{ $schedules->links() }}
        </div>
    </div>
</div>
@endsection
