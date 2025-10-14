@extends('layouts.app')

@section('title', 'Daftar - Sistem BK')

@section('content')
<div class="flex flex-col items-center justify-center min-h-[80vh]">
    <div class="glass p-8 rounded-2xl w-full max-w-md text-center">
        <h2 class="text-3xl font-bold text-white mb-2">Buat Akun Baru ✨</h2>
        <p class="text-gray-400 mb-8">Daftar untuk mengakses sistem bimbingan konseling</p>

        <form method="POST" action="{{ route('register') }}" class="space-y-4 text-left">
            @csrf
            <div>
                <label class="block text-gray-300 mb-1">Nama Lengkap</label>
                <input type="text" name="name" class="w-full glass p-3 rounded text-white" required>
            </div>
            <div>
                <label class="block text-gray-300 mb-1">Email</label>
                <input type="email" name="email" class="w-full glass p-3 rounded text-white" required>
            </div>
            <div>
                <label class="block text-gray-300 mb-1">Password</label>
                <input type="password" name="password" class="w-full glass p-3 rounded text-white" required>
            </div>
            <div>
                <label class="block text-gray-300 mb-1">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="w-full glass p-3 rounded text-white" required>
            </div>
            <div>
                <label class="block text-gray-300 mb-1">Pilih Peran</label>
                <select name="role" class="w-full glass p-3 rounded text-white">
                    <option value="student">Siswa</option>
                    <option value="parent">Orang Tua</option>
                    <option value="wali_kelas">Wali Kelas</option>
                </select>
            </div>

            <button type="submit" class="btn-primary w-full py-3">Daftar</button>
        </form>

        <p class="text-gray-400 text-sm mt-6">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-indigo-400 hover:underline">Masuk di sini</a>
        </p>
    </div>
</div>
@endsection
