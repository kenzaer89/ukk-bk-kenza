@extends('layouts.app')

@section('title', 'Verifikasi OTP')

@section('content')
<div class="min-h-screen flex items-center justify-center p-6">
    <div class="glass max-w-md w-full p-8 space-y-8">
        <div class="text-center">
            <h2 class="text-3xl font-extrabold text-brand-teal tracking-tight mb-4">Verifikasi Akun</h2>
            <p class="mt-4 text-sm text-brand-light opacity-70 leading-relaxed px-4">
                Kami telah mengirimkan 6 digit kode OTP ke email:
                <br>
                <span class="font-bold text-brand-teal text-base block mt-2">{{ Auth::user()->email }}</span>
            </p>
        </div>

        @if (session('warning'))
            <div class="p-4 bg-yellow-500/10 border border-yellow-500/30 rounded-xl text-yellow-200 text-sm text-center">
                {{ session('warning') }}
            </div>
        @endif

        @if (session('success'))
            <div class="p-4 bg-brand-teal/10 border border-brand-teal/30 rounded-xl text-brand-teal text-sm text-center font-medium">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('otp.verify') }}" class="mt-8 space-y-6">
            @csrf

            <div class="relative group">
                <label for="otp" class="block text-sm font-medium text-brand-light mb-4">Kode OTP</label>
                <input id="otp" name="otp" type="text" maxlength="6" required autofocus
                    class="w-full px-4 py-4 bg-brand-dark border border-brand-light/10 rounded-xl text-brand-light text-center text-3xl font-bold tracking-[0.6em] focus:border-brand-teal focus:ring-1 focus:ring-brand-teal transition-all placeholder-brand-light/10"
                    placeholder="------">
                @error('otp')
                    <p class="mt-2 text-sm text-red-500 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <button type="submit"
                    class="w-full py-4 px-6 bg-gradient-to-r from-brand-teal to-[#5a8e91] text-brand-dark font-extrabold rounded-xl hover:shadow-[0_0_20px_rgba(45,212,191,0.4)] transition-all duration-300 transform hover:-translate-y-1 uppercase tracking-wider">
                    Verifikasi Sekarang
                </button>
            </div>
        </form>

        <div class="text-center pt-8 border-t border-brand-light/10 mt-4">
            <p class="text-xs text-brand-light opacity-50 uppercase tracking-widest mb-3">Tidak menerima kode?</p>
            <form method="POST" action="{{ route('otp.resend') }}">
                @csrf
                <button type="submit" class="text-brand-teal font-bold hover:text-brand-teal/80 transition-colors flex items-center justify-center mx-auto gap-2 group text-sm">
                    <span>Kirim Ulang Kode OTP</span>
                    <svg class="w-4 h-4 transform group-hover:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </button>
            </form>
        </div>

        <div class="text-center mt-6">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-brand-light/40 hover:text-brand-light text-xs transition-colors flex items-center justify-center mx-auto gap-2 group italic">
                    Gunakan akun lain? <span class="underline">Keluar</span>
                </button>
            </form>
        </div>
    </div>
</div>

<style>
    /* Gradient Background for whole page overrides layout default for this specific page if needed */
    body {
        background: radial-gradient(circle at center, #1e293b, #0f172a) !important;
    }
    
    /* Center the main content if sidebar is hidden (handled by layout if not student/admin) */
    @guest
    .sidebar { display: none !important; }
    .content { width: 100% !important; padding: 0 !important; }
    @endguest

    /* If user is logged in but not verified, they might see sidebar, but let's hide it for focus */
    .sidebar { display: none !important; }
    .content { width: 100% !important; padding: 0 !important; }
</style>
@endsection
