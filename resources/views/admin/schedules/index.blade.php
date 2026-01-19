@extends('layouts.app')

@section('title', 'Daftar Jadwal Konseling')

@section('content')
<div class="p-6">
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-white flex items-center gap-3">
                <span class="p-2 bg-indigo-500/20 rounded-lg">
                    <svg class="w-8 h-8 text-brand-teal" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </span>
                Daftar Jadwal Konseling
            </h1>
            <p class="text-gray-400 mt-1">Kelola jadwal konseling mandiri</p>
        </div>

        <div class="flex flex-col sm:flex-row items-center gap-4">
            <form action="{{ route('admin.schedules.index') }}" method="GET" class="relative group w-full sm:w-64">
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                <input type="text" name="search" value="{{ request('search') }}" 
                    placeholder="Cari jadwal..." 
                    class="w-full bg-gray-900/50 border border-gray-700/50 text-white text-sm rounded-xl px-4 py-3 pl-10 focus:ring-2 focus:ring-brand-teal focus:border-transparent transition-all duration-200 outline-none group-hover:bg-gray-800/80">
                <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 group-hover:text-brand-teal transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </form>

            <a href="{{ route('admin.schedules.create') }}" 
               class="w-full sm:w-auto bg-brand-teal hover:bg-brand-teal/80 text-brand-dark font-bold py-2.5 px-6 rounded-lg transition duration-300 shadow-[0_0_20px_rgba(118,171,174,0.3)] flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Buat Jadwal Baru
            </a>
        </div>
    </div>

    <div class="mb-6 flex gap-2 flex-wrap">
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
                                @php
                                    $topicName = '-';
                                    if($schedule->topic) {
                                        $topicName = $schedule->topic->name;
                                    } elseif($schedule->counselingRequest && str_starts_with($schedule->counselingRequest->reason, '[Topik:')) {
                                        preg_match('/^\[Topik:\s*(.*?)\]/s', $schedule->counselingRequest->reason, $matches);
                                        $topicName = $matches[1] ?? 'Custom';
                                    }
                                @endphp
                                <span class="px-2 py-1 bg-indigo-900/50 text-indigo-200 text-xs rounded" title="{{ $topicName }}">
                                    {{ Str::limit($topicName, 25) }}
                                </span>
                            </td>
                            <td class="px-5 py-5 text-sm">{{ $schedule->teacher_name ?? ($schedule->teacher->name ?? 'N/A') }}</td>
                            <td class="px-5 py-5 text-sm text-gray-300">
                                {{ $schedule->location ?? '-' }}
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
                                                    onclick="return confirmAction(event, 'Hapus Jadwal', 'Apakah Anda yakin ingin menghapus data ini secara permanen?', 'warning', 'Ya, Hapus')">
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
                                            <a href="{{ route('admin.counseling_sessions.show', $schedule->session) }}" 
                                               class="inline-flex items-center px-3 py-1 bg-brand-teal/20 text-brand-teal border border-brand-teal/50 rounded-md hover:bg-brand-teal hover:text-brand-dark transition text-xs font-bold whitespace-nowrap">
                                                Detail
                                            </a>

                                            @if($schedule->status == 'completed')
                                                <form action="{{ route('admin.schedules.destroy', $schedule) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="inline-flex items-center px-3 py-1 bg-red-600/10 text-red-500 border border-red-600/30 rounded-md hover:bg-red-600 hover:text-white transition text-xs font-bold"
                                                            onclick="return confirmAction(event, 'Hapus Jadwal', 'Apakah Anda yakin ingin menghapus data ini secara permanen?', 'warning', 'Ya, Hapus')">
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
                            <td colspan="7" class="px-5 py-20 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <svg class="w-16 h-16 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    @if(request('search'))
                                        <p class="text-gray-500 text-lg italic">Tidak ada jadwal yang cocok dengan kata kunci "{{ request('search') }}".</p>
                                        <a href="{{ route('admin.schedules.index', ['status' => request('status')]) }}" class="text-brand-teal hover:underline font-semibold mt-2">Hapus pencarian</a>
                                    @else
                                        <p class="text-gray-500 text-lg italic">Belum ada jadwal atau sesi konseling yang tersedia.</p>
                                    @endif
                                </div>
                            </td>
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