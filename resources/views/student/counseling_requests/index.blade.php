@extends('layouts.app')

@section('title', 'Permintaan Konseling Saya')

@section('content')
<div class="min-h-screen bg-brand-dark p-6">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-brand-light mb-2">Permintaan Konseling Saya</h1>
        <p class="text-brand-light/60">Kelola dan pantau status permintaan konseling Anda</p>
    </div>

    <!-- Success Message -->
    @if (session('success'))
        <div class="mb-6 p-4 bg-brand-teal/10 border border-brand-teal/30 rounded-lg">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-brand-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-brand-teal">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 p-4 bg-red-500/10 border border-red-500/30 rounded-lg">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-red-500">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <!-- Action Button -->
    <div class="mb-6">
        <a href="{{ route('student.counseling_requests.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-brand-teal text-brand-dark rounded-lg font-bold hover:bg-[#5a8e91] transition-all shadow-[0_0_20px_rgba(118,171,174,0.3)] hover:shadow-[0_0_30px_rgba(118,171,174,0.5)] transform hover:-translate-y-0.5">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Ajukan Permintaan Baru
        </a>
    </div>

    <!-- Requests List -->
    @if($requests->count() > 0)
        <div class="space-y-4">
            @foreach($requests as $request)
            <div class="bg-brand-gray rounded-xl border border-brand-light/10 p-6 hover:border-brand-teal/30 transition-all">
                <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="px-3 py-1 rounded-full text-xs font-bold
                                @if($request->status === 'pending') bg-yellow-500/20 text-yellow-500
                                @elseif($request->status === 'approved') bg-green-500/20 text-green-500
                                @else bg-red-500/20 text-red-500
                                @endif">
                                @if($request->status === 'pending') Menunggu
                                @elseif($request->status === 'approved') Disetujui
                                @else Ditolak
                                @endif
                            </span>
                            <span class="text-sm text-brand-light/60">
                                {{ $request->requested_at->translatedFormat('H:i d F Y') }}
                            </span>
                        </div>
                        
                        <p class="text-brand-light mb-2 leading-relaxed">{{ $request->reason }}</p>
                        
                        @if($request->teacher)
                        <p class="text-sm text-brand-light/60">
                            <span class="text-brand-teal">Ditangani oleh:</span> {{ $request->teacher->name }}
                        </p>
                        @endif
                    </div>

                    @if($request->status === 'pending')
                    <div>
                        <form method="POST" action="{{ route('student.counseling_requests.cancel', $request) }}" onsubmit="return confirm('Yakin ingin membatalkan permintaan ini?')">
                            @csrf
                            <button 
                                type="submit" 
                                class="px-4 py-2 bg-red-500/10 border border-red-500/30 text-red-500 rounded-lg font-medium hover:bg-red-500/20 transition-all text-sm"
                            >
                                Batalkan
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $requests->links() }}
        </div>
    @else
        <div class="bg-brand-gray rounded-xl border border-brand-light/10 p-12 text-center">
            <svg class="w-20 h-20 text-brand-light/20 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 class="text-xl font-bold text-brand-light mb-2">Belum Ada Permintaan</h3>
            <p class="text-brand-light/60 mb-6">Anda belum pernah mengajukan permintaan konseling</p>
            <a href="{{ route('student.counseling_requests.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-brand-teal text-brand-dark rounded-lg font-bold hover:bg-[#5a8e91] transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Ajukan Sekarang
            </a>
        </div>
    @endif
</div>
@endsection