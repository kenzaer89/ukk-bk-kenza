<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar - Bimbingan Konseling</title>
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
                <h1 class="text-3xl font-bold text-brand-light mb-2">Buat Akun Baru</h1>
                <p class="text-brand-light/60">Daftar untuk mengakses sistem Bimbingan Konseling</p>
            </div>

            <!-- Register Form -->
            <div class="bg-brand-gray rounded-2xl border border-brand-light/10 p-8 shadow-[0_0_30px_rgba(118,171,174,0.1)]">
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-500/10 border border-red-500/30 rounded-lg">
                        <ul class="text-red-400 text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-brand-light font-medium mb-2">Nama Lengkap</label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            value="{{ old('name') }}" 
                            required 
                            autofocus
                            class="w-full px-4 py-3 bg-brand-dark border border-brand-light/10 rounded-lg text-brand-light placeholder-brand-light/40 focus:outline-none focus:border-brand-teal/50 focus:ring-2 focus:ring-brand-teal/20 transition-all"
                            placeholder="Masukkan nama lengkap"
                        >
                        @error('name')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-brand-light font-medium mb-2">Email</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required
                            class="w-full px-4 py-3 bg-brand-dark border border-brand-light/10 rounded-lg text-brand-light placeholder-brand-light/40 focus:outline-none focus:border-brand-teal/50 focus:ring-2 focus:ring-brand-teal/20 transition-all"
                            placeholder="nama@email.com"
                        >
                        @error('email')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-brand-light font-medium mb-2">Nomor Telepon</label>
                        <input 
                            type="text" 
                            id="phone" 
                            name="phone" 
                            value="{{ old('phone') }}" 
                            required
                            inputmode="numeric"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                            class="w-full px-4 py-3 bg-brand-dark border border-brand-light/10 rounded-lg text-brand-light placeholder-brand-light/40 focus:outline-none focus:border-brand-teal/50 focus:ring-2 focus:ring-brand-teal/20 transition-all"
                            placeholder="Contoh: 081234567890"
                        >
                        <p class="mt-1 text-[10px] text-brand-light/40 italic">Hanya masukkan angka tanpa spasi atau karakter lain.</p>
                        @error('phone')
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
                                placeholder="Minimal 8 karakter"
                            >
                            <button 
                                type="button" 
                                onclick="toggleVisibility('password', 'eye-pass-show', 'eye-pass-hide')"
                                class="absolute inset-y-0 right-0 flex items-center px-4 text-brand-light/60 hover:text-brand-teal focus:outline-none transition-colors"
                            >
                                <svg id="eye-pass-show" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="eye-pass-hide" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Confirmation -->
                    <div>
                        <label for="password_confirmation" class="block text-brand-light font-medium mb-2">Konfirmasi Password</label>
                        <div class="relative">
                            <input 
                                type="password" 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                required
                                class="w-full px-4 py-3 bg-brand-dark border border-brand-light/10 rounded-lg text-brand-light placeholder-brand-light/40 focus:outline-none focus:border-brand-teal/50 focus:ring-2 focus:ring-brand-teal/20 transition-all pr-12"
                                placeholder="Ulangi password"
                            >
                            <button 
                                type="button" 
                                onclick="toggleVisibility('password_confirmation', 'eye-confirm-show', 'eye-confirm-hide')"
                                class="absolute inset-y-0 right-0 flex items-center px-4 text-brand-light/60 hover:text-brand-teal focus:outline-none transition-colors"
                            >
                                <svg id="eye-confirm-show" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="eye-confirm-hide" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <script>
                        function toggleVisibility(inputId, showIconId, hideIconId) {
                            const input = document.getElementById(inputId);
                            const showIcon = document.getElementById(showIconId);
                            const hideIcon = document.getElementById(hideIconId);
                            
                            if (input.type === 'password') {
                                input.type = 'text';
                                showIcon.classList.remove('hidden');
                                hideIcon.classList.add('hidden');
                            } else {
                                input.type = 'password';
                                showIcon.classList.add('hidden');
                                hideIcon.classList.remove('hidden');
                            }
                        }
                    </script>

                    <!-- Role Selection -->
                    <div>
                        <label for="role" class="block text-brand-light font-medium mb-2">Pilih Peran</label>
                        <select 
                            id="role" 
                            name="role" 
                            required
                            class="w-full px-4 py-3 bg-brand-dark border border-brand-light/10 rounded-lg text-brand-light focus:outline-none focus:border-brand-teal/50 focus:ring-2 focus:ring-brand-teal/20 transition-all"
                        >
                            <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Murid</option>
                            <option value="parent" {{ old('role') == 'parent' ? 'selected' : '' }}>Orang Tua</option>
                            <option value="wali_kelas" {{ old('role') == 'wali_kelas' ? 'selected' : '' }}>Wali Kelas</option>
                        </select>
                        @error('role')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>


                    <!-- Student Specific Fields -->
                    <div id="student-fields" class="space-y-5 hidden">
                        <!-- Class Selection -->
                        <div>
                            <label for="class_id" class="block text-brand-light font-medium mb-2">Kelas</label>
                            <select 
                                id="class_id" 
                                name="class_id" 
                                class="w-full px-4 py-3 bg-brand-dark border border-brand-light/10 rounded-lg text-brand-light focus:outline-none focus:border-brand-teal/50 focus:ring-2 focus:ring-brand-teal/20 transition-all"
                            >
                                <option value="">-- Pilih Kelas --</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                        {{ $class->name }} ({{ $class->jurusan }})
                                    </option>
                                @endforeach
                            </select>
                            @error('class_id')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Absen -->
                        <div>
                            <label for="absen" class="block text-brand-light font-medium mb-2">Nomor Absen</label>
                            <input 
                                type="number" 
                                id="absen" 
                                name="absen" 
                                value="{{ old('absen') }}" 
                                min="1"
                                class="w-full px-4 py-3 bg-brand-dark border border-brand-light/10 rounded-lg text-brand-light placeholder-brand-light/40 focus:outline-none focus:border-brand-teal/50 focus:ring-2 focus:ring-brand-teal/20 transition-all"
                                placeholder="Contoh: 1, 15, dst"
                            >
                            @error('absen')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- NISN -->
                        <div>
                            <label for="nisn" class="block text-brand-light font-medium mb-2">NISN</label>
                            <input 
                                type="text" 
                                id="nisn" 
                                name="nisn" 
                                value="{{ old('nisn') }}" 
                                maxlength="10"
                                minlength="10"
                                pattern="\d{10}"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                class="w-full px-4 py-3 bg-brand-dark border border-brand-light/10 rounded-lg text-brand-light placeholder-brand-light/40 focus:outline-none focus:border-brand-teal/50 focus:ring-2 focus:ring-brand-teal/20 transition-all"
                                placeholder="10 digit NISN"
                            >
                            <p class="mt-1 text-[10px] text-brand-light/40 italic">NISN harus terdiri dari tepat 10 digit angka.</p>
                            @error('nisn')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>


                    </div>

                    <!-- Parent Specific Fields -->
                    <div id="parent-fields" class="space-y-5 hidden">


                        <!-- Child Selection -->
                        <div>
                            <label for="student_ids" class="block text-brand-light font-medium mb-2">Pilih Nama Anak (Bisa pilih lebih dari satu)</label>
                            <select 
                                id="student_ids" 
                                name="student_ids[]" 
                                multiple
                                class="w-full px-4 py-3 bg-brand-dark border border-brand-light/10 rounded-lg text-brand-light focus:outline-none focus:border-brand-teal/50 focus:ring-2 focus:ring-brand-teal/20 transition-all min-h-[120px]"
                            >
                                @foreach($students as $student)
                                    @php
                                        $hasParent = $student->children_connections_count > 0;
                                    @endphp
                                    <option value="{{ $student->id }}" 
                                        {{ (is_array(old('student_ids')) && in_array($student->id, old('student_ids'))) ? 'selected' : '' }}
                                        {{ $hasParent ? 'disabled' : '' }}
                                        class="{{ $hasParent ? 'text-white/20' : '' }}"
                                    >
                                        {{ $student->name }} ({{ $student->schoolClass->name ?? 'Tanpa Kelas' }}) 
                                        {{ $hasParent ? '--- [Sudah Ada Orang Tua]' : '' }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="mt-2 text-[10px] text-brand-light/40 italic">Tahan Ctrl (Windows) atau Command (Mac) untuk memilih lebih dari satu anak.</p>
                            @error('student_ids')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Wali Kelas Specific Fields -->
                    <div id="wali-fields" class="space-y-5 hidden">
                        <!-- NIP -->
                        <div>
                            <label for="nip" class="block text-brand-light font-medium mb-2">NIP (Nomor Induk Pegawai) <span class="text-red-500">*</span></label>
                            <input 
                                type="text" 
                                id="nip" 
                                name="nip" 
                                value="{{ old('nip') }}" 
                                maxlength="20"
                                required
                                class="w-full px-4 py-3 bg-brand-dark border border-brand-light/10 rounded-lg text-brand-light placeholder-brand-light/40 focus:outline-none focus:border-brand-teal/50 focus:ring-2 focus:ring-brand-teal/20 transition-all"
                                placeholder="Contoh: 198501012010011001"
                            >
                            @error('nip')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                            <p class="mt-2 text-xs text-brand-light/40 italic font-bold text-yellow-500">Wajib diisi untuk Wali Kelas</p>
                        </div>


                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const roleSelect = document.getElementById('role');
                            const studentFields = document.getElementById('student-fields');
                            const parentFields = document.getElementById('parent-fields');
                            const waliFields = document.getElementById('wali-fields');
                            
                            function toggleFields() {
                                // Reset hidden states and disable inputs
                                studentFields.classList.add('hidden');
                                parentFields.classList.add('hidden');
                                waliFields.classList.add('hidden');
                                
                                const studentInputs = studentFields.querySelectorAll('input, select');
                                const parentInputs = parentFields.querySelectorAll('input, select');
                                const waliInputs = waliFields.querySelectorAll('input, select');

                                studentInputs.forEach(input => input.disabled = true);
                                parentInputs.forEach(input => input.disabled = true);
                                waliInputs.forEach(input => input.disabled = true);

                                if (roleSelect.value === 'student') {
                                    studentFields.classList.remove('hidden');
                                    studentInputs.forEach(input => input.disabled = false);
                                } else if (roleSelect.value === 'parent') {
                                    parentFields.classList.remove('hidden');
                                    parentInputs.forEach(input => input.disabled = false);
                                } else if (roleSelect.value === 'wali_kelas') {
                                    waliFields.classList.remove('hidden');
                                    waliInputs.forEach(input => input.disabled = false);
                                }
                            }

                            roleSelect.addEventListener('change', toggleFields);
                            toggleFields(); // Run on load

                            // --- Logic Check Completion ---
                            const inputs = document.querySelectorAll('input, select');
                            const generalMsg = document.getElementById('general-warning-msg');

                            function checkCompletion() {
                                // Hide all first
                                if (generalMsg) generalMsg.classList.add('hidden');

                                // Common fields
                                const name = document.getElementById('name').value.trim();
                                const email = document.getElementById('email').value.trim();
                                const phone = document.getElementById('phone').value.trim();
                                const pass = document.getElementById('password').value;
                                const confirm = document.getElementById('password_confirmation').value;
                                const role = roleSelect.value;
                                
                                const commonFilled = name && email && phone && pass && confirm && role;

                                if (!commonFilled) return;

                                if (role === 'student') {
                                    const classId = document.getElementById('class_id').value;
                                    const absen = document.getElementById('absen').value.trim();
                                    const nisn = document.getElementById('nisn').value.trim();
                                    if (classId && absen && nisn) {
                                        if (generalMsg) generalMsg.classList.remove('hidden');
                                    }
                                } else if (role === 'parent') {
                                    const students = document.getElementById('student_ids').selectedOptions.length > 0;
                                    if (students) {
                                        if (generalMsg) generalMsg.classList.remove('hidden');
                                    }
                                } else if (role === 'wali_kelas') {
                                    const nip = document.getElementById('nip').value.trim();
                                    if (nip) {
                                        if (generalMsg) generalMsg.classList.remove('hidden');
                                    }
                                }
                            }

                            // Attach listeners to everything
                            inputs.forEach(input => {
                                input.addEventListener('input', checkCompletion);
                                input.addEventListener('change', checkCompletion);
                            });
                        });
                    </script>

                    <div id="general-warning-msg" class="hidden mb-5 p-3 bg-yellow-500/10 border border-yellow-500/30 rounded-lg flex items-start gap-3 animate-fade-in-up">
                        <svg class="w-5 h-5 text-yellow-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <p class="text-sm text-yellow-200/90 leading-tight">
                            Pastikan anda mengisi semua data dengan benar sebelum mendaftar.
                        </p>
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit" 
                        class="w-full px-6 py-3 bg-brand-teal text-brand-dark rounded-lg font-bold text-lg hover:bg-[#5a8e91] transition-all shadow-[0_0_20px_rgba(118,171,174,0.3)] hover:shadow-[0_0_30px_rgba(118,171,174,0.5)] transform hover:-translate-y-0.5"
                    >
                        Daftar Sekarang
                    </button>
                </form>

                <!-- Login Link -->
                <div class="mt-6 text-center text-sm text-brand-light/60">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-brand-teal hover:text-brand-teal/80 font-semibold transition-colors ml-1">
                        Masuk di sini
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
