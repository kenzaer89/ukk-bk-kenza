<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PointLevel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PointLevelController extends Controller
{
    /**
     * Menampilkan daftar semua tingkat poin. (READ - Index)
     */
    public function index()
    {
        // Urutkan berdasarkan point_threshold secara menurun (poin tertinggi di atas)
        $levels = PointLevel::orderBy('point_threshold', 'desc')->paginate(10);
        
        return view('admin.point_levels.index', compact('levels'));
    }

    /**
     * Menampilkan form untuk membuat tingkat poin baru. (CREATE - Form)
     */
    public function create()
    {
        return view('admin.point_levels.create');
    }

    /**
     * Menyimpan data tingkat poin baru ke database. (CREATE - Store)
     */
    public function store(Request $request)
    {
        $request->validate([
            // Point threshold harus unik dan bilangan bulat positif
            'point_threshold' => 'required|integer|min:1|unique:point_levels,point_threshold',
            'action' => 'required|string',
        ]);

        PointLevel::create($request->all());

        return redirect()->route('admin.point_levels.index')
                         ->with('success', 'Tingkat poin dan tindakan berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit tingkat poin. (UPDATE - Form)
     */
    public function edit(PointLevel $point_level)
    {
        return view('admin.point_levels.edit', compact('point_level'));
    }

    /**
     * Memperbarui data tingkat poin di database. (UPDATE - Store)
     */
    public function update(Request $request, PointLevel $point_level)
    {
        $request->validate([
            // Point threshold harus unik, kecuali dirinya sendiri
            'point_threshold' => [
                'required', 
                'integer', 
                'min:1', 
                Rule::unique('point_levels', 'point_threshold')->ignore($point_level->id)
            ],
            'action' => 'required|string',
        ]);

        $point_level->update($request->all());

        return redirect()->route('admin.point_levels.index')
                         ->with('success', 'Tingkat poin dan tindakan berhasil diperbarui.');
    }

    /**
     * Menghapus tingkat poin dari database. (DELETE)
     */
    public function destroy(PointLevel $point_level)
    {
        $point_level->delete();

        return redirect()->route('admin.point_levels.index')
                         ->with('success', 'Tingkat poin berhasil dihapus.');
    }
}