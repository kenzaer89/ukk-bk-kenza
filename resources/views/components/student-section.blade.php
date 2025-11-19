@props(['title', 'items', 'field', 'subtitle', 'color' => 'gray'])

{{-- Tambahkan logika untuk menampilkan daftar item --}}
<ul class="space-y-3">
    @forelse ($items as $item)
        <li class="p-3 bg-gray-700/50 rounded-lg border-l-4 border-{{ $color }}-500 transition hover:bg-gray-700">
            <p class="text-sm font-semibold text-white">{{ $item->$field }}</p>
            <p class="text-xs text-gray-400 italic">{{ $item->$subtitle }}</p>
        </li>
    @empty
        <div class="p-4 bg-gray-700/50 rounded-lg text-center">
            <p class="text-gray-400">Tidak ada data</p>
            <p class="text-sm text-gray-500 mt-1">Belum ada catatan {{ strtolower($title ?? 'Data') }}.</p>
        </div>
    @endforelse
</ul>