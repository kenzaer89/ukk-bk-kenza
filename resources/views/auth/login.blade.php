<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk - BK System</title>
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
                    <span class="text-2xl font-bold tracking-tight text-brand-light">BK System</span>
                </a>
                <h1 class="text-3xl font-bold text-brand-light mb-2">Selamat Datang Kembali</h1>
                <p class="text-brand-light/60">Masuk ke akun Anda untuk melanjutkan</p>
            </div>

            <!-- Login Form -->
            <div class="bg-brand-gray rounded-2xl border border-brand-light/10 p-8 shadow-[0_0_30px_rgba(118,171,174,0.1)]">
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-500/10 border border-red-500/30 rounded-lg">
                        <p class="text-red-400 text-sm">{{ $errors->first() }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-brand-light font-medium mb-2">Email</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required 
                            autofocus
                            class="w-full px-4 py-3 bg-brand-dark border border-brand-light/10 rounded-lg text-brand-light placeholder-brand-light/40 focus:outline-none focus:border-brand-teal/50 focus:ring-2 focus:ring-brand-teal/20 transition-all"
                            placeholder="nama@email.com"
                        >
                        @error('email')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-brand-light font-medium mb-2">Password</label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            required
                            class="w-full px-4 py-3 bg-brand-dark border border-brand-light/10 rounded-lg text-brand-light placeholder-brand-light/40 focus:outline-none focus:border-brand-teal/50 focus:ring-2 focus:ring-brand-teal/20 transition-all"
                            placeholder="••••••••"
                        >
                        @error('password')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between text-sm">
                        <label class="flex items-center gap-2 text-brand-light/70 cursor-pointer">
                            <input 
                                type="checkbox" 
                                name="remember" 
                                class="w-4 h-4 rounded border-brand-light/20 bg-brand-dark text-brand-teal focus:ring-brand-teal/20 focus:ring-offset-0"
                            >
                            <span>Ingat saya</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-brand-teal hover:text-brand-teal/80 transition-colors">
                                Lupa password?
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit" 
                        class="w-full px-6 py-3 bg-brand-teal text-brand-dark rounded-lg font-bold text-lg hover:bg-[#5a8e91] transition-all shadow-[0_0_20px_rgba(118,171,174,0.3)] hover:shadow-[0_0_30px_rgba(118,171,174,0.5)] transform hover:-translate-y-0.5"
                    >
                        Masuk
                    </button>
                </form>

                <!-- Register Link -->
                <div class="mt-6 text-center text-sm text-brand-light/60">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-brand-teal hover:text-brand-teal/80 font-semibold transition-colors ml-1">
                        Daftar sekarang
                    </a>
                </div>
            </div>

            <!-- Back to Home -->
            <div class="mt-6 text-center">
                <a href="{{ route('home') }}" class="text-brand-light/60 hover:text-brand-teal text-sm transition-colors inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke beranda
                </a>
            </div>
        </div>
    </div>
</body>
</html>
