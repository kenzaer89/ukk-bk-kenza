@extends('layouts.app')

@section('title', 'Edit Pengguna: ' . $user->name)

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6 text-white">✏️ Edit Pengguna: {{ $user->name }}</h1>

    <div class="bg-gray-800 rounded-xl shadow-lg p-8 max-w-2xl">
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
            
            {{-- Menggunakan form dinamis --}}
            @include('admin.users._form-fields', ['user' => $user, 'relatedStudentIds' => $relatedStudentIds])

            <div class="flex justify-end space-x-3 pt-8">
                <a href="{{ route('admin.users.index') }}" 
                   class="py-2 px-4 border border-gray-600 rounded-lg text-gray-300 hover:bg-gray-700 transition">Batal</a>
                <button type="submit" 
                        class="py-2 px-4 bg-yellow-600 text-white font-semibold rounded-lg hover:bg-yellow-700 transition duration-300">
                    Perbarui Pengguna
                </button>
            </div>
        </form>
    </div>
</div>
@endsection