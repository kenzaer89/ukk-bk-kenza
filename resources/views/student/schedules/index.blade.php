@extends('layouts.app')

@section('title', 'Jadwal Konseling Saya')

@section('content')
<div class="min-h-screen p-6">
    <!-- Header -->
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-brand-light mb-2 flex items-center gap-3">
                <span class="p-2 bg-indigo-500/20 rounded-lg">
                    <svg class="w-8 h-8 text-brand-teal" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </span>
                Jadwal Konseling
            </h1>
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

    <!-- Schedules Table -->
    <div class="bg-gray-800 rounded-2xl border border-brand-light/10 shadow-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-xs font-semibold tracking-wider text-left text-gray-400 uppercase border-b border-gray-700 bg-gray-800/50">
                        <th class="px-8 py-4">TOPIK DAN GURU BK</th>
                        <th class="px-8 py-4">WAKTU DAN LOKASI</th>
                        <th class="px-8 py-4">STATUS</th>
                        <th class="px-8 py-4 text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($schedules as $schedule)
                    @php
                        // Logic status yang sama dengan yang lama
                        $currentStatus = $schedule->status;
                        if ($schedule->session) {
                            $currentStatus = $schedule->session->status;
                        }

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
                    <tr class="hover:bg-gray-700 transition duration-150 border-b border-gray-700">
                        <td class="px-8 py-6">
                            <div class="flex flex-col gap-1">
                                @php
                                    $topicName = '-';
                                    if($schedule->topic) {
                                        $topicName = $schedule->topic->name;
                                    } elseif($schedule->counselingRequest && str_starts_with($schedule->counselingRequest->reason, '[Topik:')) {
                                        preg_match('/^\[Topik:\s*(.*?)\]/s', $schedule->counselingRequest->reason, $matches);
                                        $topicName = $matches[1] ?? 'Custom';
                                    } elseif($schedule->counselingRequest && $schedule->counselingRequest->topic) {
                                        $topicName = $schedule->counselingRequest->topic->name;
                                    }
                                @endphp
                                <span class="inline-flex items-center w-fit px-2 py-0.5 rounded bg-brand-teal/10 text-brand-teal text-[10px] font-bold uppercase tracking-wider" title="{{ $topicName }}">
                                    {{ Str::limit($topicName, 25) }}
                                </span>
                                <p class="text-brand-light font-medium text-sm">{{ $schedule->teacher_name ?? ($schedule->teacher->name ?? 'Admin Sekolah') }}</p>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex flex-col">
                                <span class="text-brand-light font-medium">{{ $schedule->scheduled_date->translatedFormat('d F Y') }}</span>
                                <span class="text-[10px] text-brand-light/40 uppercase tracking-wider">
                                    {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }} | {{ $schedule->location ?? 'Ruang BK' }}
                                </span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="px-3 py-1 inline-flex text-[10px] leading-5 font-bold rounded-full uppercase tracking-widest {{ $statusClass }}">
                                {{ $statusLabel }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <button x-data @click="$dispatch('open-schedule-detail-{{ $schedule->id }}')" class="px-4 py-1.5 bg-brand-light/5 border border-brand-light/10 text-brand-light/80 rounded-lg font-bold hover:bg-brand-teal hover:text-brand-dark transition-all text-[10px] uppercase tracking-wider">
                                Detail
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center gap-4">
                                <div class="w-16 h-16 rounded-2xl bg-brand-light/5 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-brand-light/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div class="max-w-xs">
                                    <h3 class="text-lg font-bold text-brand-light mb-1">Tidak Ada Jadwal</h3>
                                    <p class="text-sm text-brand-light/40">Anda tidak memiliki jadwal konseling untuk kategori ini.</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($schedules->hasPages())
    <div class="mt-8">
        {{ $schedules->links() }}
    </div>
    @endif
</div>

<!-- Modals for details -->
@foreach($schedules as $schedule)
    <div x-data="{ open: false }" 
         x-show="open" 
         @open-schedule-detail-{{ $schedule->id }}.window="open = true"
         style="display: none;"
         class="fixed inset-0 z-50 overflow-y-auto" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-brand-dark/95 transition-opacity" @click="open = false"></div>

            <div class="inline-block align-bottom bg-brand-gray rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-brand-light/10">
                <div class="px-6 py-4 border-b border-brand-light/5 flex justify-between items-center">
                    <h3 class="text-xl font-bold text-brand-light">Detail Jadwal Konseling</h3>
                    <button @click="open = false" class="text-brand-light/40 hover:text-brand-light transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <div class="p-8 space-y-6">
                    @php
                        // Re-calculate status logic for modal
                        $currentStatus = $schedule->status;
                        if ($schedule->session) {
                            $currentStatus = $schedule->session->status;
                        }

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

                    <!-- Status & Time -->
                    <div class="flex justify-between items-center bg-brand-light/5 p-4 rounded-xl">
                        <div class="flex flex-col">
                            <span class="text-[10px] text-brand-light/40 uppercase font-bold tracking-widest mb-1">Status</span>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase w-fit {{ $statusClass }}">
                                {{ $statusLabel }}
                            </span>
                        </div>
                        <div class="text-right">
                            <span class="text-[10px] text-brand-light/40 uppercase font-bold tracking-widest block mb-1">Tanggal & Waktu</span>
                            <span class="text-brand-light font-medium text-sm">{{ $schedule->scheduled_date->translatedFormat('d F Y') }}</span>
                            <span class="text-[10px] text-brand-light/40 block">{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }} WIB</span>
                        </div>
                    </div>

                    <!-- Details Grid -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 bg-brand-light/5 border border-brand-light/5 rounded-xl">
                            <span class="text-[10px] text-brand-light/40 uppercase font-bold tracking-widest block mb-2">Guru BK</span>
                            <p class="text-brand-light font-bold">{{ $schedule->teacher_name ?? ($schedule->teacher->name ?? 'Admin Sekolah') }}</p>
                        </div>
                        <div class="p-4 bg-brand-light/5 border border-brand-light/5 rounded-xl">
                            <span class="text-[10px] text-brand-light/40 uppercase font-bold tracking-widest block mb-2">Lokasi</span>
                            <p class="text-brand-light font-bold">{{ $schedule->location ?? 'Ruang BK' }}</p>
                        </div>
                    </div>

                    <!-- Topic -->
                    <div>
                        <span class="text-[10px] text-brand-light/40 uppercase font-bold tracking-widest block mb-1">Topik Konseling</span>
                        <div class="p-4 bg-brand-teal/5 border border-brand-teal/10 rounded-xl">
                            <p class="text-brand-teal font-bold">
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

                    <!-- Counseling Notes (If session exists) -->
                    @if($schedule->session && $schedule->session->notes)
                    <div>
                        <span class="text-[10px] text-brand-light/40 uppercase font-bold tracking-widest block mb-2">{{ $currentStatus == 'cancelled' ? 'Alasan Dibatalkan' : 'Catatan Konseling' }}</span>
                        <div class="p-4 bg-brand-light/5 border border-brand-light/5 rounded-xl max-h-[200px] overflow-y-auto">
                            <p class="text-brand-light/90 italic leading-relaxed break-words whitespace-pre-wrap">"{{ $schedule->session->notes }}"</p>
                        </div>
                    </div>
                    @endif

                    <!-- Teacher Notes / Recommendations if any -->
                    @if($schedule->session && $schedule->session->recommendations)
                    <div>
                        <span class="text-[10px] text-emerald-400 uppercase font-bold tracking-widest block mb-2">Rekomendasi / Tindak Lanjut</span>
                        <div class="p-4 bg-emerald-500/5 border border-emerald-500/10 rounded-xl max-h-[200px] overflow-y-auto">
                            <p class="text-brand-light/90 italic leading-relaxed break-words whitespace-pre-wrap">{{ $schedule->session->recommendations }}</p>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="px-8 py-6 bg-brand-light/5 border-t border-brand-light/5 text-right">
                    <button @click="open = false" class="px-6 py-2.5 bg-brand-gray border border-brand-light/10 text-brand-light font-bold rounded-xl hover:bg-brand-light/10 transition-all text-sm">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
@endforeach

@endsection
