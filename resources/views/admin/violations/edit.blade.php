@extends('layouts.app')

@section('title', 'Edit Data Pelanggaran')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6 text-white">Edit Data Pelanggaran</h1>

    <div class="bg-gray-800 rounded-xl shadow-lg p-8 max-w-2xl">
        <form action="{{ route('admin.violations.update', $violation->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div>
                <label for="student_id" class="block text-sm font-medium text-gray-300 mb-2">Pilih Siswa</label>
                <select id="student_id_display" disabled
                        class="w-full p-3 bg-gray-600 border border-gray-600 rounded-lg text-sm text-gray-400 cursor-not-allowed">
                    @foreach ($students as $student)
                        <option value="{{ $student->id }}" data-points="{{ $student->points }}" {{ $violation->student_id == $student->id ? 'selected' : '' }}>
                            {{ $student->name }} - {{ $student->schoolClass->name ?? 'Tanpa Kelas' }} (Sisa Poin: {{ $student->points }})
                        </option>
                    @endforeach
                </select>
                <input type="hidden" name="student_id" value="{{ $violation->student_id }}">
                <p class="mt-1 text-xs text-gray-400">Siswa tidak dapat diubah setelah pelanggaran dibuat</p>
                @error('student_id') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="rule_id" class="block text-sm font-medium text-gray-300 mb-2">Pilih Jenis Pelanggaran <span class="text-red-500">*</span></label>
                <select name="rule_id" id="rule_id" required
                        oninvalid="this.setCustomValidity('Silakan pilih jenis pelanggaran')"
                        oninput="this.setCustomValidity('')"
                        class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-red-500 focus:border-red-500 text-sm text-white">
                    <option value="">-- Pilih Aturan Pelanggaran --</option>
                    <option value="custom" {{ old('rule_id', $violation->rule?->is_custom ? 'custom' : $violation->rule_id) == 'custom' ? 'selected' : '' }}>-- Custom: Buat Aturan Baru --</option>
                    @foreach ($rules as $rule)
                        <option value="{{ $rule->id }}" data-category="{{ $rule->category ?? '' }}" data-points="{{ $rule->points }}" data-name="{{ $rule->name }}" {{ old('rule_id', $violation->rule_id) == $rule->id ? 'selected' : '' }}>
                            {{ $rule->name }} ({{ $rule->points }} poin)
                        </option>
                    @endforeach
                </select>
                @error('rule_id') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div id="custom-rule-fields" class="{{ old('rule_id', $violation->rule?->is_custom ? 'custom' : $violation->rule_id) == 'custom' ? '' : 'hidden' }}">
                <div>
                    <label for="custom_rule_name" class="block text-sm font-medium text-gray-300 mb-2">Nama Aturan Baru</label>
                    <input type="text" name="custom_rule_name" id="custom_rule_name" value="{{ old('custom_rule_name', $violation->rule?->is_custom ? $violation->rule->name : '') }}"
                           oninvalid="this.setCustomValidity('Tuliskan nama aturan baru')"
                           oninput="this.setCustomValidity('')"
                           class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-red-500 focus:border-red-500 text-sm text-white">
                    @error('custom_rule_name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
                <div class="mt-3">
                    <label for="custom_points" class="block text-sm font-medium text-gray-300 mb-2">Poin (masukkan angka, mis: 10 akan otomatis menjadi -10 dan dikurangi)</label>
                        <input type="number" name="custom_points" id="custom_points" value="{{ old('custom_points', ($violation->rule?->is_custom ? abs($violation->rule->points) : '')) }}"
                           oninvalid="this.setCustomValidity('Masukkan jumlah poin')"
                           oninput="this.setCustomValidity('')"
                           class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-red-500 focus:border-red-500 text-sm text-white">
                    @error('custom_points') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>
            
            <div>
                <label for="violation_date" class="block text-sm font-medium text-gray-300 mb-2">Tanggal Pelanggaran <span class="text-red-500">*</span></label>
                <input type="date" name="violation_date" id="violation_date" value="{{ old('violation_date', $violation->violation_date->format('Y-m-d')) }}" required
                       style="color-scheme: dark;"
                       max="{{ date('Y-m-d') }}"
                       oninvalid="this.setCustomValidity('Pilih tanggal pelanggaran')"
                       oninput="this.setCustomValidity('')"
                       class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-red-500 focus:border-red-500 text-sm text-white">
                @error('violation_date') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-300 mb-2">Catatan Tambahan <span class="text-red-500">*</span></label>
                <textarea name="description" id="description" rows="4" required maxlength="500"
                          oninvalid="this.setCustomValidity('Harap isi catatan pelanggaran')"
                          oninput="this.setCustomValidity('')"
                          class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-red-500 focus:border-red-500 text-sm text-white">{{ old('description', $violation->description) }}</textarea>
                @error('description') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-300 mb-2">Status <span class="text-red-500">*</span></label>
                <select name="status" id="status" required
                        oninvalid="this.setCustomValidity('Pilih status pelanggaran')"
                        oninput="this.setCustomValidity('')"
                        class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-red-500 focus:border-red-500 text-sm text-white">
                    <option value="pending" {{ old('status', $violation->status) == 'pending' ? 'selected' : '' }}>Pending (Menunggu Tindakan)</option>
                    <option value="resolved" {{ old('status', $violation->status) == 'resolved' ? 'selected' : '' }}>Resolved (Selesai)</option>
                </select>
                @error('status') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.violations.index') }}" 
                   class="py-2 px-4 border border-gray-600 rounded-lg text-gray-300 hover:bg-gray-700 transition">Batal</a>
                <button type="submit" id="btn-submit-violation"
                        class="py-2 px-4 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition duration-300">
                    Perbarui Pelanggaran
                </button>
            </div>
        </form>
    </div>
</div>
<script>
    (function() {
        const studentSelect = document.getElementById('student_id_display');
        const ruleSelect = document.getElementById('rule_id');
        const customFields = document.getElementById('custom-rule-fields');
        const customPointsInput = document.getElementById('custom_points');
        const statusSelect = document.getElementById('status');
        const submitBtn = document.getElementById('btn-submit-violation');
        const form = ruleSelect.closest('form');


        function toggleCustom() {
            if (!ruleSelect || !customFields) return;
            const selectedOpt = ruleSelect.options[ruleSelect.selectedIndex];
            const isCustomCategory = selectedOpt && selectedOpt.dataset && selectedOpt.dataset.category === 'custom';
            if (ruleSelect.value === 'custom' || isCustomCategory) {
                customFields.classList.remove('hidden');
                const nameInput = document.getElementById('custom_rule_name');
                const pointsInput = document.getElementById('custom_points');
                if (isCustomCategory && selectedOpt.dataset.name) {
                    if (nameInput && !nameInput.value) nameInput.value = selectedOpt.dataset.name;
                }
                if (isCustomCategory && selectedOpt.dataset.points) {
                    if (pointsInput && !pointsInput.value) pointsInput.value = Math.abs(selectedOpt.dataset.points);
                }
            } else {
                customFields.classList.add('hidden');
            }
        }

        function validatePointLimit() {
            // Only validate if status is being set to 'resolved'
            if (statusSelect.value !== 'resolved') return true;

            const studentOpt = studentSelect.options[studentSelect.selectedIndex];
            if (!studentOpt || !studentOpt.value) return true; // Should not happen as student is pre-selected

            const currentPoints = parseInt(studentOpt.dataset.points);
            let deductionPoints = 0;

            if (ruleSelect.value === 'custom') {
                deductionPoints = Math.abs(parseInt(customPointsInput.value || 0));
            } else {
                const ruleOpt = ruleSelect.options[ruleSelect.selectedIndex];
                if (ruleOpt && ruleOpt.value) {
                    deductionPoints = Math.abs(parseInt(ruleOpt.dataset.points));
                }
            }

            if (deductionPoints > currentPoints) {
                Swal.fire({
                    icon: 'error',
                    title: 'Batas Poin Terlampaui',
                    text: `Pengurangan poin (${deductionPoints}) melebihi sisa poin siswa (${currentPoints}). Silakan pilih status Pending atau pilih aturan lain.`,
                    confirmButtonText: 'Tutup',
                    confirmButtonColor: '#ef4444'
                });
                return false;
            }

            return true;
        }

        if (ruleSelect) {
            ruleSelect.addEventListener('change', toggleCustom);
            toggleCustom();
        }


        form.addEventListener('submit', function(e) {
            if (!validatePointLimit()) {
                e.preventDefault();
            }
        });
    })();
</script>
@endsection
