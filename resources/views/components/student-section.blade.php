@props(['title', 'items' => [], 'field' => 'created_at', 'subtitle' => '', 'color' => 'sky'])

<div class="glass p-5 rounded-xl border border-slate-700 shadow-md">
  <h3 class="text-lg font-semibold mb-3 text-{{ $color }}-400">{{ $title }}</h3>

  <ul class="space-y-2 text-gray-300 text-sm">
    @forelse ($items as $item)
      <li class="border-b border-slate-700 pb-2 flex justify-between">
        <span>
          📅 {{ \Carbon\Carbon::parse($item[$field])->format('d F Y') }}
          — <span class="italic text-gray-400">{{ $item[$subtitle] ?? '-' }}</span>
        </span>
      </li>
    @empty
      <li class="text-gray-500 italic">Tidak ada data</li>
    @endforelse
  </ul>
</div>
