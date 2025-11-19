<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassModel; // Gunakan ClassModel
use App\Models\User;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    // Menampilkan daftar semua kelas. (READ - Index)
     
    public function index()
    {
        $classes = ClassModel::with('waliKelas')->latest()->paginate(10);
        
        return view('admin.classes.index', compact('classes'));
    }

    /**
     * Menampilkan form untuk membuat kelas baru. (CREATE - Form)
     */
    public function create()
    {
        $waliKelas = User::waliKelas()->orderBy('name')->get();
        return view('admin.classes.create', compact('waliKelas'));
    }

    /**
     * Menyimpan data kelas baru ke database. (CREATE - Store)
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:classes,name',
            'jurusan' => 'nullable|string|max:100',
            'wali_kelas_id' => 'nullable|exists:users,id,role,wali_kelas', // Validasi hanya boleh user role wali_kelas
        ]);

        ClassModel::create($request->all());

        return redirect()->route('admin.classes.index')
                         ->with('success', 'Data kelas berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit kelas. (UPDATE - Form)
     */
    public function edit(ClassModel $class)
    {
        $waliKelas = User::waliKelas()->orderBy('name')->get();
        return view('admin.classes.edit', compact('class', 'waliKelas'));
    }

    /**
     * Memperbarui data kelas di database. (UPDATE - Store)
     */
    public function update(Request $request, ClassModel $class)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:classes,name,' . $class->id,
            'jurusan' => 'nullable|string|max:100',
            'wali_kelas_id' => 'nullable|exists:users,id,role,wali_kelas',
        ]);

        $class->update($request->all());

        return redirect()->route('admin.classes.index')
                         ->with('success', 'Data kelas berhasil diperbarui.');
    }

    /**
     * Menghapus kelas dari database. (DELETE)
     */
    public function destroy(ClassModel $class)
    {
        // Pencegahan: Jangan hapus jika ada siswa yang terhubung
        if ($class->students()->count() > 0) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus kelas karena masih memiliki siswa terdaftar.');
        }

        $class->delete();

        return redirect()->route('admin.classes.index')
                         ->with('success', 'Data kelas berhasil dihapus.');
    }
}