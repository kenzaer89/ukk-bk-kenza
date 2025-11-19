<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TopicController extends Controller
{
    /**
     * Menampilkan daftar semua topik.
     */
    public function index()
    {
        $topics = Topic::orderBy('name')->paginate(10);
        
        return view('admin.topics.index', compact('topics'));
    }

    /**
     * Menampilkan form untuk membuat topik baru.
     */
    public function create()
    {
        return view('admin.topics.create');
    }

    /**
     * Menyimpan data topik baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:191|unique:topics,name',
            'description' => 'nullable|string',
        ]);

        Topic::create($request->all());

        return redirect()->route('admin.topics.index')
                         ->with('success', 'Topik konseling berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit topik.
     */
    public function edit(Topic $topic)
    {
        return view('admin.topics.edit', compact('topic'));
    }

    /**
     * Memperbarui data topik.
     */
    public function update(Request $request, Topic $topic)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:191', Rule::unique('topics', 'name')->ignore($topic->id)],
            'description' => 'nullable|string',
        ]);

        $topic->update($request->all());

        return redirect()->route('admin.topics.index')
                         ->with('success', 'Topik konseling berhasil diperbarui.');
    }

    /**
     * Menghapus topik.
     */
    public function destroy(Topic $topic)
    {
        // Pencegahan: Sebaiknya dicek apakah topik ini masih terhubung dengan sesi konseling
        // if ($topic->sessions()->count() > 0) { ... return error ... }
        
        $topic->delete();

        return redirect()->route('admin.topics.index')
                         ->with('success', 'Topik konseling berhasil dihapus.');
    }
}