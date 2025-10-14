@extends('layouts.app')
@section('title', 'Tambah Pengguna')

@section('content')
<h1 class="text-2xl font-semibold text-white mb-6">Tambah Pengguna</h1>

<form method="POST" action="{{ route('admin.users.store') }}" class="space-y-4">
    @csrf
    <div>
        <label class="block text-gray-300">Nama</label>
        <input type="text" name="name" class="w-full glass p-2 rounded text-white" required>
    </div>
    <div>
        <label class="block text-gray-300">Email</label>
        <input type="email" name="email" class="w-full glass p-2 rounded text-white" required>
    </div>
    <div>
        <label class="block text-gray-300">Password</label>
        <input type="password" name="password" class="w-full glass p-2 rounded text-white" required>
    </div>
    <div>
        <label class="block text-gray-300">Role</label>
        <select name="role" class="w-full glass p-2 rounded text-white">
            <option value="admin">Admin</option>
            <option value="guru_bk">Guru BK</option>
            <option value="student">Siswa</option>
            <option value="parent">Orang Tua</option>
            <option value="wali_kelas">Wali Kelas</option>
        </select>
    </div>
    <button type="submit" class="btn-primary">Simpan</button>
</form>
@endsection
