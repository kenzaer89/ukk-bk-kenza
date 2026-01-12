@extends('layouts.app')

@section('title', 'Riwayat Prestasi')

@section('content')
<div class="min-h-screen p-6">
    <!-- Header -->
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-brand-light mb-2">Riwayat Prestasi</h1>
            <p class="text-brand-light/60">Daftar lengkap prestasi yang telah Anda raih</p>
        </div>
        <a href="{{ route('student.dashboard') }}" class="px-4 py-2 bg-brand-gray border border-brand-light/10 rounded-lg text-brand-light hover:bg-brand-light/5 transition-all">
            Kembali ke Dashboard
        </a>
    </div>

    <!-- Statistics Summary -->
    <div class="bg-brand-gray rounded-xl border border-brand-light/10 p-6 mb-8">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-brand-light/60 text-sm uppercase tracking-wider font-semibold mb-1">Total Poin Diperoleh</p>
                <p class="text-3xl font-bold text-green-500">
                    +{{ $achievements->sum('point') }}
                </p>
            </div>
            <div class="text-right">
                <p class="text-brand-light/60 text-sm uppercase tracking-wider font-semibold mb-1">Total Prestasi</p>
                <p class="text-3xl font-bold text-brand-light">
                    {{ $achievements->total() }}
                </p>
            </div>
        </div>
    </div>

    <!-- Achievements List -->
    <div class="bg-brand-gray rounded-xl border border-brand-light/10 overflow-hidden">
        @if($achievements->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-brand-dark/50 border-b border-brand-light/5">
                            <th class="p-4 text-brand-light/60 font-medium">Tanggal</th>
                            <th class="p-4 text-brand-light/60 font-medium">Nama Prestasi</th>
                            <th class="p-4 text-brand-light/60 font-medium">Tingkat</th>
                            <th class="p-4 text-brand-light/60 font-medium">Deskripsi</th>
                            <th class="p-4 text-brand-light/60 font-medium text-right">Poin</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-brand-light/5">
                        @foreach($achievements as $achievement)
                        <tr class="hover:bg-brand-light/5 transition-colors">
                            <td class="p-4 text-brand-light">{{ $achievement->achievement_date ? $achievement->achievement_date->format('d M Y') : '-' }}</td>
                            <td class="p-4">
                                <span class="text-brand-light font-medium block">{{ $achievement->name }}</span>
                            </td>
                            <td class="p-4">
                                <span class="px-3 py-1 rounded-full text-xs font-medium bg-blue-500/20 text-blue-500 capitalize">
                                    {{ $achievement->level }}
                                </span>
                            </td>
                            <td class="p-4 text-brand-light/80">{{ $achievement->description ?? '-' }}</td>
                            <td class="p-4 text-right">
                                <span class="px-2 py-1 rounded text-xs font-bold bg-green-500/20 text-green-500">
                                    +{{ $achievement->point }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-brand-light/5">
                {{ $achievements->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <div class="w-16 h-16 bg-brand-light/5 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-brand-light/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-brand-light mb-2">Belum Ada Prestasi</h3>
                <p class="text-brand-light/60">Teruslah berusaha dan raih prestasimu!</p>
            </div>
        @endif
    </div>
</div>
@endsection
