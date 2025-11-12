@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="space-y-10">

  {{-- HEADER --}}
  <div class="glass p-8 rounded-2xl">
    <h2 class="text-2xl font-semibold mb-2 text-white">
      Halo, {{ Auth::user()->name ?? 'Siswa' }} 👋
    </h2>
    <p class="text-gray-400">
      Selamat datang kembali di sistem Bimbingan Konseling Sekolah!
    </p>
  </div>

  {{-- RINGKASAN --}}
  <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
    <x-dashboard-card title="Jadwal Konseling" :value="$totalSchedules ?? 0" color="sky" />
    <x-dashboard-card title="Sesi Konseling" :value="$totalSessions ?? 0" color="green" />
    <x-dashboard-card title="Pelanggaran" :value="$totalViolations ?? 0" color="red" />
    <x-dashboard-card title="Prestasi" :value="$totalAchievements ?? 0" color="yellow" />
  </div>

  {{-- AJUKAN KONSELING --}}
  <div class="glass p-6 rounded-2xl">
    <h3 class="text-lg font-semibold mb-4 text-sky-400">📝 Ajukan Permintaan Konseling</h3>
    <form action="{{ route('student.requests.store') }}" method="POST" class="space-y-4">
      @csrf
      <input type="text" name="topic" placeholder="Topik Konseling" required
        class="w-full px-4 py-2 rounded-lg bg-slate-800 border border-slate-700 text-white">
      <textarea name="description" rows="3" placeholder="Deskripsi (opsional)"
        class="w-full px-4 py-2 rounded-lg bg-slate-800 border border-slate-700 text-white"></textarea>
      <button class="bg-sky-500 hover:bg-sky-600 px-6 py-2 rounded-lg font-semibold">Kirim Permintaan</button>
    </form>
  </div>

  {{-- DATA UTAMA --}}
  <div class="grid md:grid-cols-2 gap-6">
    <x-student-section title="📅 Jadwal Terdekat" :items="$upcomingSchedules ?? []" field="scheduled_date" subtitle="topic" />
    <x-student-section title="💬 Sesi Terakhir" :items="$recentSessions ?? []" field="session_date" subtitle="notes" />
  </div>

  <div class="grid md:grid-cols-2 gap-6">
    <x-student-section title="⚠️ Pelanggaran Terbaru" :items="$recentViolations ?? []" field="created_at" subtitle="violation_type" color="red" />
    <x-student-section title="🏆 Prestasi Terbaru" :items="$recentAchievements ?? []" field="created_at" subtitle="title" color="amber" />
  </div>

  {{-- PERMINTAAN KONSELING --}}
  <div class="glass p-6 rounded-2xl">
    <h3 class="text-lg font-semibold mb-3 text-purple-400">📨 Permintaan Konseling Terakhir</h3>
    <ul class="space-y-2 text-gray-300">
      @forelse($recentRequests ?? [] as $req)
        <li class="border-b border-slate-700 pb-2">
          {{ $req->topic }} —
          <span class="text-sky-400">{{ ucfirst($req->status ?? 'pending') }}</span>
        </li>
      @empty
        <li class="text-gray-500 italic">Belum ada permintaan konseling.</li>
      @endforelse
    </ul>
  </div>

  {{-- CHART --}}
  <div class="glass p-6 rounded-2xl">
    <h3 class="text-lg font-semibold mb-4 text-sky-400">📊 Grafik Aktivitas</h3>
    <canvas id="studentChart"></canvas>
  </div>
</div>

<style>
  .glass {
    background: rgba(30, 41, 59, 0.6);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.1);
  }
  .glow {
    text-shadow: 0 0 10px rgba(56,189,248,0.5);
  }
</style>

{{-- ChartJS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('studentChart');
new Chart(ctx, {
  type: 'line',
  data: {
    labels: @json($months ?? []),
    datasets: [
      {
        label: 'Sesi Konseling',
        data: @json(array_values($sessionsChart ?? [])),
        borderColor: '#38bdf8',
        backgroundColor: 'rgba(56,189,248,0.2)',
        tension: 0.3,
        fill: true
      },
      {
        label: 'Pelanggaran',
        data: @json(array_values($violationsChart ?? [])),
        borderColor: '#f87171',
        backgroundColor: 'rgba(248,113,113,0.2)',
        tension: 0.3,
        fill: true
      }
    ]
  },
  options: { responsive: true, scales: { y: { beginAtZero: true } } }
});
</script>
@endsection
