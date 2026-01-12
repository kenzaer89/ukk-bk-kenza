@extends('layouts.app')

@section('title', 'Permintaan Konseling')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-white flex items-center gap-3">
            <span>📩</span> Permintaan Konseling
        </h1>
        <p class="text-gray-400 mt-1">Kelola permintaan konseling dari siswa</p>
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
                        <th class="px-5 py-3">Alasan</th>
                        <th class="px-5 py-3">Tanggal Permintaan</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $request)
                    <tr class="hover:bg-gray-700 transition duration-150 border-b border-gray-700">
                        <td class="px-5 py-5 text-sm">
                            <div class="flex flex-col">
                                <span class="font-bold text-white">{{ $request->student->name }}</span>
                                <span class="text-xs text-brand-light/40">{{ $request->student->email }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-5 text-sm">
                            <p class="text-gray-300 leading-relaxed">
                                @if(str_starts_with($request->reason, '[Topik:'))
                                    @php
                                        preg_match('/^\[Topik:\s*(.*?)\]/s', $request->reason, $matches);
                                        $topicName = $matches[1] ?? 'Custom';
                                        $actualReason = trim(preg_replace('/^\[Topik:.*?\]/s', '', $request->reason));
                                    @endphp
                                    <span class="inline-block px-2 py-0.5 bg-indigo-900/50 text-indigo-300 text-[10px] rounded mb-1 uppercase font-bold tracking-tight">
                                        {{ $topicName }}
                                    </span>
                                    <span class="block text-xs italic opacity-60">{{ Str::limit($actualReason, 50) }}</span>
                                @else
                                    {{ Str::limit($request->reason, 50) }}
                                @endif
                            </p>
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
                        <td class="px-5 py-5 text-sm">
                            <a href="{{ route('admin.counseling_requests.show', $request) }}" 
                               class="inline-flex items-center px-4 py-1.5 bg-brand-gray text-brand-light/80 border border-brand-light/10 rounded-lg hover:bg-brand-teal hover:text-brand-dark transition-all text-xs font-bold">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-12 text-center text-gray-500 italic">Tidak ada permintaan konseling</td>
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
