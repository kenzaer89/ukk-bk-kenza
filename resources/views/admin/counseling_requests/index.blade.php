@extends('layouts.app')

@section('title', 'Permintaan Konseling')

@section('content')
<div class="p-6">
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-white flex items-center gap-3">
                <span class="p-2 bg-indigo-500/20 rounded-lg">
                    <svg class="w-8 h-8 text-brand-teal" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </span>
                Permintaan Konseling
            </h1>
            <p class="text-gray-400 mt-1">Kelola permintaan konseling dari siswa</p>
        </div>

        <div class="flex flex-col sm:flex-row items-center gap-4">
            <form action="{{ route('admin.counseling_requests.index') }}" method="GET" class="relative group w-full sm:w-64">
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                <input type="text" name="search" value="{{ request('search') }}" 
                    placeholder="Cari permintaan..." 
                    class="w-full bg-gray-900/50 border border-gray-700/50 text-white text-sm rounded-xl px-4 py-3 pl-10 focus:ring-2 focus:ring-brand-teal focus:border-transparent transition-all duration-200 outline-none group-hover:bg-gray-800/80">
                <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 group-hover:text-brand-teal transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </form>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="mb-6 flex gap-2 flex-wrap">
        <a href="{{ route('admin.counseling_requests.index') }}" 
           class="px-4 py-2 rounded-lg text-sm font-medium transition-all {{ !request('status') ? 'bg-brand-teal text-brand-dark' : 'bg-brand-gray text-brand-light/60 hover:bg-brand-gray/80 border border-brand-light/10' }}">
            Semua ({{ $counts['all'] }})
        </a>
        <a href="{{ route('admin.counseling_requests.index', ['status' => 'pending']) }}" 
           class="px-4 py-2 rounded-lg text-sm font-medium transition-all {{ request('status') == 'pending' ? 'bg-yellow-500 text-white' : 'bg-brand-gray text-brand-light/60 hover:bg-brand-gray/80 border border-brand-light/10' }}">
            Pending ({{ $counts['pending'] }})
        </a>
        <a href="{{ route('admin.counseling_requests.index', ['status' => 'approved']) }}" 
           class="px-4 py-2 rounded-lg text-sm font-medium transition-all {{ request('status') == 'approved' ? 'bg-green-500 text-white' : 'bg-brand-gray text-brand-light/60 hover:bg-brand-gray/80 border border-brand-light/10' }}">
            Disetujui ({{ $counts['approved'] }})
        </a>
        <a href="{{ route('admin.counseling_requests.index', ['status' => 'rejected']) }}" 
           class="px-4 py-2 rounded-lg text-sm font-medium transition-all {{ request('status') == 'rejected' ? 'bg-red-500 text-white' : 'bg-brand-gray text-brand-light/60 hover:bg-brand-gray/80 border border-brand-light/10' }}">
            Ditolak ({{ $counts['rejected'] }})
        </a>
        <a href="{{ route('admin.counseling_requests.index', ['status' => 'canceled']) }}" 
           class="px-4 py-2 rounded-lg text-sm font-medium transition-all {{ request('status') == 'canceled' ? 'bg-gray-500 text-white' : 'bg-brand-gray text-brand-light/60 hover:bg-brand-gray/80 border border-brand-light/10' }}">
            Dibatalkan ({{ $counts['canceled'] }})
        </a>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="bg-green-500 p-4 rounded-lg mb-6 text-white text-sm">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-500 p-4 rounded-lg mb-6 text-white text-sm">
            {{ session('error') }}
        </div>
    @endif

    <!-- Requests Table -->
    <div class="bg-gray-800 rounded-xl shadow-lg p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr class="text-xs font-semibold tracking-wider text-left text-gray-400 uppercase border-b border-gray-700">
                        <th class="px-5 py-3">Siswa</th>
                        <th class="px-5 py-3">Topik dan Alasan</th>
                        <th class="px-5 py-3">Tanggal Permintaan</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $request)
                    <tr class="hover:bg-gray-700 transition duration-150 border-b border-gray-700">
                        <td class="px-5 py-5 text-sm">
                            <div class="flex flex-col">
                                <span class="font-bold text-white">{{ $request->student->name }}</span>
                                <span class="text-xs text-brand-light/40">{{ $request->student->absen ?? '' }} {{ $request->student->schoolClass->name ?? '' }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-5 text-sm">
                            <div class="flex flex-col gap-1">
                               @if($request->topic)
                                   <span class="inline-flex items-center w-fit px-2 py-0.5 rounded bg-brand-teal/10 text-brand-teal text-[10px] font-bold uppercase tracking-wider">
                                       {{ $request->topic->name }}
                                   </span>
                                   <p class="text-brand-light/80 text-sm truncate max-w-[300px]" title="{{ $request->reason }}">{{ $request->reason }}</p>
                               @elseif(str_starts_with($request->reason, '[Topik:'))
                                   @php
                                       preg_match('/^\[Topik:\s*(.*?)\]\s*(.*)$/s', $request->reason, $matches);
                                       $topicName = $matches[1] ?? 'Custom';
                                       $actualReason = trim($matches[2] ?? '');
                                   @endphp
                                   <span class="inline-flex items-center w-fit px-2 py-0.5 rounded bg-brand-teal/10 text-brand-teal text-[10px] font-bold uppercase tracking-wider">
                                       {{ $topicName }}
                                   </span>
                                   <p class="text-brand-light/80 text-sm truncate max-w-[300px]" title="{{ $actualReason }}">{{ $actualReason }}</p>
                               @else
                                   <p class="text-brand-light/80 text-sm truncate max-w-[300px]" title="{{ $request->reason }}">{{ $request->reason }}</p>
                               @endif
                            </div>
                        </td>
                        <td class="px-5 py-5 text-sm">
                            <span class="text-white">{{ $request->requested_at->translatedFormat('H:i d F Y') }}</span>
                            <span class="block text-[10px] text-brand-light/40 uppercase mt-0.5">{{ $request->requested_at->diffForHumans() }}</span>
                        </td>
                        <td class="px-5 py-5 text-sm">
                            @if($request->status == 'pending')
                                <span class="px-3 py-1 inline-flex text-[10px] leading-5 font-bold rounded-full bg-yellow-500/20 text-yellow-500 uppercase tracking-wider">
                                    Pending
                                </span>
                            @elseif($request->status == 'approved')
                                <span class="px-3 py-1 inline-flex text-[10px] leading-5 font-bold rounded-full bg-green-500/20 text-green-500 uppercase tracking-wider">
                                    Disetujui
                                </span>
                            @elseif($request->status == 'canceled')
                                <span class="px-3 py-1 inline-flex text-[10px] leading-5 font-bold rounded-full bg-gray-500/20 text-gray-500 uppercase tracking-wider">
                                    Dibatalkan
                                </span>
                            @else
                                <span class="px-3 py-1 inline-flex text-[10px] leading-5 font-bold rounded-full bg-red-500/20 text-red-500 uppercase tracking-wider">
                                    Ditolak
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-5 text-sm text-center">
                            <a href="{{ route('admin.counseling_requests.show', $request) }}" 
                               class="inline-flex items-center px-4 py-1.5 bg-brand-gray text-brand-light/80 border border-brand-light/10 rounded-lg hover:bg-brand-teal hover:text-brand-dark transition-all text-xs font-bold">
                                {{ $request->status == 'pending' ? 'Tangani' : 'Detail' }}
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-20 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <svg class="w-16 h-16 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                @if(request('search'))
                                    <p class="text-gray-500 text-lg italic">Tidak ada permintaan yang cocok dengan kata kunci "{{ request('search') }}".</p>
                                    <a href="{{ route('admin.counseling_requests.index', ['status' => request('status')]) }}" class="text-brand-teal hover:underline font-semibold mt-2">Hapus pencarian</a>
                                @else
                                    <p class="text-gray-500 text-lg italic">Tidak ada permintaan konseling</p>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($requests->hasPages())
        <div class="mt-6">
            {{ $requests->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
