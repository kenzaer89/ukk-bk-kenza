<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Menampilkan daftar semua pengguna. (READ - Index)
     */
    public function index(Request $request)
    {
        $query = User::with('schoolClass');

        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->paginate(15);
        
        $roles = ['admin', 'guru_bk', 'wali_kelas', 'student', 'parent'];

        return view('admin.users.index', compact('users', 'roles'));
    }

    /**
     * Menampilkan form untuk membuat pengguna baru. (CREATE - Form)
     */
    public function create()
    {
        $classes = SchoolClass::orderBy('name')->get();
        $students = User::where('role', 'student')->orderBy('name')->get();
        $allRoles = ['admin', 'guru_bk', 'wali_kelas', 'student', 'parent'];
        
        return view('admin.users.create', compact('classes', 'students', 'allRoles'));
    }

    /**
     * Menyimpan data pengguna baru. (CREATE - Store)
     */
    public function store(Request $request)
    {
        $data = $request->validate($this->getValidationRules($request));
        
        // Hash password
        $data['password'] = Hash::make($request->password);

        $user = User::create($data);
        
        // Penanganan relasi khusus Orang Tua
        if ($user->role == 'parent' && $request->has('student_ids')) {
            $user->students()->sync($request->student_ids);
        }

        return redirect()->route('admin.users.index')
                         ->with('success', 'Pengguna baru (' . $user->role . ') berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit pengguna. (UPDATE - Form)
     */
    public function edit(User $user)
    {
        $classes = SchoolClass::orderBy('name')->get();
        $students = User::where('role', 'student')->orderBy('name')->get();
        $allRoles = ['admin', 'guru_bk', 'wali_kelas', 'student', 'parent'];

        // Ambil ID siswa yang sudah terhubung (untuk role parent)
        $relatedStudentIds = ($user->role == 'parent') ? $user->students->pluck('id')->toArray() : [];
        
        return view('admin.users.edit', compact('user', 'classes', 'students', 'allRoles', 'relatedStudentIds'));
    }

    /**
     * Memperbarui data pengguna. (UPDATE - Store)
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate($this->getValidationRules($request, $user->id));
        
        // Hapus password jika field kosong
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }
        
        $user->update($data);

        // Penanganan relasi khusus Orang Tua
        if ($user->role == 'parent') {
            $user->students()->sync($request->student_ids ?? []);
        }

        return redirect()->route('admin.users.index')
                         ->with('success', 'Data pengguna ' . $user->name . ' berhasil diperbarui.');
    }

    /**
     * Menghapus pengguna. (DELETE)
     */
    public function destroy(User $user)
    {
        // Pencegahan: Tambahkan cek relasi penting lainnya di sini
        if ($user->role == 'parent') {
            $user->students()->detach();
        }
        
        $user->delete();

        return redirect()->route('admin.users.index')
                         ->with('success', 'Pengguna berhasil dihapus.');
    }
    
    /**
     * Metode privat untuk menentukan aturan validasi dinamis.
     */
    private function getValidationRules(Request $request, $userId = null)
    {
        $rules = [
            'name' => 'required|string|max:191',
            'email' => ['required', 'email', 'max:191', Rule::unique('users', 'email')->ignore($userId)],
            'role' => ['required', Rule::in(['admin', 'guru_bk', 'wali_kelas', 'student', 'parent'])],
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string',
        ];

        // Password hanya wajib saat buat baru atau diisi saat update
        $rules['password'] = $userId ? 'nullable|min:8|confirmed' : 'required|min:8|confirmed';

        // Aturan Khusus berdasarkan Role
        if ($request->role == 'student') {
            $rules['nis'] = ['required', 'string', 'max:50', Rule::unique('users', 'nis')->ignore($userId)];
            $rules['class_id'] = 'required|exists:classes,id';
            $rules['nip'] = 'nullable';
        } elseif (in_array($request->role, ['guru_bk', 'wali_kelas', 'admin'])) {
            $rules['nip'] = ['required', 'string', 'max:50', Rule::unique('users', 'nip')->ignore($userId)];
            $rules['class_id'] = 'nullable';
        } elseif ($request->role == 'parent') {
            $rules['relationship_to_student'] = 'required|string|max:100';
            $rules['student_ids'] = 'required|array';
            $rules['student_ids.*'] = 'exists:users,id,role,student';
            $rules['nis'] = 'nullable';
            $rules['nip'] = 'nullable';
        }

        return $rules;
    }
}