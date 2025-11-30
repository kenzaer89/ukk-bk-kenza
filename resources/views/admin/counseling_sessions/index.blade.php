@extends('layouts.app')

@section('title', 'Daftar Sesi Konseling')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6 text-white">💬 Daftar Sesi Konseling</h1>

    @if (session('success'))
        <div class="bg-green-500 p-4 rounded-lg mb-6 text-white">{{ session('success') }}</div>
    @endif

    <div class="bg-gray-800 rounded-xl shadow-lg p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr class="text-xs font-semibold tracking-wider text-left text-gray-400 uppercase border-b border-gray-700">
                        <th class="px-5 py-3">Siswa</th>
                        <th class="px-5 py-3">Jenis Sesi</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3">Jadwal</th>
                        <th class="px-5 py-3">Konselor</th>
                        <th class="px-5 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sessions as $session)
                        <tr class="hover:bg-gray-700 transition duration-150 border-b border-gray-700">
                            <td class="px-5 py-5 text-sm font-medium text-white">
                                {{ $session->student->name ?? 'Siswa Terhapus' }}
                                <span class="text-xs text-gray-400 block">{{ $session->student->schoolClass->name ?? '-' }}</span>
                            </td>
                            <td class="px-5 py-5 text-sm capitalize">{{ $session->session_type }}</td>
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
                                @if($session->session_date)
                                    <span class="font-semibold">{{ $session->session_date->format('d M Y') }}</span>
                                    <span class="text-xs block text-gray-400">Pukul: {{ $session->start_time ? substr($session->start_time, 0, 5) : '-' }}</span>
                                @else
                                    <span class="text-yellow-400 italic font-semibold">Menunggu Jadwal</span>
                                @endif
                            </td>
                            <td class="px-5 py-5 text-sm text-sky-400">{{ $session->counselor->name ?? 'Belum Ditugaskan' }}</td>
                            <td class="px-5 py-5 text-sm space-x-2">
                                <a href="{{ route('admin.counseling_sessions.edit', $session) }}" 
                                   class="text-blue-400 hover:text-blue-300">Tangani / Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-5 text-center text-gray-400 italic">Belum ada sesi konseling yang dicatat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $sessions->links() }}
        </div>
    </div>
</div>
@endsection