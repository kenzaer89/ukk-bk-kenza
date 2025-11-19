@extends('layouts.app')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6 text-white">🧑‍💻 Manajemen Pengguna Sistem</h1>

    <div class="flex justify-between items-center mb-6">
        <a href="{{ route('admin.users.create') }}" 
           class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-300">
            + Tambah Pengguna Baru
        </a>
        
        {{-- Filter berdasarkan Role --}}
        <form action="{{ route('admin.users.index') }}" method="GET" class="flex space-x-2">
            <select name="role" onchange="this.form.submit()" class="p-2 bg-gray-700 border border-gray-600 rounded-lg text-white text-sm">
                <option value="">-- Semua Role --</option>
                @foreach ($roles as $role)
                    <option value="{{ $role }}" {{ request('role') == $role ? 'selected' : '' }}>
                        {{ strtoupper(str_replace('_', ' ', $role)) }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>

    @if (session('success'))
        <div class="bg-green-500 p-4 rounded-lg mb-6 text-white">{{ session('success') }}</div>
    @endif

    <div class="bg-gray-800 rounded-xl shadow-lg p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr class="text-xs font-semibold tracking-wider text-left text-gray-400 uppercase border-b border-gray-700">
                        <th class="px-5 py-3">Nama</th>
                        <th class="px-5 py-3">Email</th>
                        <th class="px-5 py-3">Role</th>
                        <th class="px-5 py-3">Detail Tambahan</th>
                        <th class="px-5 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr class="hover:bg-gray-700 transition duration-150 border-b border-gray-700">
                            <td class="px-5 py-5 text-sm font-medium text-white">{{ $user->name }}</td>
                            <td class="px-5 py-5 text-sm text-gray-300">{{ $user->email }}</td>
                            <td class="px-5 py-5 text-sm">
                                <span class="px-3 py-1 text-xs leading-5 font-semibold rounded-full bg-indigo-600 text-white capitalize">
                                    {{ str_replace('_', ' ', $user->role) }}
                                </span>
                            </td>
                            <td class="px-5 py-5 text-sm text-gray-400">
                                @if ($user->role == 'student')
                                    NIS: {{ $user->nis }} | Kelas: {{ $user->studentClass->name ?? 'N/A' }}
                                @elseif (in_array($user->role, ['guru_bk', 'wali_kelas', 'admin']))
                                    NIP: {{ $user->nip ?? 'N/A' }}
                                @elseif ($user->role == 'parent')
                                    Relasi: {{ $user->relationship_to_student }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-5 py-5 text-sm space-x-2">
                                <a href="{{ route('admin.users.edit', $user) }}" 
                                   class="text-yellow-400 hover:text-yellow-300">Edit</a>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-400 hover:text-red-300"
                                            onclick="return confirm('Hapus pengguna ini? Semua relasi akan terputus.')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-5 text-center text-gray-400 italic">Tidak ada pengguna yang terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection