{{-- File ini di-include di create.blade.php dan edit.blade.php --}}

<div class="space-y-6">
    {{-- 1. Field Dasar --}}
    <div>
        <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Nama Lengkap</label>
        <input type="text" name="name" id="name" value="{{ old('name', $user->name ?? '') }}" required
               class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white">
        @error('name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email', $user->email ?? '') }}" required
               class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white">
        @error('email') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
    </div>
    
    <div>
        <label for="role" class="block text-sm font-medium text-gray-300 mb-2">Role Pengguna</label>
        <select name="role" id="role" required onchange="toggleRoleFields(this.value)"
                class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white">
            <option value="">-- Pilih Role --</option>
            @foreach ($allRoles as $role)
                <option value="{{ $role }}" 
                    {{ old('role', $user->role ?? '') == $role ? 'selected' : '' }}>
                    {{ strtoupper(str_replace('_', ' ', $role)) }}
                </option>
            @endforeach
        </select>
        @error('role') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
    </div>
    
    {{-- 2. Password --}}
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label for="password" class="block text-sm font-medium text-gray-300 mb-2">Password @if(isset($user)) (Biarkan kosong jika tidak diubah) @else (Wajib) @endif</label>
            <input type="password" name="password" id="password"
                   class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white">
            @error('password') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-2">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation"
                   class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white">
        </div>
    </div>
    
    {{-- 3. Field Dinamis (Siswa) --}}
    <div id="student-fields" class="space-y-6 hidden border p-4 rounded-lg border-blue-700 bg-blue-900/20">
        <h3 class="text-lg font-bold text-blue-300">Detail Siswa</h3>
        <div>
            <label for="nis" class="block text-sm font-medium text-gray-300 mb-2">NIS (Nomor Induk Siswa)</label>
            <input type="text" name="nis" id="nis" value="{{ old('nis', $user->nis ?? '') }}"
                   class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white">
            @error('nis') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="class_id" class="block text-sm font-medium text-gray-300 mb-2">Kelas</label>
            <select name="class_id" id="class_id"
                    class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white">
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
                   class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white">
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
                   class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white">
            @error('relationship_to_student') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
        </div>
        
        <div>
            <label for="student_ids" class="block text-sm font-medium text-gray-300 mb-2">Siswa yang Diwakili (Pilih satu atau lebih)</label>
            <select name="student_ids[]" id="student_ids" multiple 
                    class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-sm text-white h-40">
                @foreach ($students as $student)
                    <option value="{{ $student->id }}" 
                        {{ (in_array($student->id, old('student_ids', $relatedStudentIds ?? []))) ? 'selected' : '' }}>
                        {{ $student->name }} ({{ $student->nis }}) - {{ $student->studentClass->name ?? 'Tanpa Kelas' }}
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
            toggleRoleFields(roleSelect.value);
        });

        function toggleRoleFields(role) {
            const studentFields = document.getElementById('student-fields');
            const teacherFields = document.getElementById('teacher-fields');
            const parentFields = document.getElementById('parent-fields');

            studentFields.classList.add('hidden');
            teacherFields.classList.add('hidden');
            parentFields.classList.add('hidden');

            if (role === 'student') {
                studentFields.classList.remove('hidden');
            } else if (['guru_bk', 'wali_kelas', 'admin'].includes(role)) {
                teacherFields.classList.remove('hidden');
            } else if (role === 'parent') {
                parentFields.classList.remove('hidden');
            }
        }
    </script>
</div>