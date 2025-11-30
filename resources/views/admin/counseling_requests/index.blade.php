@extends('layouts.app')

@section('title', 'Permintaan Konseling')

@section('content')
<div class="min-h-screen bg-brand-dark p-6">
    <!-- Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-brand-light mb-2">Permintaan Konseling</h1>
            <p class="text-brand-light/60">Kelola permintaan konseling dari siswa</p>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="mb-6 bg-green-500/10 border border-green-500/50 text-green-500 px-6 py-4 rounded-lg flex items-center gap-3">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <!-- Filter Tabs -->
    <div class="mb-6 flex gap-2 flex-wrap">
        <a href="{{ route('admin.counseling_requests.index') }}" 
           class="px-4 py-2 rounded-lg {{ !request('status') ? 'bg-brand-teal text-white' : 'bg-brand-gray text-brand-light/60 hover:bg-brand-gray/80' }} transition-all">
            Semua ({{ $requests->total() }})
        </a>
        <a href="{{ route('admin.counseling_requests.index', ['status' => 'pending']) }}" 
           class="px-4 py-2 rounded-lg {{ request('status') == 'pending' ? 'bg-yellow-500 text-white' : 'bg-brand-gray text-brand-light/60 hover:bg-brand-gray/80' }} transition-all">
            Pending
        </a>
        <a href="{{ route('admin.counseling_requests.index', ['status' => 'approved']) }}" 
           class="px-4 py-2 rounded-lg {{ request('status') == 'approved' ? 'bg-green-500 text-white' : 'bg-brand-gray text-brand-light/60 hover:bg-brand-gray/80' }} transition-all">
            Disetujui
        </a>
        <a href="{{ route('admin.counseling_requests.index', ['status' => 'rejected']) }}" 
           class="px-4 py-2 rounded-lg {{ request('status') == 'rejected' ? 'bg-red-500 text-white' : 'bg-brand-gray text-brand-light/60 hover:bg-brand-gray/80' }} transition-all">
            Ditolak
        </a>
    </div>

    <!-- Requests Table -->
    <div class="bg-brand-gray rounded-xl border border-brand-light/10 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-brand-dark/50 border-b border-brand-light/10">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-brand-light">Siswa</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-brand-light">Alasan</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-brand-light">Tanggal Permintaan</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-brand-light">Status</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-brand-light">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-light/5">
                    @forelse($requests as $request)
                    <tr class="hover:bg-brand-dark/30 transition-colors">
                        <td class="px-6 py-4">
                            <div>
                                <p class="font-medium text-brand-light">{{ $request->student->name }}</p>
                                <p class="text-sm text-brand-light/60">{{ $request->student->email }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-brand-light/80">{{ Str::limit($request->reason, 50) }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-brand-light/80">{{ $request->requested_at->format('d M Y, H:i') }}</p>
                            <p class="text-xs text-brand-light/40">{{ $request->requested_at->diffForHumans() }}</p>
                        </td>
                        <td class="px-6 py-4">
                            @if($request->status == 'pending')
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-yellow-500/20 text-yellow-500">
                                    Pending
                                </span>
                            @elseif($request->status == 'approved')
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-500/20 text-green-500">
                                    Disetujui
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-500/20 text-red-500">
                                    Ditolak
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.counseling_requests.show', $request) }}" 
                                   class="px-3 py-1.5 bg-brand-teal/20 text-brand-teal rounded-lg hover:bg-brand-teal/30 transition-all text-sm font-medium">
                                    Detail
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <svg class="w-16 h-16 text-brand-light/20 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                            <p class="text-brand-light/40">Tidak ada permintaan konseling</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($requests->hasPages())
    <div class="mt-6">
        {{ $requests->links() }}
    </div>
    @endif
</div>
@endsection
