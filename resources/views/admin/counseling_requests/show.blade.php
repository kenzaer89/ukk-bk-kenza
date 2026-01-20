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
        <h1 class="text-3xl font-bold text-brand-light mb-2 flex items-center gap-3">
            <span class="p-2 bg-indigo-500/20 rounded-lg">
                <svg class="w-8 h-8 text-brand-teal" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </span>
            Detail Permintaan Konseling
        </h1>
        <p class="text-brand-light/60">Review dan proses permintaan konseling dari siswa</p>
    </div>

    <!-- Messages -->
    @if(session('success'))
        <div class="bg-green-500/20 border border-green-500/50 p-4 rounded-xl mb-6 text-green-500 text-sm font-bold flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-500/20 border border-red-500/50 p-4 rounded-xl mb-6 text-red-500 text-sm font-bold flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ session('error') }}
        </div>
    @endif
    @if($errors->any())
        <div class="bg-red-500/20 border border-red-500/50 p-4 rounded-xl mb-6">
            <ul class="list-disc list-inside text-red-500 text-sm font-medium">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

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
                        <div class="space-y-1">
                            <p class="text-xs text-brand-light/60 uppercase tracking-wider font-semibold">NISN</p>
                            <p class="text-brand-light">{{ $counseling_request->student->nisn ?? '-' }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-xs text-brand-light/60 uppercase tracking-wider font-semibold">Telepon</p>
                            <p class="text-brand-light">{{ $counseling_request->student->phone ?? '-' }}</p>
                        </div>
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
                        <div class="space-y-2">
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
                                @elseif($counseling_request->status == 'canceled')
                                    <span class="inline-flex px-3 py-1.5 rounded-full text-xs font-bold bg-gray-500/20 text-gray-500 border border-gray-500/30">
                                        Dibatalkan
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
                        <div class="bg-brand-dark/50 rounded-xl p-6 border border-brand-light/10 shadow-inner">
                            @if(str_starts_with($counseling_request->reason, '[Topik:'))
                                @php
                                    preg_match('/^\[Topik:\s*(.*?)\]\s*(.*)$/s', $counseling_request->reason, $matches);
                                    $topicName = $matches[1] ?? 'Custom';
                                    $actualReason = trim($matches[2] ?? '');
                                @endphp
                                <div class="mb-4 pb-4 border-b border-brand-light/10">
                                    <span class="text-xs font-bold text-brand-teal uppercase tracking-widest block mb-1">Topik Custom</span>
                                    <p class="text-lg font-semibold text-brand-light">{{ $topicName }}</p>
                                </div>
                                <div class="space-y-1">
                                    <span class="text-xs font-bold text-brand-light/40 uppercase tracking-widest block">Detail Alasan</span>
                                    <p class="text-brand-light leading-relaxed whitespace-pre-wrap break-words">{{ $actualReason }}</p>
                                </div>
                            @else
                                @if($counseling_request->topic)
                                    <div class="mb-4 pb-4 border-b border-brand-light/10">
                                        <span class="text-xs font-bold text-brand-teal uppercase tracking-widest block mb-1">Topik</span>
                                        <p class="text-lg font-semibold text-brand-light">{{ $counseling_request->topic->name }}</p>
                                    </div>
                                @endif
                                <div class="space-y-1">
                                    <span class="text-xs font-bold text-brand-light/40 uppercase tracking-widest block">Detail Alasan</span>
                                    <p class="text-brand-light leading-relaxed whitespace-pre-wrap break-words">{{ $counseling_request->reason }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    @if($counseling_request->status == 'approved' && $counseling_request->schedule)
                    <div class="pt-4 border-t border-brand-light/10">
                        <div class="space-y-2">
                            <p class="text-xs text-brand-light/60 uppercase tracking-wider font-semibold">Jadwal Konseling</p>
                            <div class="bg-brand-dark/30 rounded-lg p-4 border border-brand-light/5 grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <span class="text-[10px] text-brand-light/40 uppercase font-bold block mb-1">Tanggal</span>
                                    <p class="text-brand-light font-bold text-lg">
                                        {{ \Carbon\Carbon::parse($counseling_request->schedule->scheduled_date)->translatedFormat('l, d F Y') }}
                                    </p>
                                </div>
                                <div>
                                    <span class="text-[10px] text-brand-light/40 uppercase font-bold block mb-1">Waktu</span>
                                    <p class="text-brand-teal font-bold text-lg">
                                        {{ \Carbon\Carbon::parse($counseling_request->schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($counseling_request->schedule->end_time)->format('H:i') }} WIB
                                    </p>
                                </div>
                                <div>
                                    <span class="text-[10px] text-brand-light/40 uppercase font-bold block mb-1">Lokasi</span>
                                    <p class="text-brand-light font-medium">{{ $counseling_request->schedule->location }}</p>
                                </div>
                                <div>
                                    <span class="text-[10px] text-brand-light/40 uppercase font-bold block mb-1">Ditangani Oleh</span>
                                    <p class="text-brand-light font-medium">{{ $counseling_request->teacher_name ?? $counseling_request->teacher->name }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @elseif($counseling_request->teacher_name || $counseling_request->teacher)
                    <div class="pt-4 border-t border-brand-light/10">
                        <div class="space-y-1">
                            <p class="text-xs text-brand-light/60 uppercase tracking-wider font-semibold">Ditangani Oleh</p>
                            <p class="text-brand-light font-medium">{{ $counseling_request->teacher_name ?? $counseling_request->teacher->name }}</p>
                        </div>
                    </div>
                    @endif
                    
                    @if($counseling_request->notes)
                    <div class="pt-4 border-t border-brand-light/10">
                        <div class="space-y-2">
                            <p class="text-xs text-brand-light/60 uppercase tracking-wider font-semibold">
                                @if($counseling_request->status == 'rejected')
                                    Alasan Penolakan
                                @else
                                    Catatan Guru BK
                                @endif
                            </p>
                            <div class="bg-brand-dark/50 rounded-lg p-4 border border-brand-light/5">
                                <p class="text-brand-light leading-relaxed whitespace-pre-wrap break-words">{{ $counseling_request->notes }}</p>
                            </div>
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
                            <label class="block text-sm font-medium text-brand-light mb-2">Guru Yang Menangani</label>
                            <input type="text" name="teacher_name" 
                                   id="teacher_name"
                                   placeholder="Ketik nama guru..." 
                                   autocomplete="off"
                                   required
                                   class="w-full px-4 py-2 bg-brand-dark border border-brand-light/10 rounded-lg text-brand-light focus:border-brand-teal focus:ring-1 focus:ring-brand-teal transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-brand-light mb-2">Tanggal Konseling</label>
                             <input type="date" name="scheduled_date" required style="color-scheme: dark;"
                                   id="scheduled_date"
                                   value="{{ date('Y-m-d') }}"
                                   min="{{ date('Y-m-d') }}"
                                   class="w-full px-4 py-2 bg-brand-dark border border-brand-light/10 rounded-lg text-brand-light focus:border-brand-teal focus:ring-1 focus:ring-brand-teal">
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-sm font-medium text-brand-light mb-2">Waktu Mulai</label>
                                <input type="time" name="start_time" id="start_time" required style="color-scheme: dark;"
                                       class="w-full px-4 py-2 bg-brand-dark border border-brand-light/10 rounded-lg text-brand-light focus:border-brand-teal focus:ring-1 focus:ring-brand-teal">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-brand-light mb-2">Waktu Selesai</label>
                                <input type="time" name="end_time" id="end_time" required style="color-scheme: dark;"
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
                            <textarea name="notes" rows="3" placeholder="Catatan tambahan untuk siswa..." maxlength="500"
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
                    <form id="rejectForm" action="{{ route('admin.counseling_requests.reject', $counseling_request) }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="rejection_reason" id="rejection_reason_input">
                        <p class="text-sm text-brand-light/60 mb-4">Pastikan Anda memberikan alasan penolakan yang jelas kepada siswa.</p>
                        <button type="button" onclick="handleReject()"
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
                    @elseif($counseling_request->status == 'canceled')
                        <span class="text-gray-400 font-bold">dibatalkan</span>
                    @else
                        <span class="text-red-500 font-bold">ditolak</span>
                    @endif
                </p>
                <a href="{{ route('admin.counseling_requests.index') }}" class="block w-full px-4 py-3 bg-brand-teal text-brand-dark text-center rounded-lg hover:bg-brand-teal/80 transition-all font-bold">
                    Kembali
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const approveForm = document.querySelector('form[action*="approve"]');
        if (approveForm) {
            const startTimeInput = approveForm.querySelector('input[name="start_time"]');
            const endTimeInput = approveForm.querySelector('input[name="end_time"]');
            const dateInput = approveForm.querySelector('input[name="scheduled_date"]');

            function validateTime() {
                if (startTimeInput.value && endTimeInput.value) {
                    if (endTimeInput.value <= startTimeInput.value) {
                        endTimeInput.setCustomValidity('waktu selesai tidak boleh sama atau kurang dari waktu pukul');
                    } else {
                        endTimeInput.setCustomValidity('');
                    }
                }
            }

            startTimeInput.addEventListener('change', validateTime);
            endTimeInput.addEventListener('change', validateTime);
            
            approveForm.addEventListener('submit', function(e) {
                if (approveForm.dataset.confirmed === 'true') {
                    return;
                }
                
                // Custom validity check first
                validateTime();
                if (!endTimeInput.checkValidity()) {
                    e.preventDefault();
                    endTimeInput.reportValidity();
                    return;
                }
                
                // Prevent default submission to check conflicts
                e.preventDefault();

                // UI Loading State
                const submitBtn = approveForm.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Memproses...
                `;

                const startTime = startTimeInput.value;
                const endTime = endTimeInput.value;
                const date = dateInput ? dateInput.value : '{{ date("Y-m-d") }}'; // Fallback to PHP date if input missing
                const location = approveForm.querySelector('input[name="location"]') ? approveForm.querySelector('input[name="location"]').value : '';
                const studentId = '{{ $counseling_request->student_id }}';
                
                // Fetch to check conflict
                fetch(`{{ route('admin.counseling_requests.check_conflict') }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        date: date,
                        start_time: startTime,
                        end_time: endTime
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.conflict) {
                            // Reset loading state if conflict
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalText;

                            const details = data.details;
                            Swal.fire({
                                title: '⚠️ Jadwal Bentrok!',
                                html: `
                                    <div style="text-align: left; padding: 1rem;">
                                        <div style="background: linear-gradient(135deg, #FEF3C7 0%, #FDE68A 100%); border-left: 4px solid #F59E0B; padding: 1rem; border-radius: 0.75rem; margin-bottom: 1rem;">
                                            <p style="margin: 0; color: #92400E; font-weight: 600; font-size: 0.95rem; line-height: 1.6;">
                                                Jadwal bertabrakan dengan <strong>${details.student_name}</strong> (${details.class_name}) pada <strong>${details.time_range} WIB</strong>.
                                            </p>
                                        </div>
                                        <div style="background: rgba(255, 255, 255, 0.05); padding: 1rem; border-radius: 0.75rem; border: 1px solid rgba(255, 255, 255, 0.1);">
                                            <p style="margin: 0 0 0.5rem 0; color: #94a3b8; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 700;">
                                                ⏰ Waktu yang dipilih
                                            </p>
                                            <p style="margin: 0; color: #f8fafc; font-size: 1.1rem; font-weight: 600;">
                                                ${startTime} - ${endTime} WIB
                                            </p>
                                        </div>
                                        <div style="margin-top: 1.5rem; padding: 1rem; background: rgba(45, 212, 191, 0.1); border-radius: 0.75rem; border: 1px solid rgba(45, 212, 191, 0.2);">
                                            <p style="margin: 0; color: #2dd4bf; font-size: 0.9rem; font-weight: 500; line-height: 1.6;">
                                                💡 <strong>Tips:</strong> Silakan ubah waktu konseling, atau klik <strong>"Lanjutkan"</strong> jika Anda yakin ingin tetap menyetujui permintaan ini meskipun bentrok dengan jadwal lain.
                                            </p>
                                        </div>
                                    </div>
                                `,
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#2dd4bf',
                                cancelButtonColor: '#64748b',
                                confirmButtonText: '✓ Lanjutkan Tetap',
                                cancelButtonText: '✕ Batal',
                                customClass: {
                                    popup: 'swal-conflict-popup',
                                    title: 'swal-conflict-title',
                                    htmlContainer: 'swal-conflict-content',
                                    confirmButton: 'swal-confirm-btn',
                                    cancelButton: 'swal-cancel-btn'
                                },
                                buttonsStyling: true,
                                allowOutsideClick: false,
                                allowEscapeKey: true,
                                showClass: {
                                    popup: 'animate__animated animate__fadeInDown animate__faster'
                                },
                                hideClass: {
                                    popup: 'animate__animated animate__fadeOutUp animate__faster'
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Add bypass flag
                                    const hiddenInput = document.createElement('input');
                                    hiddenInput.type = 'hidden';
                                    hiddenInput.name = 'ignore_conflict';
                                    hiddenInput.value = '1';
                                    approveForm.appendChild(hiddenInput);
                                    
                                    approveForm.dataset.confirmed = 'true';
                                    approveForm.submit();
                                }
                            });
                        } else {
                            // No conflict, safe to submit
                            approveForm.dataset.confirmed = 'true';
                            approveForm.submit();
                        }
                    })
                    .catch(error => {
                        console.error('Error checking conflict:', error);
                        // Reset button on error for fallback attempt
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalText;
                        approveForm.submit();
                    });
            });
        }
    });

    // Handle Reject with Pop-up Reason
    function handleReject() {
        Swal.fire({
            title: 'Tolak Permintaan',
            text: 'Harap masukkan alasan penolakan:',
            input: 'textarea',
            inputPlaceholder: 'Jelaskan mengapa permintaan ini ditolak...',
            inputAttributes: {
                'aria-label': 'Alasan Penolakan',
                'maxlength': 500
            },
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Tolak',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#ef4444',
            inputValidator: (value) => {
                if (!value) {
                    return 'Alasan penolakan wajib diisi!'
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('rejection_reason_input').value = result.value;
                document.getElementById('rejectForm').submit();
            }
        });
    }
</script>
@endpush
@endsection
