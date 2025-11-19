@extends('layouts.app')

@section('title', 'Daftar Permintaan Konseling Saya')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6 text-white">🔔 Permintaan Konseling Saya</h1>

    <div class="flex justify-between items-center mb-6">
        <a href="{{ route('student.counseling_requests.create') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-300">
            + Ajukan Permintaan Baru
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-500 p-4 rounded-lg mb-6 text-white">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="bg-red-500 p-4 rounded-lg mb-6 text-white">{{ session('error') }}</div>
    @endif

    <div class="bg-gray-800 rounded-xl shadow-lg p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr class="text-xs font-semibold tracking-wider text-left text-gray-400 uppercase border-b border-gray-700">
                        <th class="px-5 py-3">Diajukan Pada</th>
                        <th class="px-5 py-3">Alasan Singkat</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3">Jadwal Sesi</th>
                        <th class="px-5 py-3">Konselor</th>
                        <th class="px-5 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($requests as $session)
                        <tr class="hover:bg-gray-700 transition duration-150 border-b border-gray-700">
                            <td class="px-5 py-5 text-sm text-gray-300">{{ $session->created_at->format('d M Y') }}</td>
                            <td class="px-5 py-5 text-sm font-medium text-white max-w-xs truncate">{{ $session->request_reason }}</td>
                            <td class="px-5 py-5 text-sm capitalize">
                                @php
                                    $statusClass = [
                                        'requested' => 'bg-yellow-600',
                                        'scheduled' => 'bg-blue-600',
                                        'completed' => 'bg-green-600',
                                        'cancelled' => 'bg-red-600',
                                    ][$session->status] ?? 'bg-gray-600';
                                @endphp
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }} text-white">
                                    {{ $session->status }}
                                </span>
                            </td>
                            <td class="px-5 py-5 text-sm">
                                @if($session->session_date && $session->status == 'scheduled')
                                    <span class="font-semibold">{{ $session->session_date->format('d M Y') }}</span>, Pukul {{ $session->start_time ? substr($session->start_time, 0, 5) : '-' }}
                                    <span class="text-xs block text-gray-400">Lokasi: {{ $session->location }}</span>
                                @else
                                    <span class="text-gray-500 italic">Belum Dijadwalkan</span>
                                @endif
                            </td>
                            <td class="px-5 py-5 text-sm text-sky-400">{{ $session->counselor->name ?? 'Menunggu Penugasan' }}</td>
                            <td class="px-5 py-5 text-sm">
                                @if ($session->status === 'requested')
                                    <form action="{{ route('student.counseling_requests.cancel', $session) }}" method="POST">
                                        @csrf
                                        <button type="submit" 
                                                class="text-red-400 hover:text-red-300"
                                                onclick="return confirm('Anda yakin ingin membatalkan permintaan ini?')">Batalkan</button>
                                    </form>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-5 text-center text-gray-400 italic">Anda belum pernah mengajukan permintaan konseling.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $requests->links() }}
        </div>
    </div>
</div>
@endsection