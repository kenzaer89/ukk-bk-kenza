@extends('layouts.app')

@section('title','Counseling Requests')

@section('content')
<div>
  <div class="flex items-center justify-between mb-4">
    <h2 class="text-lg font-semibold">Counseling Requests</h2>
  </div>

  <div class="bg-white rounded shadow overflow-x-auto">
    <table class="w-full">
      <thead class="text-xs text-gray-500">
        <tr>
          <th class="p-2 text-left">ID</th>
          <th class="p-2 text-left">Student</th>
          <th class="p-2 text-left">Requested At</th>
          <th class="p-2 text-left">Reason</th>
          <th class="p-2 text-left">Status</th>
          <th class="p-2 text-left">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($requests as $r)
        <tr class="border-t">
          <td class="p-2">{{ $r->id }}</td>
          <td class="p-2">{{ $r->student->name ?? '-' }}</td>
          <td class="p-2">{{ \Carbon\Carbon::parse($r->requested_at)->translatedFormat('H:i d F Y') }}</td>
          <td class="p-2">{{ Str::limit($r->reason, 80) }}</td>
          <td class="p-2">{{ $r->status }}</td>
          <td class="p-2">
            <a href="{{ route('counseling.show', $r) }}" class="text-indigo-600 text-sm">View</a>
            @if($r->status == 'pending')
              <form action="{{ route('counseling.approve', $r) }}" method="POST" class="inline">@csrf<button class="ml-2 text-green-600 text-sm">Approve</button></form>
              <form action="{{ route('counseling.reject', $r) }}" method="POST" class="inline">@csrf<button class="ml-2 text-red-600 text-sm">Reject</button></form>
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="mt-4">
    {{ $requests->links() }}
  </div>
</div>
@endsection
