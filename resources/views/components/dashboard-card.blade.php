@props(['title', 'value' => 0, 'color' => 'sky'])

<div class="glass p-5 rounded-xl border border-slate-700 hover:scale-[1.02] transition transform shadow-md">
  <h3 class="text-gray-300 text-sm">{{ $title }}</h3>
  <p class="text-3xl font-bold text-{{ $color }}-400 mt-1">{{ $value }}</p>
</div>
