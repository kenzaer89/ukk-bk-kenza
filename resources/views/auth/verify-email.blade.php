<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Verifikasi Email - Bimbingan Konseling</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-brand-dark text-brand-light font-sans antialiased">
    <div class="min-h-screen flex items-center justify-center px-4 py-12 relative overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-brand-teal/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-1/4 w-[500px] h-[500px] bg-brand-gray/30 rounded-full blur-3xl"></div>

        <div class="relative w-full max-w-md z-10">
            <!-- Logo/Header -->
            <div class="text-center mb-8">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 bg-brand-teal rounded-lg flex items-center justify-center text-brand-dark font-bold text-xl shadow-[0_0_15px_rgba(118,171,174,0.5)]">
                        BK
                    </div>
                    <span class="text-2xl font-bold tracking-tight text-brand-light">Bimbingan Konseling</span>
                </a>
            </div>

            <!-- Verification Card -->
            <div class="bg-brand-gray rounded-2xl border border-brand-light/10 p-8 shadow-[0_0_30px_rgba(118,171,174,0.1)]">
                <!-- Icon -->
                <div class="flex justify-center mb-6">
                    <div class="w-20 h-20 bg-brand-teal/10 rounded-full flex items-center justify-center">
                        <svg class="w-10 h-10 text-brand-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Title -->
                <h1 class="text-2xl font-bold text-brand-light text-center mb-3">Verifikasi Email Anda</h1>
                
                <!-- Description -->
                <p class="text-brand-light/70 text-center mb-6 leading-relaxed">
                    Terima kasih telah mendaftar! Sebelum memulai, mohon verifikasi alamat email Anda dengan mengklik link yang baru saja kami kirimkan.
                </p>

                <!-- Success Message -->
                @if (session('status') == 'verification-link-sent')
                    <div class="mb-6 p-4 bg-brand-teal/10 border border-brand-teal/30 rounded-lg">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-brand-teal flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-brand-teal text-sm">
                                Link verifikasi baru telah dikirim ke email yang Anda daftarkan.
                            </p>
                        </div>
                    </div>
                @endif

                <!-- Info Box -->
                <div class="mb-6 p-4 bg-brand-dark/50 border border-brand-light/5 rounded-lg">
                    <p class="text-brand-light/60 text-sm text-center">
                        Tidak menerima email? Periksa folder spam Anda atau klik tombol di bawah untuk mengirim ulang.
                    </p>
                </div>

                <!-- Actions -->
                <div class="space-y-3">
                    <!-- Resend Button -->
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button 
                            type="submit" 
                            class="w-full px-6 py-3 bg-brand-teal text-brand-dark rounded-lg font-bold hover:bg-[#5a8e91] transition-all shadow-[0_0_20px_rgba(118,171,174,0.3)] hover:shadow-[0_0_30px_rgba(118,171,174,0.5)] transform hover:-translate-y-0.5"
                        >
                            Kirim Ulang Email Verifikasi
                        </button>
                    </form>

                    <!-- Logout Button -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button 
                            type="submit" 
                            class="w-full px-6 py-3 bg-brand-dark border border-brand-light/10 text-brand-light rounded-lg font-medium hover:bg-brand-dark/80 hover:border-brand-teal/30 transition-all"
                        >
                            Keluar
                        </button>
                    </form>
                </div>
            </div>

            <!-- Help Text -->
            <div class="mt-6 text-center">
                <p class="text-brand-light/50 text-sm">
                    Butuh bantuan? Hubungi 
                    <a href="mailto:support@bksystem.sch.id" class="text-brand-teal hover:text-brand-teal/80 transition-colors">
                        support@bksystem.sch.id
                    </a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
