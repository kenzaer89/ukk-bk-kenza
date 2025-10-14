@extends('layouts.app')
@section('title', 'Edit Pengguna')

@section('content')
<h1 class="text-2xl font-semibold text-white mb-6">Edit Pengguna</h1>

<form method="POST" action="{{ route('admin.users.update', $user->id) }}" class="space-y-4">
    @csrf @method('PUT')
    <div>
        <label class="block text-gray-300">Nama</label>
        <input type="text" name="name" value="{{ $user->name }}" class="w-full glass p-2 rounded text-white" required>
    </div>
    <div>
        <label class="block text-gray-300">Email</label>
        <input type="email" name="email" value="{{ $user->email }}" class="w-full glass p-2 rounded text-white" required>
    </div>
    <div>
        <label class="block text-gray-300">Role</label>
        <select name="role" class="w-full glass p-2 rounded text-white">
            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="guru_bk" {{ $user->role == 'guru_bk' ? 'selected' : '' }}>Guru BK</option>
            <option value="student" {{ $user->role == 'student' ? 'selected' : '' }}>Siswa</option>
            <option value="parent" {{ $user->role == 'parent' ? 'selected' : '' }}>Orang Tua</option>
            <option value="wali_kelas" {{ $user->role == 'wali_kelas' ? 'selected' : '' }}>Wali Kelas</option>
        </select>
    </div>
    <button type="submit" class="btn-primary">Perbarui</button>
</form>
@endsection
