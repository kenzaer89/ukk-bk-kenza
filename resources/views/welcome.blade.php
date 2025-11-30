<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BK System - Bimbingan Konseling Modern</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-brand-dark text-brand-light font-sans antialiased selection:bg-brand-teal selection:text-brand-dark">

    <!-- Navbar -->
    <nav class="fixed w-full z-50 transition-all duration-300 bg-brand-dark/80 backdrop-blur-md border-b border-brand-gray">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-brand-teal rounded-lg flex items-center justify-center text-brand-dark font-bold text-xl shadow-[0_0_15px_rgba(118,171,174,0.5)]">
                        BK
                    </div>
                    <span class="text-2xl font-bold tracking-tight text-brand-light">BK System</span>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#fitur" class="text-brand-light/80 hover:text-brand-teal transition-colors font-medium">Fitur</a>
                    <a href="#tentang" class="text-brand-light/80 hover:text-brand-teal transition-colors font-medium">Tentang</a>
                    <a href="#kontak" class="text-brand-light/80 hover:text-brand-teal transition-colors font-medium">Kontak</a>
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="bg-brand-teal text-brand-dark px-6 py-2.5 rounded-full font-bold hover:bg-[#5a8e91] transition-all shadow-[0_0_20px_rgba(118,171,174,0.3)] hover:shadow-[0_0_30px_rgba(118,171,174,0.5)] transform hover:-translate-y-0.5">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="bg-brand-teal text-brand-dark px-6 py-2.5 rounded-full font-bold hover:bg-[#5a8e91] transition-all shadow-[0_0_20px_rgba(118,171,174,0.3)] hover:shadow-[0_0_30px_rgba(118,171,174,0.5)] transform hover:-translate-y-0.5">
                                Masuk
                            </a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center justify-center pt-20 overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-brand-teal/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-1/4 w-[500px] h-[500px] bg-brand-gray/30 rounded-full blur-3xl"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center z-10">
            <div class="inline-block mb-6 px-4 py-1.5 rounded-full border border-brand-teal/30 bg-brand-teal/10 text-brand-teal text-sm font-semibold tracking-wide animate-fade-in-up">
                ✨ Sistem Bimbingan Konseling Terpadu
            </div>
            <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight mb-8 leading-tight">
                Wujudkan Masa Depan <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-teal to-white">Lebih Cerah</span>
            </h1>
            <p class="mt-4 max-w-2xl mx-auto text-xl text-brand-light/70 mb-10 leading-relaxed">
                Platform digital modern untuk memfasilitasi layanan bimbingan konseling yang efektif, 
                transparan, dan berorientasi pada perkembangan siswa.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                @guest
                    <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-4 bg-brand-teal text-brand-dark rounded-xl font-bold text-lg hover:bg-[#5a8e91] transition-all shadow-[0_0_25px_rgba(118,171,174,0.4)] hover:shadow-[0_0_35px_rgba(118,171,174,0.6)] transform hover:-translate-y-1">
                        Daftar Sekarang
                    </a>
                    <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-4 bg-brand-gray text-brand-light border border-brand-light/10 rounded-xl font-bold text-lg hover:bg-brand-gray/80 transition-all hover:border-brand-teal/50">
                        Masuk Akun
                    </a>
                @else
                    <a href="{{ url('/dashboard') }}" class="w-full sm:w-auto px-8 py-4 bg-brand-teal text-brand-dark rounded-xl font-bold text-lg hover:bg-[#5a8e91] transition-all shadow-[0_0_25px_rgba(118,171,174,0.4)] hover:shadow-[0_0_35px_rgba(118,171,174,0.6)] transform hover:-translate-y-1">
                        Akses Dashboard
                    </a>
                @endguest
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="fitur" class="py-24 bg-brand-gray/30 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4 text-brand-light">Fitur Unggulan</h2>
                <div class="w-24 h-1 bg-brand-teal mx-auto rounded-full"></div>
                <p class="mt-4 text-brand-light/60 max-w-2xl mx-auto">
                    Kami menyediakan berbagai fitur untuk mendukung efektivitas bimbingan konseling di sekolah.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Card 1 -->
                <div class="group p-8 bg-brand-gray rounded-2xl border border-brand-light/5 hover:border-brand-teal/50 transition-all duration-300 hover:shadow-[0_0_30px_rgba(118,171,174,0.15)] hover:-translate-y-2">
                    <div class="w-14 h-14 bg-brand-dark rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-brand-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-brand-light group-hover:text-brand-teal transition-colors">Penjadwalan Mudah</h3>
                    <p class="text-brand-light/60 leading-relaxed">
                        Atur jadwal konseling dengan fleksibel. Siswa dapat mengajukan sesi sesuai ketersediaan guru BK.
                    </p>
                </div>

                <!-- Card 2 -->
                <div class="group p-8 bg-brand-gray rounded-2xl border border-brand-light/5 hover:border-brand-teal/50 transition-all duration-300 hover:shadow-[0_0_30px_rgba(118,171,174,0.15)] hover:-translate-y-2">
                    <div class="w-14 h-14 bg-brand-dark rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-brand-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-brand-light group-hover:text-brand-teal transition-colors">Pencatatan Digital</h3>
                    <p class="text-brand-light/60 leading-relaxed">
                        Rekam jejak konseling, pelanggaran, dan prestasi siswa tersimpan aman dan mudah diakses.
                    </p>
                </div>

                <!-- Card 3 -->
                <div class="group p-8 bg-brand-gray rounded-2xl border border-brand-light/5 hover:border-brand-teal/50 transition-all duration-300 hover:shadow-[0_0_30px_rgba(118,171,174,0.15)] hover:-translate-y-2">
                    <div class="w-14 h-14 bg-brand-dark rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-brand-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-brand-light group-hover:text-brand-teal transition-colors">Kolaborasi Orang Tua</h3>
                    <p class="text-brand-light/60 leading-relaxed">
                        Orang tua dapat memantau perkembangan dan aktivitas siswa secara real-time melalui sistem.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-20 bg-brand-dark border-y border-brand-gray">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div class="p-4">
                    <div class="text-4xl font-bold text-brand-teal mb-2">500+</div>
                    <div class="text-brand-light/60 text-sm uppercase tracking-wider">Siswa Terdaftar</div>
                </div>
                <div class="p-4">
                    <div class="text-4xl font-bold text-brand-teal mb-2">100%</div>
                    <div class="text-brand-light/60 text-sm uppercase tracking-wider">Aman & Rahasia</div>
                </div>
                <div class="p-4">
                    <div class="text-4xl font-bold text-brand-teal mb-2">24/7</div>
                    <div class="text-brand-light/60 text-sm uppercase tracking-wider">Akses Sistem</div>
                </div>
                <div class="p-4">
                    <div class="text-4xl font-bold text-brand-teal mb-2">50+</div>
                    <div class="text-brand-light/60 text-sm uppercase tracking-wider">Guru & Staff</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-brand-gray pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-12 mb-12">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center gap-2 mb-6">
                        <div class="w-8 h-8 bg-brand-teal rounded flex items-center justify-center text-brand-dark font-bold">BK</div>
                        <span class="text-xl font-bold text-brand-light">BK System</span>
                    </div>
                    <p class="text-brand-light/50 max-w-md leading-relaxed">
                        Membangun karakter siswa melalui pendekatan konseling yang humanis dan modern. 
                        Bersama menciptakan lingkungan sekolah yang positif.
                    </p>
                </div>
                <div>
                    <h4 class="text-brand-light font-bold mb-6">Tautan Cepat</h4>
                    <ul class="space-y-4 text-brand-light/60">
                        <li><a href="#" class="hover:text-brand-teal transition-colors">Beranda</a></li>
                        <li><a href="#fitur" class="hover:text-brand-teal transition-colors">Fitur</a></li>
                        <li><a href="#tentang" class="hover:text-brand-teal transition-colors">Tentang Kami</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-brand-teal transition-colors">Login</a></li>
                    </ul>
                </div>
                <div id="kontak">
                    <h4 class="text-brand-light font-bold mb-6">Hubungi Kami</h4>
                    <ul class="space-y-4 text-brand-light/60">
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-brand-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            support@bksystem.sch.id
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-brand-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            (021) 1234-5678
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-brand-light/10 pt-8 text-center text-brand-light/40 text-sm">
                <p>&copy; {{ date('Y') }} BK System. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>
