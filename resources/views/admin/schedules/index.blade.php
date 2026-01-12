@extends('layouts.app')

@section('title', 'Daftar Jadwal Konseling')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6 text-white">📅 Daftar Jadwal Konseling</h1>

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <a href="{{ route('admin.schedules.create') }}" 
           class="bg-brand-teal hover:bg-brand-teal/80 text-brand-dark font-bold py-2.5 px-6 rounded-lg transition duration-300 shadow-[0_0_20px_rgba(118,171,174,0.3)]">
            + Buat Jadwal Baru
        </a>

        <!-- Filter Tabs -->
        <div class="flex gap-2 flex-wrap">
            <a href="{{ route('admin.schedules.index') }}" 
               class="px-4 py-2 rounded-lg text-sm font-medium transition-all {{ !request('status') ? 'bg-brand-teal text-brand-dark' : 'bg-brand-gray text-brand-light/60 hover:bg-brand-gray/80 border border-brand-light/10' }}">
                Semua ({{ $counts['all'] }})
            </a>
            <a href="{{ route('admin.schedules.index', ['status' => 'scheduled']) }}" 
               class="px-4 py-2 rounded-lg text-sm font-medium transition-all {{ request('status') == 'scheduled' ? 'bg-yellow-500 text-white' : 'bg-brand-gray text-brand-light/60 hover:bg-brand-gray/80 border border-brand-light/10' }}">
                Terjadwal ({{ $counts['scheduled'] }})
            </a>
            <a href="{{ route('admin.schedules.index', ['status' => 'completed']) }}" 
               class="px-4 py-2 rounded-lg text-sm font-medium transition-all {{ request('status') == 'completed' ? 'bg-green-500 text-white' : 'bg-brand-gray text-brand-light/60 hover:bg-brand-gray/80 border border-brand-light/10' }}">
                Selesai ({{ $counts['completed'] }})
            </a>
            <a href="{{ route('admin.schedules.index', ['status' => 'cancelled']) }}" 
               class="px-4 py-2 rounded-lg text-sm font-medium transition-all {{ request('status') == 'cancelled' ? 'bg-red-500 text-white' : 'bg-brand-gray text-brand-light/60 hover:bg-brand-gray/80 border border-brand-light/10' }}">
                Dibatalkan ({{ $counts['cancelled'] }})
            </a>
        </div>
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
                        <th class="px-5 py-3">Topik</th>
                        <th class="px-5 py-3">Guru BK</th>
                        <th class="px-5 py-3">Lokasi</th>
                        <th class="px-5 py-3">Jenis Sesi</th>
                        <th class="px-5 py-3">Status</th>
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
                            <td class="px-5 py-5 text-sm">
                                <span class="px-2 py-1 bg-indigo-900/50 text-indigo-200 text-xs rounded">
                                    @if($schedule->topic)
                                        {{ $schedule->topic->name }}
                                    @elseif($schedule->counselingRequest && str_starts_with($schedule->counselingRequest->reason, '[Topik:'))
                                        @php
                                            preg_match('/^\[Topik:\s*(.*?)\]/s', $schedule->counselingRequest->reason, $matches);
                                            echo $matches[1] ?? 'Custom';
                                        @endphp
                                    @else
                                        -
                                    @endif
                                </span>
                            </td>
                            <td class="px-5 py-5 text-sm">{{ $schedule->teacher->name ?? 'N/A' }}</td>
                            <td class="px-5 py-5 text-sm text-gray-300">
                                {{ $schedule->location ?? '-' }}
                            </td>
                            <td class="px-5 py-5 text-sm">
                                @if($schedule->session)
                                    <span class="px-2 py-0.5 bg-gray-700 text-gray-300 text-[10px] rounded uppercase font-bold">
                                        {{ $schedule->session->session_type }}
                                    </span>
                                @else
                                    <span class="text-gray-500">-</span>
                                @endif
                            </td>
                            <td class="px-5 py-5 text-sm">
                                @if ($schedule->status == 'completed')
                                    <span class="px-3 py-1 inline-flex text-[10px] leading-5 font-bold rounded-full bg-green-500/20 text-green-500 uppercase tracking-wider">
                                        Selesai
                                    </span>
                                @elseif ($schedule->status == 'cancelled')
                                    <span class="px-3 py-1 inline-flex text-[10px] leading-5 font-bold rounded-full bg-red-500/20 text-red-500 uppercase tracking-wider">
                                        Dibatalkan
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-[10px] leading-5 font-bold rounded-full bg-yellow-500/20 text-yellow-500 uppercase tracking-wider">
                                        Terjadwal
                                    </span>
                                @endif
                            </td>

                            <td class="px-5 py-5 text-sm">
                                <div class="flex flex-wrap gap-2">
                                    @if ($schedule->status == 'cancelled')
                                        <form action="{{ route('admin.schedules.destroy', $schedule) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="inline-flex items-center px-3 py-1 bg-red-600/10 text-red-500 border border-red-600/30 rounded-md hover:bg-red-600 hover:text-white transition text-xs font-bold"
                                                    onclick="return confirm('Hapus permanen data ini?')">
                                                <span>Hapus</span>
                                            </button>
                                        </form>
                                    @else
                                        @if ($schedule->status !== 'completed')
                                            {{-- Batal action removed --}}
                                        @endif

                                        @if (!$schedule->session)
                                            <a href="{{ route('admin.counseling_sessions.create', ['schedule_id' => $schedule->id]) }}" 
                                               class="inline-flex items-center px-3 py-1 bg-green-600/20 text-green-400 border border-green-500/50 rounded-md hover:bg-green-600 hover:text-white transition text-xs font-bold whitespace-nowrap">
                                                Catat Sesi
                                            </a>
                                        @elseif($schedule->session)

                                            @if($schedule->status == 'completed')
                                                <form action="{{ route('admin.schedules.destroy', $schedule) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="inline-flex items-center px-3 py-1 bg-red-600/10 text-red-500 border border-red-600/30 rounded-md hover:bg-red-600 hover:text-white transition text-xs font-bold"
                                                            onclick="return confirm('Hapus permanen data ini?')">
                                                        <span>Hapus</span>
                                                    </button>
                                                </form>
                                            @endif
                                        @endif
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-5 py-5 text-center text-gray-400 italic">Belum ada jadwal atau sesi konseling yang tersedia.</td>
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