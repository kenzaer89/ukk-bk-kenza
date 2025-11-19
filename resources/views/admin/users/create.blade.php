@extends('layouts.app')

@section('title', 'Tambah Pengguna Baru')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6 text-white">➕ Tambah Pengguna Baru</h1>

    <div class="bg-gray-800 rounded-xl shadow-lg p-8 max-w-2xl">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            
            @include('admin.users._form-fields', ['user' => null, 'relatedStudentIds' => []])

            <div class="flex justify-end space-x-3 pt-8">
                <a href="{{ route('admin.users.index') }}" 
                   class="py-2 px-4 border border-gray-600 rounded-lg text-gray-300 hover:bg-gray-700 transition">Batal</a>
                <button type="submit" 
                        class="py-2 px-4 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition duration-300">
                    Simpan Pengguna
                </button>
            </div>
        </form>
    </div>
</div>
@endsection