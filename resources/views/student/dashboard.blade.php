@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold text-white mb-4">Halo, {{ $user->name }}</h1>
    <p class="text-gray-300">Selamat datang di dashboard siswa 👋</p>
</div>
@endsection
