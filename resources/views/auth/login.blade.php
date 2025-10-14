@extends('layouts.app')

@section('title', 'Login - Sistem BK')

@section('content')
<div class="flex flex-col items-center justify-center min-h-[80vh]">
    <div class="glass p-8 rounded-2xl w-full max-w-md text-center">
        <h2 class="text-3xl font-bold text-white mb-2">Selamat Datang 👋</h2>
        <p class="text-gray-400 mb-8">Masuk ke sistem bimbingan konseling</p>

        <form method="POST" action="{{ route('login') }}" class="space-y-4 text-left">
            @csrf
            <div>
                <label class="block text-gray-300 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full glass p-3 rounded text-white" required>
                @error('email') <small class="text-rose-400">{{ $message }}</small> @enderror
            </div>

            <div>
                <label class="block text-gray-300 mb-1">Password</label>
                <input type="password" name="password" class="w-full glass p-3 rounded text-white" required>
                @error('password') <small class="text-rose-400">{{ $message }}</small> @enderror
            </div>

            <div class="flex justify-between items-center text-sm text-gray-400">
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="remember" class="accent-indigo-500">
                    Ingat saya
                </label>
                <a href="#" class="text-indigo-400 hover:underline">Lupa password?</a>
            </div>

            <button type="submit" class="btn-primary w-full py-3">Masuk</button>
        </form>

        <p class="text-gray-400 text-sm mt-6">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-indigo-400 hover:underline">Daftar sekarang</a>
        </p>
    </div>
</div>
@endsection
