@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="p-6 min-h-screen bg-brand-dark">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white flex items-center gap-3">
            <span class="p-2 bg-brand-teal/20 rounded-lg">
                <svg class="w-8 h-8 text-brand-teal" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </span>
            Profil Saya
        </h1>
        <p class="text-gray-400 mt-1">Kelola informasi pribadi dan pengaturan akun Anda</p>
    </div>

    <div class="max-w-4xl mx-auto">
        <!-- Main Unified Card -->
        <div class="bg-gray-800/50 backdrop-blur-xl rounded-3xl border border-white/5 overflow-hidden shadow-2xl">
            <!-- Top Section: User Visual Info -->
            <div class="p-8 md:p-10 bg-gradient-to-br from-brand-teal/20 via-transparent to-transparent border-b border-white/5">
                <div class="flex flex-col md:flex-row items-center gap-8">
                    <!-- Avatar -->
                    <div class="relative group">
                        <div class="w-28 h-28 md:w-32 md:h-32 bg-brand-teal/20 rounded-full flex items-center justify-center border-2 border-brand-teal/30 group-hover:border-brand-teal transition-all duration-500 shadow-lg shadow-brand-teal/10 group-hover:scale-105 transform">
                            <span class="text-4xl md:text-5xl font-black text-brand-teal">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        </div>
                    </div>

                    <!-- Info Context -->
                    <div class="text-center md:text-left flex-1">
                        <div class="flex flex-wrap items-center justify-center md:justify-start gap-3 mb-2">
                            <h2 class="text-2xl md:text-3xl font-black text-white tracking-tight">{{ $user->name }}</h2>
                            <span class="px-3 py-1 bg-brand-teal/10 text-brand-teal text-[10px] font-black uppercase tracking-widest rounded-full border border-brand-teal/20">
                                {{ $user->role_display_name }}
                            </span>
                        </div>
                        
                        <div class="flex flex-wrap justify-center md:justify-start gap-4 text-sm text-gray-400">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-brand-teal/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                {{ $user->email }}
                            </div>
                            @if($user->phone)
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-brand-teal/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                {{ $user->phone }}
                            </div>
                            @endif
                        </div>

                        <!-- Role specific quick chips -->
                        @if($user->role === 'student' && $user->schoolClass)
                        <div class="mt-4 flex flex-wrap justify-center md:justify-start gap-2">
                            <span class="bg-white/5 border border-white/10 px-3 py-1 rounded-lg text-xs font-bold text-brand-light">
                                Kelas: <span class="text-brand-teal ml-1">{{ $user->schoolClass->name }}</span>
                            </span>
                            <span class="bg-white/5 border border-white/10 px-3 py-1 rounded-lg text-xs font-bold text-brand-light">
                                Absen: <span class="text-brand-teal ml-1">{{ $user->absen ?? '-' }}</span>
                            </span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Form Section -->
            <div class="p-8 md:p-10">
                <form action="{{ route('profile.update') }}" method="POST" class="space-y-10">
                    @csrf
                    @method('PUT')
                    
                    <!-- Section: Informasi Dasar -->
                    <div class="space-y-6">
                        <div class="flex items-center gap-3 border-b border-white/5 pb-4">
                            <div class="p-2 bg-indigo-500/10 rounded-lg">
                                <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm5 3a2 2 0 100-4 2 2 0 000 4z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-white uppercase tracking-wider text-sm">Informasi Personal</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-1.5">
                                <label class="block text-xs font-black text-gray-500 uppercase tracking-widest pl-1">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required readonly
                                       class="w-full bg-brand-dark/30 border border-white/10 rounded-2xl px-5 py-4 text-white transition-all outline-none font-medium placeholder-gray-600 opacity-70 cursor-not-allowed">
                            </div>
                            <div class="space-y-1.5">
                                <label class="block text-xs font-black text-gray-500 uppercase tracking-widest pl-1">Alamat Email</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required readonly
                                       class="w-full bg-brand-dark/30 border border-white/10 rounded-2xl px-5 py-4 text-white transition-all outline-none font-medium placeholder-gray-600 opacity-70 cursor-not-allowed">
                            </div>
                        </div>
                    </div>

                    <!-- Action -->
                </form>
            </div>
        </div>
        
        <!-- Bottom Hint -->
        <p class="mt-8 text-center text-gray-500 text-sm italic">
            Informasi profil Anda tidak dapat diubah sendiri. Silakan hubungi admin sekolah jika terdapat kesalahan data.
        </p>
    </div>
</div>
@endsection
