@extends('layouts.app')

@section('title', 'Permintaan Konseling Saya')

@section('content')
<div class="min-h-screen p-6">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-brand-light mb-2 flex items-center gap-3">
            <span class="p-2 bg-indigo-500/20 rounded-lg">
                <svg class="w-8 h-8 text-brand-teal" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </span>
            Permintaan Konseling Saya
        </h1>
        <p class="text-brand-light/60">Kelola dan pantau status permintaan konseling Anda</p>
    </div>

    <!-- Filter Tabs (Matched with Admin Design) -->
    <div class="mb-6 flex gap-2 flex-wrap">
        <a href="{{ route('student.counseling_requests.index') }}" 
           class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all {{ !request('status') ? 'bg-brand-teal text-brand-dark shadow-[0_0_15px_rgba(118,171,174,0.3)]' : 'bg-brand-gray text-brand-light/60 hover:bg-brand-gray/80 border border-brand-light/10' }}">
            Semua ({{ $counts['all'] }})
        </a>
        <a href="{{ route('student.counseling_requests.index', ['status' => 'pending']) }}" 
           class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all {{ request('status') == 'pending' ? 'bg-yellow-500 text-white shadow-[0_0_15px_rgba(234,179,8,0.3)]' : 'bg-brand-gray text-brand-light/60 hover:bg-brand-gray/80 border border-brand-light/10' }}">
            Pending ({{ $counts['pending'] }})
        </a>
        <a href="{{ route('student.counseling_requests.index', ['status' => 'approved']) }}" 
           class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all {{ request('status') == 'approved' ? 'bg-green-500 text-white shadow-[0_0_15px_rgba(34,197,94,0.3)]' : 'bg-brand-gray text-brand-light/60 hover:bg-brand-gray/80 border border-brand-light/10' }}">
            Disetujui ({{ $counts['approved'] }})
        </a>
        <a href="{{ route('student.counseling_requests.index', ['status' => 'rejected']) }}" 
           class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all {{ request('status') == 'rejected' ? 'bg-red-500 text-white shadow-[0_0_15px_rgba(239,68,68,0.3)]' : 'bg-brand-gray text-brand-light/60 hover:bg-brand-gray/80 border border-brand-light/10' }}">
            Ditolak ({{ $counts['rejected'] }})
        </a>
    </div>

    <!-- Action Button -->
    <div class="mb-8">
        <a href="{{ route('student.counseling_requests.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-brand-teal text-brand-dark rounded-xl font-bold hover:bg-[#5a8e91] transition-all shadow-[0_0_20px_rgba(118,171,174,0.3)] hover:shadow-[0_0_30px_rgba(118,171,174,0.5)] transform hover:-translate-y-0.5">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Ajukan Permintaan Baru
        </a>
    </div>

    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/30 rounded-xl">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-emerald-400 font-medium">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <!-- Requests Table (Matched with Admin Table) -->
    <div class="bg-gray-800 rounded-2xl border border-brand-light/10 shadow-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-xs font-semibold tracking-wider text-left text-gray-400 uppercase border-b border-gray-700 bg-gray-800/50">
                        <th class="px-8 py-4">TOPIK DAN ALASAN</th>
                        <th class="px-8 py-4">TANGGAL PERMINTAAN</th>
                        <th class="px-8 py-4">STATUS</th>
                        <th class="px-8 py-4 text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($requests as $request)
                    <tr class="hover:bg-gray-700 transition duration-150 border-b border-gray-700">
                        <td class="px-8 py-6">
                            @if($request->topic)
                                <div class="flex flex-col gap-1">
                                    <span class="inline-flex items-center w-fit px-2 py-0.5 rounded bg-brand-teal/10 text-brand-teal text-[10px] font-bold uppercase tracking-wider">
                                        {{ $request->topic->name }}
                                    </span>
                                    <p class="text-brand-light/80 text-sm truncate max-w-[300px]" title="{{ $request->reason }}">{{ $request->reason }}</p>
                                </div>
                            @elseif(str_starts_with($request->reason, '[Topik:'))
                                @php
                                    preg_match('/^\[Topik:\s*(.*?)\]\s*(.*)$/s', $request->reason, $matches);
                                    $topicName = $matches[1] ?? 'Custom';
                                    $actualReason = trim($matches[2] ?? '');
                                @endphp
                                <div class="flex flex-col gap-1">
                                    <span class="inline-flex items-center w-fit px-2 py-0.5 rounded bg-brand-teal/10 text-brand-teal text-[10px] font-bold uppercase tracking-wider">
                                        {{ $topicName }}
                                    </span>
                                    <p class="text-brand-light/80 text-sm truncate max-w-[300px]" title="{{ $actualReason }}">{{ $actualReason }}</p>
                                </div>
                            @else
                                <p class="text-brand-light/80 text-sm truncate max-w-[300px]" title="{{ $request->reason }}">{{ $request->reason }}</p>
                            @endif
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex flex-col">
                                <span class="text-brand-light font-medium">{{ $request->requested_at->translatedFormat('d F Y') }}</span>
                                <span class="text-[10px] text-brand-light/40 uppercase tracking-wider">{{ $request->requested_at->format('H:i') }} WIB</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="px-3 py-1 inline-flex text-[10px] leading-5 font-bold rounded-full uppercase tracking-widest
                                @if($request->status === 'pending') bg-yellow-500/20 text-yellow-500
                                @elseif($request->status === 'approved') bg-green-500/20 text-green-500
                                @elseif($request->status === 'completed') bg-blue-500/20 text-blue-400
                                @elseif($request->status === 'canceled') bg-gray-500/20 text-gray-500
                                @else bg-red-500/20 text-red-500
                                @endif">
                                @if($request->status === 'pending') Pending
                                @elseif($request->status === 'approved') Disetujui
                                @elseif($request->status === 'completed') Selesai
                                @elseif($request->status === 'canceled') Dibatalkan
                                @else Ditolak
                                @endif
                            </span>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <div class="flex justify-center gap-2">
                                @if($request->status === 'pending')
                                    <form method="POST" action="{{ route('student.counseling_requests.cancel', $request) }}" onsubmit="return confirmAction(event, 'Batal Pengajuan', 'Yakin ingin membatalkan permintaan ini?')">
                                        @csrf
                                        <button type="submit" class="px-4 py-1.5 bg-red-500/10 border border-red-500/30 text-red-500 rounded-lg font-bold hover:bg-red-500 hover:text-white transition-all text-[10px] uppercase tracking-wider">
                                            Batal
                                        </button>
                                    </form>
                                @endif
                                
                                <button x-data @click="$dispatch('open-request-detail-{{ $request->id }}')" class="px-4 py-1.5 bg-brand-light/5 border border-brand-light/10 text-brand-light/80 rounded-lg font-bold hover:bg-brand-teal hover:text-brand-dark transition-all text-[10px] uppercase tracking-wider">
                                    Detail
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center gap-4">
                                <div class="w-16 h-16 rounded-2xl bg-brand-light/5 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-brand-light/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <div class="max-w-xs">
                                    <h3 class="text-lg font-bold text-brand-light mb-1">Belum Ada Permintaan</h3>
                                    <p class="text-sm text-brand-light/40">Tidak ada data permintaan konseling yang ditemukan untuk kategori ini.</p>
                                </div>
                                <a href="{{ route('student.counseling_requests.create') }}" class="mt-2 inline-flex items-center gap-2 px-6 py-2 bg-brand-teal/10 border border-brand-teal/20 text-brand-teal rounded-xl font-bold hover:bg-brand-teal hover:text-brand-dark transition-all text-sm">
                                    Buat Permintaan
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($requests->hasPages())
    <div class="mt-8">
        {{ $requests->links() }}
    </div>
    @endif
</div>

<!-- Modals for details -->
@foreach($requests as $request)
    <div x-data="{ open: false }" 
         x-show="open" 
         @open-request-detail-{{ $request->id }}.window="open = true"
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
                    <h3 class="text-xl font-bold text-brand-light">Detail Permintaan</h3>
                    <button @click="open = false" class="text-brand-light/40 hover:text-brand-light transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <div class="p-8 space-y-6">
                    <!-- Status & Time -->
                    <div class="flex justify-between items-center bg-brand-light/5 p-4 rounded-xl">
                        <div class="flex flex-col">
                            <span class="text-[10px] text-brand-light/40 uppercase font-bold tracking-widest mb-1">Status</span>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase w-fit
                                @if($request->status === 'pending') bg-yellow-500/20 text-yellow-500
                                @elseif($request->status === 'approved') bg-green-500/20 text-green-500
                                @elseif($request->status === 'completed') bg-blue-500/20 text-blue-400
                                @elseif($request->status === 'canceled') bg-gray-500/20 text-gray-500
                                @else bg-red-500/20 text-red-500
                                @endif">
                                @if($request->status === 'pending') Pending
                                @elseif($request->status === 'approved') Disetujui
                                @elseif($request->status === 'completed') Selesai
                                @elseif($request->status === 'canceled') Dibatalkan
                                @else Ditolak
                                @endif
                            </span>
                        </div>
                        <div class="text-right">
                            <span class="text-[10px] text-brand-light/40 uppercase font-bold tracking-widest block mb-1">Diajukan Pada</span>
                            <span class="text-brand-light font-medium text-sm">{{ $request->requested_at->translatedFormat('d F Y, H:i') }}</span>
                        </div>
                    </div>

                    <!-- Reason -->
                    <div>
                        <span class="text-[10px] text-brand-light/40 uppercase font-bold tracking-widest block mb-2">Alasan & Topik</span>
                        <div class="p-4 bg-brand-light/5 border border-brand-light/5 rounded-xl">
                            @if($request->topic)
                                <span class="bg-brand-teal text-brand-dark text-[9px] font-bold px-2 py-0.5 rounded uppercase mb-2 inline-block">{{ $request->topic->name }}</span>
                                <p class="text-brand-light leading-relaxed whitespace-pre-wrap break-words">{{ $request->reason }}</p>
                            @elseif(str_starts_with($request->reason, '[Topik:'))
                                @php
                                    preg_match('/^\[Topik:\s*(.*?)\]\s*(.*)$/s', $request->reason, $matches);
                                    $topicName = $matches[1] ?? 'Custom';
                                    $actualReason = trim($matches[2] ?? '');
                                @endphp
                                <span class="bg-brand-teal text-brand-dark text-[9px] font-bold px-2 py-0.5 rounded uppercase mb-2 inline-block">{{ $topicName }}</span>
                                <p class="text-brand-light leading-relaxed whitespace-pre-wrap break-words">{{ $actualReason }}</p>
                            @else
                                <p class="text-brand-light leading-relaxed whitespace-pre-wrap break-words">{{ $request->reason }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Admin Notes / Reject Reason -->
                    @if($request->notes)
                    <div class="p-4 bg-red-500/10 border border-red-500/20 rounded-xl">
                        <span class="text-[10px] text-red-400 uppercase font-bold tracking-widest block mb-2">Catatan Guru BK</span>
                        <p class="text-brand-light/90 italic whitespace-pre-wrap break-words">"{{ $request->notes }}"</p>
                    </div>
                    @endif

                    <!-- Canceled Notice -->
                    @if($request->status === 'canceled')
                    <div class="p-4 bg-gray-500/10 border border-gray-500/20 rounded-xl">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <span class="text-[10px] text-gray-400 uppercase font-bold tracking-widest block mb-1">Informasi</span>
                                <p class="text-brand-light/90">Anda telah membatalkan permintaan konseling ini.</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Teacher Assigned -->
                    @if(($request->teacher_name || $request->teacher) && $request->status !== 'rejected')
                    <div class="p-4 bg-brand-light/5 border border-brand-light/5 rounded-xl">
                        <span class="text-[10px] text-brand-light/40 uppercase font-bold tracking-widest block mb-2">Guru BK yang Menangani</span>
                        <div class="flex items-center gap-3">
                            <span class="text-brand-light font-bold">{{ $request->teacher_name ?? $request->teacher->name }}</span>
                        </div>
                    </div>
                    @endif

                    <!-- Schedule if approved -->
                    @if($request->status === 'approved' && $request->schedule)
                    <div class="space-y-4">
                        <span class="text-[10px] text-brand-teal uppercase font-bold tracking-widest block">Informasi Jadwal</span>
                        <div class="grid grid-cols-3 gap-4">
                            <div class="p-4 bg-brand-teal/5 border border-brand-teal/10 rounded-xl">
                                <span class="text-[9px] text-brand-teal/60 uppercase font-bold block mb-1">Tanggal</span>
                                <span class="text-brand-light font-bold text-sm">{{ \Carbon\Carbon::parse($request->schedule->scheduled_date)->translatedFormat('d M Y') }}</span>
                            </div>
                            <div class="p-4 bg-brand-teal/5 border border-brand-teal/10 rounded-xl">
                                <span class="text-[9px] text-brand-teal/60 uppercase font-bold block mb-1">Waktu Mulai</span>
                                <span class="text-brand-light font-bold text-sm">{{ \Carbon\Carbon::parse($request->schedule->start_time)->format('H:i') }} WIB</span>
                            </div>
                            <div class="p-4 bg-brand-teal/5 border border-brand-teal/10 rounded-xl">
                                <span class="text-[9px] text-brand-teal/60 uppercase font-bold block mb-1">Waktu Selesai</span>
                                <span class="text-brand-light font-bold text-sm">{{ \Carbon\Carbon::parse($request->schedule->end_time)->format('H:i') }} WIB</span>
                            </div>
                        </div>
                        <div class="p-4 bg-brand-teal/5 border border-brand-teal/10 rounded-xl">
                            <span class="text-[9px] text-brand-teal/60 uppercase font-bold block mb-1">Lokasi</span>
                            <span class="text-brand-light font-bold text-sm">{{ $request->schedule->location ?? 'Ruang BK' }}</span>
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