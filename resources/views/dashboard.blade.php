@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="glass glow-border rounded-2xl p-8">
  <h2 class="text-2xl font-semibold neon mb-6">Dashboard</h2>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-slate-800/60 p-5 rounded-xl border border-slate-700 hover:scale-[1.02] transition transform">
      <h3 class="text-gray-300 text-sm">Total Siswa</h3>
      <p class="text-3xl font-bold text-sky-400">{{ $totalStudents ?? 0 }}</p>
    </div>

    <div class="bg-slate-800/60 p-5 rounded-xl border border-slate-700 hover:scale-[1.02] transition transform">
      <h3 class="text-gray-300 text-sm">Guru BK</h3>
      <p class="text-3xl font-bold text-sky-400">{{ $totalTeachers ?? 0 }}</p>
    </div>

    <div class="bg-slate-800/60 p-5 rounded-xl border border-slate-700 hover:scale-[1.02] transition transform">
      <h3 class="text-gray-300 text-sm">Sesi Konseling</h3>
      <p class="text-3xl font-bold text-sky-400">{{ $totalSessions ?? 0 }}</p>
    </div>
  </div>

  <div class="mt-10">
    <h3 class="text-lg font-semibold mb-3 text-sky-400">Aktivitas Terbaru</h3>
    <ul class="text-gray-400 text-sm space-y-2">
      @forelse($recentActivities ?? [] as $activity)
        <li class="border-b border-slate-700 pb-2">{{ $activity }}</li>
      @empty
        <li class="text-gray-500 italic">Belum ada aktivitas terbaru.</li>
      @endforelse
    </ul>
  </div>
</div>
@endsection
