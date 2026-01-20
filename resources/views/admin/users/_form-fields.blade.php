{{-- File ini di-include di create.blade.php dan edit.blade.php --}}

<div class="space-y-6">
    {{-- 1. Field Dasar --}}
    <div>
        <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Nama Lengkap</label>
        <input type="text" name="name" id="name" value="{{ old('name', $user->name ?? '') }}" required
               class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white focus:outline-none focus:border-brand-teal">
        @error('name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email', $user->email ?? '') }}" required
               class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white focus:outline-none focus:border-brand-teal">
        @error('email') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="phone" class="block text-sm font-medium text-gray-300 mb-2">Nomor Telepon</label>
        <input type="tel" name="phone" id="phone" value="{{ old('phone', $user->phone ?? '') }}"
               placeholder="Contoh: 081234567890"
               pattern="[0-9]*"
               oninput="this.value = this.value.replace(/[^0-9]/g, '');"
               class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white focus:outline-none focus:border-brand-teal">
        @error('phone') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
    </div>
    
    <div>
        <label for="role" class="block text-sm font-medium text-gray-300 mb-2">Role Pengguna</label>
        <select name="role" id="role" required onchange="toggleRoleFields(this.value)"
                class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white focus:outline-none focus:border-brand-teal">
            <option value="">-- Pilih Role --</option>
            @foreach ($allRoles as $role)
                @php
                    $displayNames = [
                        'guru_bk' => 'GURU BK',
                        'wali_kelas' => 'WALI KELAS',
                        'student' => 'MURID',
                        'parent' => 'ORANG TUA'
                    ];
                @endphp
                <option value="{{ $role }}" 
                    {{ old('role', $user->role ?? '') == $role ? 'selected' : '' }}>
                    {{ $displayNames[$role] ?? strtoupper(str_replace('_', ' ', $role)) }}
                </option>
            @endforeach
        </select>
        @error('role') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
    </div>
    
    {{-- 2. Password --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label for="password" class="block text-sm font-medium text-gray-300 mb-2">Password @if(isset($user)) (Kosongkan jika tetap) @else (Wajib) @endif</label>
            <div class="relative">
                <input type="password" name="password" id="password"
                       class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white focus:outline-none focus:border-brand-teal pr-10">
                <button type="button" onclick="togglePassword('password', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>
            @error('password') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-2">Konfirmasi Password</label>
            <div class="relative">
                <input type="password" name="password_confirmation" id="password_confirmation"
                       class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white focus:outline-none focus:border-brand-teal pr-10">
                <button type="button" onclick="togglePassword('password_confirmation', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    
    {{-- 3. Field Dinamis (Siswa) --}}
    <div id="student-fields" class="space-y-6 hidden border p-4 rounded-lg border-blue-700 bg-blue-900/20">
        <h3 class="text-lg font-bold text-blue-300">Detail Murid</h3>
        <div>
            <label for="absen" class="block text-sm font-medium text-gray-300 mb-2">Nomor Absen</label>
            <input type="number" name="absen" id="absen" value="{{ old('absen', $user->absen ?? '') }}"
                   class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white focus:outline-none focus:border-brand-teal">
            @error('absen') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="nisn" class="block text-sm font-medium text-gray-300 mb-2">NISN</label>
            <input type="text" name="nisn" id="nisn" value="{{ old('nisn', $user->nisn ?? '') }}"
                   maxlength="10"
                   minlength="10"
                   pattern="\d{10}"
                   oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                   placeholder="10 digit nomor NISN"
                   class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white focus:outline-none focus:border-brand-teal">
            <p class="mt-1 text-[10px] text-gray-500 italic">NISN harus terdiri dari tepat 10 digit angka.</p>
            @error('nisn') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="class_id" class="block text-sm font-medium text-gray-300 mb-2">Kelas</label>
            <select name="class_id" id="class_id"
                    class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white focus:outline-none focus:border-brand-teal">
                <option value="">-- Pilih Kelas --</option>
                @foreach ($classes as $class)
                    <option value="{{ $class->id }}" 
                        {{ old('class_id', $user->class_id ?? '') == $class->id ? 'selected' : '' }}>
                        {{ $class->name }}
                    </option>
                @endforeach
            </select>
            @error('class_id') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
        </div>
    </div>
    
    {{-- 4. Field Dinamis (Guru/Admin/Wali Kelas) --}}
    <div id="teacher-fields" class="space-y-6 hidden border p-4 rounded-lg border-yellow-700 bg-yellow-900/20">
        <h3 class="text-lg font-bold text-yellow-300">Detail Staff/Guru</h3>
        <div>
            <label for="nip" class="block text-sm font-medium text-gray-300 mb-2">NIP (Nomor Induk Pegawai)</label>
            <input type="text" name="nip" id="nip" value="{{ old('nip', $user->nip ?? '') }}"
                   class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white focus:outline-none focus:border-brand-teal">
            @error('nip') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
        </div>



    </div>

    {{-- 5. Field Dinamis (Orang Tua) --}}
    <div id="parent-fields" class="space-y-6 hidden border p-4 rounded-lg border-green-700 bg-green-900/20">
        <h3 class="text-lg font-bold text-green-300">Detail Orang Tua</h3>

        <div>
            <label for="relationship_to_student" class="block text-sm font-medium text-gray-300 mb-2">Hubungan dengan Siswa</label>
            <input type="text" name="relationship_to_student" id="relationship_to_student" 
                   value="{{ old('relationship_to_student', $user->relationship_to_student ?? '') }}"
                   placeholder="Contoh: Ayah Kandung, Ibu Tiri"
                   class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white focus:outline-none focus:border-brand-teal">
            @error('relationship_to_student') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
        </div>
        
        <div>
            <label for="student_ids" class="block text-sm font-medium text-gray-300 mb-2">Siswa yang Diwakili (Pilih satu atau lebih)</label>
            <select name="student_ids[]" id="student_ids" multiple 
                    class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white h-40 focus:outline-none focus:border-brand-teal">
                @foreach ($students as $student)
                    <option value="{{ $student->id }}" 
                        {{ (in_array($student->id, old('student_ids', $relatedStudentIds ?? []))) ? 'selected' : '' }}>
                        {{ $student->name }} ({{ $student->absen ?? '?' }}) - {{ $student->schoolClass->name ?? 'Tanpa Kelas' }}
                    </option>
                @endforeach
            </select>
            @error('student_ids') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
        </div>
    </div>
    
    
    {{-- JavaScript untuk Logika Dinamis --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roleSelect = document.getElementById('role');
            const form = roleSelect.closest('form');
            
            toggleRoleFields(roleSelect.value);
            
            // Ensure all inputs are enabled before form submission
            if (form) {
                form.addEventListener('submit', function(e) {
                    // Remove disabled from all inputs before submit
                    const allInputs = form.querySelectorAll('input, select, textarea');
                    allInputs.forEach(input => {
                        input.disabled = false;
                    });
                });
            }
        });

        function toggleRoleFields(role) {
            const studentFields = document.getElementById('student-fields');
            const teacherFields = document.getElementById('teacher-fields');
            const parentFields = document.getElementById('parent-fields');

            // Set sections hidden by default and disable ALL their internal inputs
            [studentFields, teacherFields, parentFields].forEach(section => {
                section.classList.add('hidden');
                section.querySelectorAll('input, select, textarea').forEach(input => {
                    input.disabled = true;
                });
            });



            // Show relevant section and ENABLE its inputs
            if (role === 'student') {
                studentFields.classList.remove('hidden');
                studentFields.querySelectorAll('input, select, textarea').forEach(input => input.disabled = false);
            } else if (role === 'wali_kelas' || role === 'guru_bk') {
                teacherFields.classList.remove('hidden');
                teacherFields.querySelectorAll('input, select, textarea').forEach(input => input.disabled = false);
                

            } else if (role === 'parent') {
                parentFields.classList.remove('hidden');
                parentFields.querySelectorAll('input, select, textarea').forEach(input => input.disabled = false);
            }
        }

        function togglePassword(inputId, button) {
            const input = document.getElementById(inputId);
            const icon = button.querySelector('svg');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />';
            } else {
                input.type = 'password';
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
            }
        }
    </script>
</div>