@extends('layouts.app')
@section('title', 'Kelola Pengguna')

@section('content')
<h1 class="text-2xl font-semibold text-white mb-6">👥 Daftar Pengguna</h1>

<div class="mb-4">
    <a href="{{ route('admin.users.create') }}" class="btn-primary">+ Tambah Pengguna</a>
</div>

<div class="overflow-x-auto">
    <table class="w-full text-left text-gray-300 border-collapse">
        <thead>
            <tr class="text-gray-400 uppercase text-sm border-b border-gray-700">
                <th class="py-3">Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr class="border-b border-gray-800 hover:bg-white/5">
                <td class="py-2">{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td><span class="text-indigo-400">{{ $user->role }}</span></td>
                <td class="space-x-2">
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn-primary text-sm">Edit</a>
                    <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" class="inline">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Hapus pengguna ini?')" class="text-sm bg-rose-600 py-1 px-3 rounded-lg hover:opacity-90">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
