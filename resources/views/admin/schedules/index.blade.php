@extends('layouts.app')

@section('title', 'Daftar Jadwal Konseling')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6 text-white">📅 Daftar Jadwal Konseling</h1>

    <div class="flex justify-between items-center mb-6">
        <a href="{{ route('admin.schedules.create') }}" 
           class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-300">
            + Buat Jadwal Baru
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-500 p-4 rounded-lg mb-6 text-white">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-500 p-4 rounded-lg mb-6 text-white">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-gray-800 rounded-xl shadow-lg p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr class="text-xs font-semibold tracking-wider text-left text-gray-400 uppercase border-b border-gray-700">
                        <th class="px-5 py-3">Tanggal & Waktu</th>
                        <th class="px-5 py-3">Siswa</th>
                        <th class="px-5 py-3">Guru BK</th>
                        <th class="px-5 py-3">Lokasi</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3">Dari Permintaan</th>
                        <th class="px-5 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($schedules as $schedule)
                        <tr class="hover:bg-gray-700 transition duration-150 border-b border-gray-700">
                            <td class="px-5 py-5 text-sm font-medium text-white">
                                {{ \Carbon\Carbon::parse($schedule->scheduled_date)->format('d M Y') }}<br>
                                <span class="text-indigo-400">{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</span>
                            </td>
                            <td class="px-5 py-5 text-sm">{{ $schedule->student->name ?? 'N/A' }}</td>
                            <td class="px-5 py-5 text-sm">{{ $schedule->teacher->name ?? 'N/A' }}</td>
                            <td class="px-5 py-5 text-sm text-gray-300">
                                {{ $schedule->location ?? '-' }}
                            </td>
                            <td class="px-5 py-5 text-sm">
                                @if ($schedule->session)
                                    <span class="text-green-400 font-bold">SELESAI</span>
                                @else
                                    <span class="text-yellow-400 font-bold">TERJADWAL</span>
                                @endif
                            </td>
                            <td class="px-5 py-5 text-sm">
                                @if ($schedule->counselingRequest)
                                    <span class="text-sky-400">#{{ $schedule->counselingRequest->id }}</span>
                                @else
                                    <span class="text-gray-500">Proaktif</span>
                                @endif
                            </td>
                            <td class="px-5 py-5 text-sm space-x-2">
                                <a href="{{ route('admin.schedules.edit', $schedule) }}" 
                                   class="text-yellow-400 hover:text-yellow-300">Edit</a>
                                <form action="{{ route('admin.schedules.destroy', $schedule) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-400 hover:text-red-300"
                                            onclick="return confirm('Batalkan jadwal ini?')">Batal</button>
                                </form>
                                @if (!$schedule->session)
                                    <a href="{{ route('admin.counseling_sessions.create', ['schedule_id' => $schedule->id]) }}" 
                                       class="text-green-400 hover:text-green-300 font-semibold">| Catat Sesi</a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-5 text-center text-gray-400 italic">Belum ada jadwal konseling yang dibuat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $schedules->links() }}
        </div>
    </div>
</div>
@endsection