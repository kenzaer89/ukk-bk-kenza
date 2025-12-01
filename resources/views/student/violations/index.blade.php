@extends('layouts.app')

@section('title', 'Riwayat Pelanggaran')

@section('content')
<div class="min-h-screen bg-brand-dark p-6">
    <!-- Header -->
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-brand-light mb-2">Riwayat Pelanggaran</h1>
            <p class="text-brand-light/60">Daftar lengkap pelanggaran yang pernah tercatat</p>
        </div>
        <a href="{{ route('student.dashboard') }}" class="px-4 py-2 bg-brand-gray border border-brand-light/10 rounded-lg text-brand-light hover:bg-brand-light/5 transition-all">
            Kembali ke Dashboard
        </a>
    </div>

    <!-- Statistics Summary -->
    <div class="bg-brand-gray rounded-xl border border-brand-light/10 p-6 mb-8">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-brand-light/60 text-sm uppercase tracking-wider font-semibold mb-1">Total Poin Dikurangi</p>
                <p class="text-3xl font-bold text-red-500">
                    {{ $violations->sum(function($v) { return $v->rule->points; }) }}
                </p>
            </div>
            <div class="text-right">
                <p class="text-brand-light/60 text-sm uppercase tracking-wider font-semibold mb-1">Sisa Poin Saat Ini</p>
                <p class="text-3xl font-bold 
                    @if(Auth::user()->points <= 50) text-red-500 
                    @elseif(Auth::user()->points <= 70) text-yellow-500 
                    @else text-green-500 
                    @endif">
                    {{ Auth::user()->points }}
                </p>
            </div>
        </div>
    </div>

    <!-- Violations List -->
    <div class="bg-brand-gray rounded-xl border border-brand-light/10 overflow-hidden">
        @if($violations->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-brand-dark/50 border-b border-brand-light/5">
                            <th class="p-4 text-brand-light/60 font-medium">Tanggal</th>
                            <th class="p-4 text-brand-light/60 font-medium">Jenis Pelanggaran</th>
                            <th class="p-4 text-brand-light/60 font-medium">Keterangan</th>
                            <th class="p-4 text-brand-light/60 font-medium text-right">Poin</th>
                            <th class="p-4 text-brand-light/60 font-medium">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-brand-light/5">
                        @foreach($violations as $violation)
                        <tr class="hover:bg-brand-light/5 transition-colors">
                            <td class="p-4 text-brand-light">{{ $violation->violation_date->format('d M Y') }}</td>
                            <td class="p-4">
                                <span class="text-brand-light font-medium block">{{ $violation->rule->name }}</span>
                                <span class="text-brand-light/40 text-sm">{{ $violation->rule->category ?? 'Umum' }}</span>
                            </td>
                            <td class="p-4 text-brand-light/80">{{ $violation->description ?? '-' }}</td>
                            <td class="p-4 text-right">
                                <span class="px-2 py-1 rounded text-xs font-bold bg-red-500/20 text-red-500">
                                    {{ $violation->rule->points }}
                                </span>
                            </td>
                            <td class="p-4">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-500/20 text-yellow-500',
                                        'resolved' => 'bg-green-500/20 text-green-500',
                                        'escalated' => 'bg-purple-500/20 text-purple-500',
                                    ];
                                    $statusLabel = [
                                        'pending' => 'Menunggu',
                                        'resolved' => 'Selesai',
                                        'escalated' => 'Diteruskan',
                                    ];
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $statusColors[$violation->status] ?? 'bg-gray-500/20 text-gray-500' }}">
                                    {{ $statusLabel[$violation->status] ?? ucfirst($violation->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-brand-light/5">
                {{ $violations->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <div class="w-16 h-16 bg-brand-light/5 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-brand-light/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-brand-light mb-2">Tidak Ada Pelanggaran</h3>
                <p class="text-brand-light/60">Anda belum memiliki catatan pelanggaran. Pertahankan!</p>
            </div>
        @endif
    </div>
</div>
@endsection
