<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rule;
use Illuminate\Http\Request;

class RuleController extends Controller
{
    /**
     * Menampilkan daftar semua aturan. (READ - Index)
     */
    public function index()
    {
        $rules = Rule::orderBy('points', 'desc')->paginate(10);
        
        return view('admin.rules.index', compact('rules'));
    }

    /**
     * Menampilkan form untuk membuat aturan baru. (CREATE - Form)
     */
    public function create()
    {
        // Kategori bisa diset statis atau dari database jika ada tabel kategori
        $categories = ['Ringan', 'Sedang', 'Berat', 'Sangat Berat'];
        return view('admin.rules.create', compact('categories'));
    }

    /**
     * Menyimpan data aturan baru ke database. (CREATE - Store)
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:191|unique:rules,name',
            'points' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
        ]);

        Rule::create($request->all());

        return redirect()->route('admin.rules.index')
                         ->with('success', 'Aturan pelanggaran berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit aturan. (UPDATE - Form)
     */
    public function edit(Rule $rule)
    {
        $categories = ['Ringan', 'Sedang', 'Berat', 'Sangat Berat'];
        return view('admin.rules.edit', compact('rule', 'categories'));
    }

    /**
     * Memperbarui data aturan di database. (UPDATE - Store)
     */
    public function update(Request $request, Rule $rule)
    {
        $request->validate([
            'name' => 'required|string|max:191|unique:rules,name,' . $rule->id,
            'points' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
        ]);

        $rule->update($request->all());

        return redirect()->route('admin.rules.index')
                         ->with('success', 'Aturan pelanggaran berhasil diperbarui.');
    }

    /**
     * Menghapus aturan dari database. (DELETE)
     */
    public function destroy(Rule $rule)
    {
        // Pencegahan: Jangan hapus jika ada pelanggaran yang terhubung
        if ($rule->violations()->count() > 0) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus aturan ini karena masih memiliki catatan pelanggaran terhubung.');
        }

        $rule->delete();

        return redirect()->route('admin.rules.index')
                         ->with('success', 'Aturan pelanggaran berhasil dihapus.');
    }
}