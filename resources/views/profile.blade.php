@extends('layouts.app')

@section('title','Profile')

@section('content')
<div class="max-w-2xl mx-auto">
  <div class="bg-white p-6 rounded shadow">
    <h2 class="text-lg font-semibold mb-4">Profile</h2>
    <form action="{{ route('profile.update') }}" method="POST">
      @csrf @method('PUT')
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm">Name</label>
          <input name="name" value="{{ old('name', auth()->user()->name) }}" class="mt-1 block w-full border rounded p-2" />
        </div>
        <div>
          <label class="block text-sm">Email</label>
          <input name="email" value="{{ old('email', auth()->user()->email) }}" class="mt-1 block w-full border rounded p-2" />
        </div>
        <div>
          <label class="block text-sm">Phone</label>
          <input name="phone" value="{{ old('phone', auth()->user()->phone) }}" class="mt-1 block w-full border rounded p-2" />
        </div>
        <div>
          <label class="block text-sm">Role</label>
          <input disabled value="{{ auth()->user()->role }}" class="mt-1 block w-full border rounded p-2 bg-gray-50" />
        </div>
      </div>

      <div class="mt-4">
        <button class="px-4 py-2 bg-indigo-600 text-white rounded">Update Profile</button>
      </div>
    </form>
  </div>
</div>
@endsection
