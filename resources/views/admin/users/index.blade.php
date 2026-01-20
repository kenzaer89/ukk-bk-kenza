@extends('layouts.app')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="p-6 min-h-screen bg-brand-dark" x-data="{ 
    showDetail: false, 
    selectedUser: null,
    openDetail(user) {
        this.selectedUser = user;
        this.showDetail = true;
    }
}">
    {{-- Header --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-white flex items-center gap-3">
                <span class="p-2 bg-indigo-500/20 rounded-lg">
                    <svg class="w-8 h-8 text-brand-teal" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </span>
                Manajemen Pengguna Sistem
            </h1>
            <p class="text-gray-400 mt-1">Kelola akun dan hak akses pengguna</p>
        </div>

        <div class="flex flex-col sm:flex-row items-center gap-4">
            <form action="{{ route('admin.users.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-2 w-full">
                @if(request('role'))
                    <input type="hidden" name="role" value="{{ request('role') }}">
                @endif
                <div class="relative group w-full sm:w-64">
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Cari nama, email..." 
                        class="w-full bg-gray-900/50 border border-gray-700/50 text-white text-sm rounded-xl px-4 py-3 pl-10 focus:ring-2 focus:ring-brand-teal focus:border-transparent transition-all duration-200 outline-none group-hover:bg-gray-800/80">
                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 group-hover:text-brand-teal transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>

                <select name="role" onchange="this.form.submit()" 
                    class="w-full sm:w-auto p-3 bg-gray-900/50 border border-gray-700/50 rounded-xl text-white text-sm focus:ring-2 focus:ring-brand-teal outline-none transition-all">
                    <option value="">-- Semua Role --</option>
                    @foreach ($roles as $role)
                        @php
                            $filterNames = [
                                'guru_bk' => 'Guru BK',
                                'wali_kelas' => 'Wali Kelas',
                                'student' => 'Murid',
                                'parent' => 'Orang Tua'
                            ];
                        @endphp
                        <option value="{{ $role }}" {{ request('role') == $role ? 'selected' : '' }}>
                            {{ $filterNames[$role] ?? strtoupper(str_replace('_', ' ', $role)) }}
                        </option>
                    @endforeach
                </select>
            </form>

            <a href="{{ route('admin.users.create') }}" 
               class="w-full sm:w-auto bg-brand-teal hover:bg-brand-teal/90 text-brand-dark font-bold py-2.5 px-6 rounded-lg transition-all duration-300 shadow-[0_0_20px_rgba(45,212,191,0.2)] flex items-center justify-center whitespace-nowrap">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Pengguna
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-500/10 border border-green-500/20 rounded-xl flex items-center gap-3 animate-fade-in">
            <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <p class="text-green-500 text-sm font-medium">{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-gray-800/40 backdrop-blur-xl border border-white/5 rounded-2xl overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <thead>
                    <tr class="bg-white/5 border-b border-white/5 text-left">
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Nama / Email</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-center">Role</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-center">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @foreach ($users as $user)
                        <tr class="hover:bg-white/5 transition-colors group">
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-brand-teal/10 rounded-full flex items-center justify-center border border-brand-teal/20 text-brand-teal font-bold group-hover:scale-110 transition-transform">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-white group-hover:text-brand-teal transition-colors">{{ $user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <span class="px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-full bg-brand-teal/10 text-brand-teal border border-brand-teal/20">
                                    {{ $user->role_display_name }}
                                </span>
                            </td>
                            <td class="px-6 py-5 text-center">
                                @if($user->is_approved)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-green-500/10 text-green-500 border border-green-500/20">
                                        <span class="w-1 h-1 rounded-full bg-green-500"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-orange-500/10 text-orange-500 border border-orange-500/20">
                                        <span class="w-1 h-1 rounded-full bg-orange-500"></span>
                                        Menunggu
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button @click="openDetail({
                                        name: '{{ $user->name }}',
                                        email: '{{ $user->email }}',
                                        phone: '{{ preg_match('/^[0-9+ \-\(\).]+$/', $user->phone) ? $user->phone : "-" }}',
                                        nip: '{{ $user->nip ?: '-' }}',
                                        role: '{{ $user->role }}',
                                        role_display: '{{ $user->role_display_name }}',
                                        nisn: '{{ $user->nisn ?? '-' }}',
                                        absen: '{{ $user->absen ?? '-' }}',
                                        points: '{{ $user->points ?? '-' }}',
                                        class: '{{ $user->role === "wali_kelas" ? ($user->managedClass?->name ?? "-") : ($user->schoolClass?->name ?? "-") }}',
                                        jurusan: '{{ $user->specialization_full_name ?? '-' }}',
                                        children: '{{ $user->students?->pluck('name')->join(', ') ?: '-' }}',
                                        is_approved: {{ $user->is_approved ? 'true' : 'false' }}
                                    })" class="p-2 bg-white/5 hover:bg-brand-teal text-gray-400 hover:text-brand-dark rounded-lg transition-all" title="Detail">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </button>

                                    @if (!$user->is_approved)
                                        <form action="{{ route('admin.users.approve', $user) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="p-2 bg-white/5 hover:bg-green-500 text-gray-400 hover:text-white rounded-lg transition-all" title="Setujui">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif

                                    @if ($user->email !== 'adminbk@gmail.com')
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline delete-user-form" 
                                              data-user-name="{{ $user->name }}"
                                              data-user-email="{{ $user->email }}"
                                              data-user-role="{{ $user->role }}"
                                              data-user-class="{{ $user->role === 'student' ? ($user->schoolClass->name ?? '-') : '' }}">
                                            @csrf @method('DELETE')
                                            <button type="button" onclick="confirmDelete(this)" class="p-2 bg-white/5 hover:bg-red-500 text-gray-400 hover:text-white rounded-lg transition-all" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-6 bg-white/5 border-t border-white/5">
            {{ $users->links() }}
        </div>
    </div>

    {{-- Modal Detail User --}}
    <div x-show="showDetail" 
         class="fixed inset-0 z-50 flex items-center justify-center px-4"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <div class="fixed inset-0 bg-brand-dark/90 backdrop-blur-md" @click="showDetail = false"></div>
        
        <div class="relative bg-brand-gray/95 border border-white/10 w-full max-w-lg rounded-3xl shadow-2xl overflow-hidden"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 scale-95 translate-y-8"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0">
            
            {{-- Modal Header --}}
            <div class="px-8 py-6 border-b border-white/5 bg-white/5 flex justify-between items-center">
                <div>
                    <h3 class="text-2xl font-black text-white tracking-tight">Detail Pengguna</h3>
                    <p class="text-xs text-brand-teal font-black uppercase tracking-widest mt-1" x-text="'Role: ' + selectedUser?.role_display"></p>
                </div>
                <button @click="showDetail = false" class="p-2 hover:bg-white/10 rounded-full transition-all text-gray-400 hover:text-white">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div class="p-8 space-y-8 max-h-[70vh] overflow-y-auto">
                {{-- Data Utama --}}
                <div class="grid grid-cols-2 gap-8">
                    <div class="col-span-2">
                        <label class="text-[9px] font-bold text-gray-500 uppercase tracking-widest block mb-1">Nama Lengkap</label>
                        <p class="text-xl font-bold text-white tracking-tight" x-text="selectedUser?.name"></p>
                    </div>
                    <div>
                        <label class="text-[9px] font-bold text-gray-500 uppercase tracking-widest block mb-1">Alamat Email</label>
                        <p class="text-brand-teal font-medium" x-text="selectedUser?.email"></p>
                    </div>
                    <div>
                        <label class="text-[9px] font-bold text-gray-500 uppercase tracking-widest block mb-1">Nomor Telepon</label>
                        <p class="text-white font-medium" x-text="selectedUser?.phone"></p>
                    </div>
                </div>

                <div class="h-px bg-gradient-to-r from-transparent via-white/5 to-transparent"></div>

                {{-- Role-specific data --}}
                <div class="space-y-6">
                    <template x-if="selectedUser?.role === 'student'">
                        <div class="space-y-4">
                            <!-- NISN - Full Width -->
                            <div class="bg-brand-teal/10 p-5 rounded-2xl border border-brand-teal/20">
                                <label class="text-[9px] font-bold text-brand-teal uppercase tracking-widest block mb-1">NISN (Nomor Induk Siswa Nasional)</label>
                                <p class="text-2xl font-black text-brand-teal" x-text="selectedUser?.nisn"></p>
                            </div>
                            
                            <!-- Grid Info -->
                            <div class="bg-white/5 p-4 rounded-2xl border border-white/5">
                                <label class="text-[9px] font-bold text-gray-400 uppercase tracking-widest block mb-1">Nomor Absen</label>
                                <p class="text-2xl font-black text-white" x-text="selectedUser?.absen"></p>
                            </div>
                            <div class="bg-white/5 p-4 rounded-2xl border border-white/5">
                                <label class="text-[9px] font-bold text-gray-400 uppercase tracking-widest block mb-1">Poin Kredit</label>
                                <p class="text-2xl font-black text-brand-teal" x-text="selectedUser?.points"></p>
                            </div>
                            <div class="bg-white/5 p-4 rounded-2xl border border-white/5">
                                <label class="text-[9px] font-bold text-gray-400 uppercase tracking-widest block mb-1">Kelas</label>
                                <p class="text-lg font-bold text-white" x-text="selectedUser?.class"></p>
                            </div>
                            <div class="bg-white/5 p-4 rounded-2xl border border-white/5">
                                <label class="text-[9px] font-bold text-gray-400 uppercase tracking-widest block mb-1">Jurusan</label>
                                <p class="text-sm font-bold text-white leading-tight" x-text="selectedUser?.jurusan"></p>
                            </div>
                        </div>
                    </template>

                    <template x-if="selectedUser?.role === 'parent'">
                        <div class="space-y-4">
                            <div class="bg-white/5 p-5 rounded-2xl border border-white/5">
                                <label class="text-[9px] font-bold text-gray-500 uppercase tracking-widest block mb-2">Nama Anak / Murid</label>
                                <div class="flex flex-wrap gap-2">
                                    <span class="px-3 py-1 bg-brand-teal/10 text-brand-teal text-xs font-bold rounded-lg" x-text="selectedUser?.children"></span>
                                </div>
                            </div>
                        </div>
                    </template>

                    <template x-if="selectedUser?.role === 'guru_bk' || selectedUser?.role === 'wali_kelas'">
                        <div class="space-y-4">
                            <div class="bg-brand-teal/10 p-5 rounded-2xl border border-brand-teal/20">
                                <label class="text-[9px] font-bold text-brand-teal uppercase tracking-widest block mb-1">NIP (Nomor Induk Pegawai)</label>
                                <p class="text-2xl font-black text-brand-teal" x-text="selectedUser?.nip"></p>
                            </div>
                            
                            <template x-if="selectedUser?.role === 'wali_kelas' && selectedUser?.class && selectedUser?.class !== '-'">
                                <div class="bg-brand-teal/10 p-5 rounded-2xl border border-brand-teal/20 mt-4">
                                    <label class="text-[9px] font-bold text-brand-teal uppercase tracking-widest block mb-2">Wali Kelas Dari</label>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5 text-brand-teal" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                        <p class="text-2xl font-black text-brand-teal" x-text="selectedUser?.class"></p>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>

                {{-- Footer --}}
                <div class="pt-4">
                    <button @click="showDetail = false" class="w-full py-4 bg-brand-teal hover:bg-brand-teal/90 text-brand-dark font-black uppercase tracking-widest rounded-2xl transition-all shadow-lg text-sm">
                        Tutup Detail
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function confirmDelete(button) {
    const form = button.closest('form');
    const userName = form.dataset.userName;
    const userEmail = form.dataset.userEmail;
    const userRole = form.dataset.userRole;
    const userClass = form.dataset.userClass;
    
    // Build user info display
    let userDetails = `
        <div style="background: linear-gradient(135deg, rgba(45, 212, 191, 0.1) 0%, rgba(45, 212, 191, 0.05) 100%); 
                    padding: 1.5rem; 
                    border-radius: 1rem; 
                    border: 2px solid rgba(45, 212, 191, 0.3);
                    margin-bottom: 1.5rem;">
            <div style="text-align: center;">
                <div style="width: 80px; 
                           height: 80px; 
                           margin: 0 auto 1rem; 
                           background: linear-gradient(135deg, #2dd4bf 0%, #0d9488 100%); 
                           border-radius: 50%; 
                           display: flex; 
                           align-items: center; 
                           justify-content: center;
                           box-shadow: 0 8px 20px rgba(45, 212, 191, 0.3);">
                    <span style="font-size: 2.5rem; font-weight: 900; color: #0f172a;">${userName.charAt(0).toUpperCase()}</span>
                </div>
                <h3 style="margin: 0 0 0.5rem 0; font-size: 1.5rem; font-weight: 800; color: #2dd4bf;">${userName}</h3>
                <p style="margin: 0 0 0.25rem 0; color: #94a3b8; font-size: 0.9rem;">📧 ${userEmail}</p>
                ${userRole === 'student' && userClass && userClass !== '-' ? 
                    `<p style="margin: 0; color: #2dd4bf; font-weight: 700; font-size: 1rem;">🎓 ${userClass}</p>` 
                    : ''}
            </div>
        </div>
    `;
    
    Swal.fire({
        title: '🗑️ Hapus Pengguna?',
        html: `
            <div style="padding: 0.5rem;">
                ${userDetails}
                <div style="background: rgba(239, 68, 68, 0.1); 
                           padding: 1rem; 
                           border-radius: 0.75rem; 
                           border-left: 4px solid #EF4444;">
                    <p style="margin: 0; color: #f87171; font-size: 0.9rem; line-height: 1.6; font-weight: 500;">
                        ⚠️ Semua data pengguna ini akan terhapus permanen dan tidak dapat dikembalikan.
                    </p>
                </div>
            </div>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#EF4444',
        cancelButtonColor: '#64748b',
        confirmButtonText: '✓ Ya, Hapus',
        cancelButtonText: '✕ Batal',
        customClass: {
            popup: 'swal-delete-popup',
            title: 'swal-delete-title',
            htmlContainer: 'swal-delete-content',
            confirmButton: 'swal-confirm-delete-btn',
            cancelButton: 'swal-cancel-btn'
        },
        buttonsStyling: true,
        allowOutsideClick: false,
        allowEscapeKey: true,
        width: '32rem',
        showClass: {
            popup: 'animate__animated animate__zoomIn animate__faster'
        },
        hideClass: {
            popup: 'animate__animated animate__zoomOut animate__faster'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}
</script>
@endpush
@endsection