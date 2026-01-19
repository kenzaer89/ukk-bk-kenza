@extends('layouts.app')

@section('title', 'Pilih Anak')

@section('content')
<div class="p-6 min-h-[80vh] flex flex-col items-center justify-center">
    <div class="mb-12 text-center">
        <h1 class="text-4xl font-black text-white mb-4 tracking-tight">
            Pilih <span class="text-brand-teal">Anak Anda</span>
        </h1>
        <p class="text-brand-light/60 text-lg">Silakan pilih data anak yang ingin Anda pantau hari ini.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 w-full max-w-6xl">
        @foreach($childrenConnections as $child)
        <a href="{{ route('parent.select_child', $child->student_id) }}" 
           class="group relative bg-brand-gray border border-white/10 rounded-3xl p-8 hover:border-brand-teal/50 transition-all duration-500 hover:shadow-[0_20px_50px_rgba(45,212,191,0.15)] overflow-hidden">
            
            <!-- Background Glow on Hover -->
            <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-brand-teal/5 rounded-full blur-3xl group-hover:bg-brand-teal/20 transition-all duration-500"></div>

            <div class="relative z-10 flex flex-col items-center">
                <!-- Avatar -->
                <div class="w-24 h-24 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-black text-4xl mb-6 shadow-2xl group-hover:scale-110 transition-transform duration-500">
                    {{ substr($child->student->name, 0, 1) }}
                </div>

                <!-- Name & Info -->
                <h3 class="text-2xl font-bold text-white mb-2 text-center group-hover:text-brand-teal transition-colors">
                    {{ $child->student->name }}
                </h3>
                
                <div class="flex flex-col items-center gap-2">
                    <span class="px-4 py-1.5 bg-brand-teal/10 text-brand-teal rounded-full text-xs font-black uppercase tracking-widest border border-brand-teal/20">
                        {{ $child->student->schoolClass->name ?? 'Tanpa Kelas' }}
                    </span>
                    <span class="text-brand-light/40 text-sm">Absen: {{ $child->student->absen ?? '-' }}</span>
                </div>

                <!-- Action hint -->
                <div class="mt-8 flex items-center gap-2 text-brand-teal font-bold text-sm opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all duration-500">
                    LIHAT DETAIL
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </div>
            </div>
        </a>
        @endforeach
    </div>

    <!-- Info Footer -->
    <div class="mt-16 text-brand-light/40 flex items-center gap-3">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <p class="text-sm">Anda dapat mengganti pilihan anak kapan saja melalui dashboard.</p>
    </div>
</div>
@endsection
