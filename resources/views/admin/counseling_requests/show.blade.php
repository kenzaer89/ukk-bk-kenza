@extends('layouts.app')

@section('title', 'Detail Permintaan Konseling')

@section('content')
<div class="min-h-screen bg-brand-dark p-6">
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('admin.counseling_requests.index') }}" class="inline-flex items-center gap-2 text-brand-teal hover:text-brand-teal/80 mb-4">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Daftar
        </a>
        <h1 class="text-3xl font-bold text-brand-light mb-2">Detail Permintaan Konseling</h1>
        <p class="text-brand-light/60">Review dan proses permintaan konseling dari siswa</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Request Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Student Info -->
            <div class="bg-brand-gray rounded-xl border border-brand-light/10 overflow-hidden">
                <div class="bg-gradient-to-r from-brand-teal/10 to-brand-teal/5 px-6 py-4 border-b border-brand-light/10">
                    <h3 class="text-xl font-bold text-brand-light flex items-center gap-2">
                        <svg class="w-6 h-6 text-brand-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Informasi Siswa
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <p class="text-xs text-brand-light/60 uppercase tracking-wider font-semibold">Nama Lengkap</p>
                            <p class="text-brand-light font-medium text-lg">{{ $counseling_request->student->name }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-xs text-brand-light/60 uppercase tracking-wider font-semibold">Kelas</p>
                            <p class="text-brand-light font-medium text-lg">{{ $counseling_request->student->schoolClass->name ?? '-' }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-xs text-brand-light/60 uppercase tracking-wider font-semibold">No. Absen</p>
                            <p class="text-brand-light font-medium text-lg">{{ $counseling_request->student->absen ?? '-' }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-xs text-brand-light/60 uppercase tracking-wider font-semibold">Email</p>
                            <p class="text-brand-light">{{ $counseling_request->student->email }}</p>
                        </div>
                        @if($counseling_request->student->phone)
                        <div class="space-y-1">
                            <p class="text-xs text-brand-light/60 uppercase tracking-wider font-semibold">Telepon</p>
                            <p class="text-brand-light">{{ $counseling_request->student->phone }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Request Details -->
            <div class="bg-brand-gray rounded-xl border border-brand-light/10 overflow-hidden">
                <div class="bg-gradient-to-r from-brand-teal/10 to-brand-teal/5 px-6 py-4 border-b border-brand-light/10">
                    <h3 class="text-xl font-bold text-brand-light flex items-center gap-2">
                        <svg class="w-6 h-6 text-brand-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Detail Permintaan
                    </h3>
                </div>
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <p class="text-xs text-brand-light/60 uppercase tracking-wider font-semibold">Tanggal Permintaan</p>
                            <p class="text-brand-light font-medium">{{ $counseling_request->requested_at->translatedFormat('H:i d F Y') }}</p>
                            <p class="text-xs text-brand-light/40 italic">{{ $counseling_request->requested_at->diffForHumans() }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-xs text-brand-light/60 uppercase tracking-wider font-semibold">Status</p>
                            <div>
                                @if($counseling_request->status == 'pending')
                                    <span class="inline-flex px-3 py-1.5 rounded-full text-xs font-bold bg-yellow-500/20 text-yellow-500 border border-yellow-500/30">
                                        Menunggu Persetujuan
                                    </span>
                                @elseif($counseling_request->status == 'approved')
                                    <span class="inline-flex px-3 py-1.5 rounded-full text-xs font-bold bg-green-500/20 text-green-500 border border-green-500/30">
                                        Disetujui
                                    </span>
                                @else
                                    <span class="inline-flex px-3 py-1.5 rounded-full text-xs font-bold bg-red-500/20 text-red-500 border border-red-500/30">
                                        Ditolak
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-2">
                        <p class="text-xs text-brand-light/60 uppercase tracking-wider font-semibold">Alasan Konseling</p>
                        <div class="bg-brand-dark/50 rounded-lg p-5 border border-brand-light/5">
                            <p class="text-brand-light leading-relaxed whitespace-pre-wrap">{{ $counseling_request->reason }}</p>
                        </div>
                    </div>
                    
                    @if($counseling_request->teacher)
                    <div class="pt-4 border-t border-brand-light/10">
                        <div class="space-y-1">
                            <p class="text-xs text-brand-light/60 uppercase tracking-wider font-semibold">Ditangani Oleh</p>
                            <p class="text-brand-light font-medium">{{ $counseling_request->teacher->name }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <!-- Actions (moved below detail on the left column) -->
            @if($counseling_request->status == 'pending')
            <div class="space-y-6">
                <!-- Approve Form -->
                <div class="bg-brand-gray rounded-xl border border-brand-light/10 p-6 mb-6">
                    <h3 class="text-lg font-bold text-green-500 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Setujui Permintaan
                    </h3>
                    <form action="{{ route('admin.counseling_requests.approve', $counseling_request) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-brand-light mb-2">Tanggal Jadwal</label>
                            <input type="date" name="scheduled_date" required min="{{ date('Y-m-d') }}"
                                   class="w-full px-4 py-2 bg-brand-dark border border-brand-light/10 rounded-lg text-brand-light focus:border-brand-teal focus:ring-1 focus:ring-brand-teal">
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-sm font-medium text-brand-light mb-2">Waktu Mulai</label>
                                <input type="time" name="start_time" required
                                       class="w-full px-4 py-2 bg-brand-dark border border-brand-light/10 rounded-lg text-brand-light focus:border-brand-teal focus:ring-1 focus:ring-brand-teal">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-brand-light mb-2">Waktu Selesai</label>
                                <input type="time" name="end_time" required
                                       class="w-full px-4 py-2 bg-brand-dark border border-brand-light/10 rounded-lg text-brand-light focus:border-brand-teal focus:ring-1 focus:ring-brand-teal">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-brand-light mb-2">Lokasi</label>
                            <input type="text" name="location" placeholder="Ruang BK"
                                   class="w-full px-4 py-2 bg-brand-dark border border-brand-light/10 rounded-lg text-brand-light focus:border-brand-teal focus:ring-1 focus:ring-brand-teal">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-brand-light mb-2">Catatan (Opsional)</label>
                            <textarea name="notes" rows="3" placeholder="Catatan tambahan untuk siswa..."
                                      class="w-full px-4 py-2 bg-brand-dark border border-brand-light/10 rounded-lg text-brand-light focus:border-brand-teal focus:ring-1 focus:ring-brand-teal"></textarea>
                        </div>
                        <button type="submit" class="w-full px-4 py-3 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-all font-medium">
                            Setujui & Buat Jadwal
                        </button>
                    </form>
                </div>

                <!-- Reject Form -->
                <div class="bg-brand-gray rounded-xl border border-brand-light/10 p-6">
                    <h3 class="text-lg font-bold text-red-500 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Tolak Permintaan
                    </h3>
                    <form action="{{ route('admin.counseling_requests.reject', $counseling_request) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-brand-light mb-2">Alasan Penolakan (Opsional)</label>
                            <textarea name="rejection_reason" rows="3" placeholder="Jelaskan alasan penolakan..."
                                      class="w-full px-4 py-2 bg-brand-dark border border-brand-light/10 rounded-lg text-brand-light focus:border-brand-teal focus:ring-1 focus:ring-brand-teal"></textarea>
                        </div>
                        <button type="submit" onclick="return confirm('Yakin ingin menolak permintaan ini?')"
                                class="w-full px-4 py-3 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-all font-medium">
                            Tolak Permintaan
                        </button>
                    </form>
                </div>
            </div>
            @else
            <div class="bg-brand-gray rounded-xl border border-brand-light/10 p-6">
                <h3 class="text-lg font-bold text-brand-light mb-4">Status Permintaan</h3>
                <p class="text-brand-light/60 mb-4">
                    Permintaan ini telah 
                    @if($counseling_request->status == 'approved')
                        <span class="text-green-500 font-bold">disetujui</span>
                    @else
                        <span class="text-red-500 font-bold">ditolak</span>
                    @endif
                </p>
                @if($counseling_request->status == 'approved')
                <a href="{{ route('admin.schedules.index') }}" class="block w-full px-4 py-3 bg-brand-teal text-white text-center rounded-lg hover:bg-brand-teal/80 transition-all font-medium">
                    Lihat Jadwal
                </a>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
