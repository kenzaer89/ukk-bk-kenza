<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk - Bimbingan Konseling</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
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

                <form method="POST" action="{{ route('login') }}" class="space-y-5" id="login-form">
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
                        <div class="relative">
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                required
                                class="w-full px-4 py-3 bg-brand-dark border border-brand-light/10 rounded-lg text-brand-light placeholder-brand-light/40 focus:outline-none focus:border-brand-teal/50 focus:ring-2 focus:ring-brand-teal/20 transition-all pr-12"
                                placeholder="••••••••"
                            >
                            <button 
                                type="button" 
                                onclick="togglePasswordVisibility()"
                                class="absolute inset-y-0 right-0 flex items-center px-4 text-brand-light/60 hover:text-brand-teal focus:outline-none transition-colors"
                            >
                                <!-- Icon Eye (Show Password) - Displays when visible -->
                                <svg id="eye-icon-show" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <!-- Icon Eye Slash (Hide Password) - Displays when hidden -->
                                <svg id="eye-icon-hide" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror

                        <script>
                            function togglePasswordVisibility() {
                                const passwordInput = document.getElementById('password');
                                const eyeShow = document.getElementById('eye-icon-show');
                                const eyeHide = document.getElementById('eye-icon-hide');
                        
                                if (passwordInput.type === 'password') {
                                    passwordInput.type = 'text';
                                    eyeShow.classList.remove('hidden');
                                    eyeHide.classList.add('hidden');
                                } else {
                                    passwordInput.type = 'password';
                                    eyeShow.classList.add('hidden');
                                    eyeHide.classList.remove('hidden');
                                }
                            }
                        </script>
                    </div>

                    <!-- Captcha -->
                    <div>
                        <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.key') }}"></div>
                        @error('g-recaptcha-response')
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

                <script>
                    document.getElementById('login-form').addEventListener('submit', function(event) {
                        var response = grecaptcha.getResponse();
                        if (response.length === 0) {
                            event.preventDefault();
                            // Show custom modal
                            const modal = document.getElementById('recaptcha-modal');
                            const modalContent = document.getElementById('recaptcha-modal-content');
                            
                            modal.classList.remove('hidden');
                            // Small delay to allow display:block to apply before opacity transition
                            setTimeout(() => {
                                modal.querySelector('div').classList.remove('opacity-0');
                                modalContent.classList.remove('scale-95', 'opacity-0');
                                modalContent.classList.add('scale-100', 'opacity-100');
                            }, 10);
                        }
                    });

                    function closeRecaptchaModal() {
                        const modal = document.getElementById('recaptcha-modal');
                        const modalContent = document.getElementById('recaptcha-modal-content');
                        
                        modalContent.classList.remove('scale-100', 'opacity-100');
                        modalContent.classList.add('scale-95', 'opacity-0');
                        modal.querySelector('div').classList.add('opacity-0');
                        
                        setTimeout(() => {
                            modal.classList.add('hidden');
                        }, 300);
                    }
                </script>

                <!-- Custom Aesthetic Modal -->
                <div id="recaptcha-modal" class="fixed inset-0 z-50 flex items-center justify-center hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                    <!-- Background backdrop -->
                    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity opacity-0 duration-300 ease-out" onclick="closeRecaptchaModal()"></div>

                    <!-- Modal panel -->
                    <div id="recaptcha-modal-content" class="relative z-10 w-full max-w-sm transform overflow-hidden rounded-2xl bg-brand-gray border border-brand-teal/30 p-6 text-left shadow-2xl transition-all scale-95 opacity-0 duration-300 ease-out sm:my-8 m-4">
                        <div class="text-center">
                            <!-- Icon -->
                            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-brand-teal/10 mb-4 ring-1 ring-brand-teal/30">
                                <svg class="h-8 w-8 text-brand-teal" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                                </svg>
                            </div>
                            
                            <h3 class="text-xl font-bold leading-6 text-brand-light" id="modal-title">Verifikasi Diperlukan</h3>
                            <div class="mt-2">
                                <p class="text-sm text-brand-light/70">
                                    Mohon selesaikan verifikasi <b>"I'm not a robot"</b> terlebih dahulu untuk melanjutkan masuk.
                                </p>
                            </div>
                            
                            <div class="mt-6">
                                <button type="button" onclick="closeRecaptchaModal()" class="inline-flex w-full justify-center rounded-lg bg-brand-teal px-3 py-2.5 text-sm font-bold text-brand-dark shadow-sm hover:bg-[#5a8e91] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-teal transition-all transform hover:-translate-y-0.5">
                                    Oke, Saya Mengerti
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

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
