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
                                        class: '{{ $user->role === 'wali_kelas' ? ($user->managedClass?->name ?? '-') : ($user->schoolClass?->name ?? '-') }}',
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
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 bg-white/5 hover:bg-red-500 text-gray-400 hover:text-white rounded-lg transition-all" title="Hapus">
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
                        <div class="flex items-center gap-3">
                            <p class="text-white font-medium" x-text="selectedUser?.phone"></p>
                            <template x-if="selectedUser?.phone && selectedUser?.phone !== '-'">
                                <div class="flex items-center gap-2">
                                    <a :href="'tel:' + selectedUser?.phone" class="p-1 bg-white/5 hover:bg-brand-teal text-gray-400 hover:text-brand-dark rounded transition-all" title="Telepon">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                    </a>
                                    <a :href="'https://wa.me/' + (selectedUser?.phone || '').replace(/[^0-9]/g, '')" target="_blank" class="p-1 bg-white/5 hover:bg-green-500 text-gray-400 hover:text-white rounded transition-all" title="WhatsApp">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.246 2.248 3.484 5.232 3.484 8.412-.003 6.557-5.338 11.892-11.893 11.892-1.997-.001-3.951-.5-5.688-1.448l-6.309 1.656zm6.223-3.828c1.53.912 3.51 1.558 5.628 1.559 5.454 0 9.893-4.439 9.896-9.895.002-2.641-1.026-5.124-2.895-6.995-1.868-1.869-4.352-2.896-6.994-2.896-5.455 0-9.893 4.439-9.896 9.895-.001 2.15.56 4.24 1.62 6.059l-1.066 3.893 3.996-1.047zm11.367-7.462c-.312-.156-1.848-.912-2.134-1.017-.286-.105-.494-.156-.701.156-.207.312-.801 1.017-.982 1.223-.182.206-.364.232-.676.077-.312-.156-1.316-.485-2.508-1.548-.926-.826-1.551-1.846-1.733-2.158-.182-.312-.019-.481-.175-.636-.14-.139-.312-.364-.468-.546-.156-.182-.208-.312-.312-.52-.104-.208-.052-.39-.026-.546.026-.156.208-.52.312-.728.104-.208.156-.364.234-.52.078-.156.039-.286-.02-.442-.058-.156-.494-1.196-.676-1.638-.177-.427-.357-.369-.491-.376-.127-.007-.273-.008-.419-.008-.146 0-.383.055-.584.273-.201.218-.767.751-.767 1.832 0 1.081.787 2.126.897 2.276.109.15.539 2.274 2.296 3.033.418.18.744.287 1.0.368.42.133.801.114 1.103.069.336-.05.845-.345 1.04-.678.195-.333.195-.618.136-.678-.058-.06-.215-.156-.527-.312z"></path>
                                        </svg>
                                    </a>
                                </div>
                            </template>
                        </div>
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
                            
                            <template x-if="selectedUser?.role === 'wali_kelas' && selectedUser?.class !== '-'">
                                <div class="bg-brand-teal/10 p-5 rounded-2xl border border-brand-teal/20">
                                    <label class="text-[9px] font-bold text-brand-teal uppercase tracking-widest block mb-2">Wali Kelas</label>
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
@endsection