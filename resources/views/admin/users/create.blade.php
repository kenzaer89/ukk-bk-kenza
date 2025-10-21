@extends('layouts.app')

@section('title', 'Tambah Pengguna')

@section('content')
<div class="max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold text-white mb-6">Tambah Pengguna</h1>

    <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-6 glass p-6 rounded-xl">
        @csrf

        {{-- Nama --}}
        <div>
            <label class="block text-gray-300 mb-2">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name') }}"
                class="w-full glass p-3 rounded text-white border border-gray-600 focus:border-indigo-400 focus:ring-indigo-400"
                required>
            @error('name') <small class="text-rose-400">{{ $message }}</small> @enderror
        </div>

        {{-- Email --}}
        <div>
            <label class="block text-gray-300 mb-2">Email</label>
            <input type="email" name="email" value="{{ old('email') }}"
                class="w-full glass p-3 rounded text-white border border-gray-600 focus:border-indigo-400 focus:ring-indigo-400"
                required>
            @error('email') <small class="text-rose-400">{{ $message }}</small> @enderror
        </div>

        {{-- Role --}}
        <div>
            <label class="block text-gray-300 mb-2">Peran (Role)</label>
            <select name="role"
                class="w-full glass p-3 rounded text-white border border-gray-600 focus:border-indigo-400 focus:ring-indigo-400"
                required>
                <option value="">-- Pilih Peran --</option>
                <option value="student">Siswa</option>
                <option value="parent">Orang Tua</option>
                <option value="wali_kelas">Wali Kelas</option>
                <option value="guru_bk">Guru BK</option>
                <option value="admin">Admin</option>
            </select>
            @error('role') <small class="text-rose-400">{{ $message }}</small> @enderror
        </div>

        {{-- Password (opsional) --}}
        <div>
            <label class="block text-gray-300 mb-2">Password (Opsional)</label>
            <input type="text" name="password" placeholder="Biarkan kosong = 'password'"
                class="w-full glass p-3 rounded text-white border border-gray-600 focus:border-indigo-400 focus:ring-indigo-400">
        </div>

        <div class="flex justify-end gap-4">
            <a href="{{ route('admin.users.index') }}"
                class="px-5 py-3 bg-gray-600/30 rounded-lg text-gray-300 hover:bg-gray-500/40 transition">
                Batal
            </a>
            <button type="submit"
                class="px-5 py-3 bg-indigo-600 hover:bg-indigo-700 rounded-lg text-white font-semibold transition">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
