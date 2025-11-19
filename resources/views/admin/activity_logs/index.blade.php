@extends('layouts.app')

@section('title', 'Log Aktivitas Sistem')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6 text-white">🗂️ Log Aktivitas Sistem</h1>
    <p class="text-gray-400 mb-8">Riwayat setiap perubahan penting yang dilakukan oleh Admin atau Guru BK.</p>

    <div class="bg-gray-800 rounded-xl shadow-lg p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr class="text-xs font-semibold tracking-wider text-left text-gray-400 uppercase border-b border-gray-700">
                        <th class="px-5 py-3">Waktu</th>
                        <th class="px-5 py-3">Pengguna</th>
                        <th class="px-5 py-3">Aksi</th>
                        <th class="px-5 py-3">Tipe Data</th>
                        <th class="px-5 py-3">ID Data</th>
                        <th class="px-5 py-3">IP Address</th>
                        <th class="px-5 py-3">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logs as $log)
                        <tr class="hover:bg-gray-700 transition duration-150 border-b border-gray-700">
                            <td class="px-5 py-5 text-sm text-gray-300">{{ $log->created_at->format('d M Y H:i:s') }}</td>
                            <td class="px-5 py-5 text-sm font-medium text-white">{{ $log->user->name ?? 'User Terhapus' }}</td>
                            <td class="px-5 py-5 text-sm capitalize">
                                @php
                                    $actionClass = [
                                        'created' => 'text-green-400',
                                        'updated' => 'text-blue-400',
                                        'deleted' => 'text-red-400',
                                    ][$log->action] ?? 'text-gray-400';
                                @endphp
                                <span class="{{ $actionClass }} font-semibold">{{ $log->action }}</span>
                            </td>
                            <td class="px-5 py-5 text-sm text-yellow-400">{{ $log->log_type }}</td>
                            <td class="px-5 py-5 text-sm text-gray-400">{{ $log->loggable_id }}</td>
                            <td class="px-5 py-5 text-sm text-gray-500">{{ $log->ip_address }}</td>
                            <td class="px-5 py-5 text-sm">
                                <a href="{{ route('admin.activity_logs.show', $log) }}" 
                                   class="text-blue-400 hover:text-blue-300">Lihat</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-5 text-center text-gray-400 italic">Belum ada aktivitas yang tercatat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $logs->links() }}
        </div>
    </div>
</div>
@endsection