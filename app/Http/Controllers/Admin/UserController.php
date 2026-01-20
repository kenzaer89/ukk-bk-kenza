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
        $query = User::with(['schoolClass', 'students', 'managedClass']);

        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }

        // Filter by search if provided
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(15)->withQueryString();
        
        $roles = ['guru_bk', 'wali_kelas', 'student', 'parent'];

        return view('admin.users.index', compact('users', 'roles'));
    }

    /**
     * Menampilkan form untuk membuat pengguna baru. (CREATE - Form)
     */
    public function create()
    {
        $classes = SchoolClass::orderBy('name')->get();
        $students = User::where('role', 'student')->orderBy('name')->get();
        $allRoles = ['guru_bk', 'wali_kelas', 'student', 'parent'];
        
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
        $allRoles = ['guru_bk', 'wali_kelas', 'student', 'parent'];

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
        // Proteksi Akun Admin Utama (Admin BK)
        if ($user->email === 'adminbk@gmail.com') {
            return redirect()->route('admin.users.index')
                             ->with('error', 'Akun Administrator Utama tidak dapat dihapus demi keamanan sistem.');
        }

        // Jika user yang ingin dihapus adalah admin, hanya admin utama yang boleh melakukannya
        if ($user->role === 'admin' && auth()->user()->email !== 'adminbk@gmail.com') {
            return redirect()->route('admin.users.index')
                             ->with('error', 'Hanya Administrator Utama yang dapat menghapus akun admin lainnya.');
        }

        // Pencegahan: Tambahkan cek relasi penting lainnya di sini
        if ($user->role == 'parent') {
            $user->students()->detach();
        }
        
        $user->delete();

        return redirect()->route('admin.users.index')
                         ->with('success', 'Pengguna berhasil dihapus.');
    }

    /**
     * Setujui akun pengguna (Approve)
     */
    public function approve(User $user)
    {
        $user->update(['is_approved' => true]);

        return redirect()->back()
                         ->with('success', 'Akun ' . $user->name . ' berhasil disetujui.');
    }

    /**
     * Tolak permintaan akun pengguna (Reject/Delete)
     */
    public function reject(User $user)
    {
        // Jika sudah disetujui, tidak bisa ditolak (harus lewat hapus biasa jika ingin hapus)
        // Tapi untuk kemudahan, tolak di sini akan menghapus user yang belum di-approve
        if ($user->is_approved) {
            return redirect()->back()->with('error', 'Akun yang sudah disetujui tidak bisa ditolak. Gunakan fitur hapus jika ingin menghapus.');
        }

        $userName = $user->name;
        
        // Detach relations if any (similar to destroy)
        if ($user->role == 'parent') {
            $user->students()->detach();
        }

        $user->delete();

        return redirect()->back()
                         ->with('success', 'Permintaan akun ' . $userName . ' telah ditolak dan akun telah dihapus.');
    }
    
    /**
     * Metode privat untuk menentukan aturan validasi dinamis.
     */
    private function getValidationRules(Request $request, $userId = null)
    {
        $rules = [
            'name' => 'required|string|max:191',
            'email' => ['required', 'email', 'max:191', Rule::unique('users', 'email')->ignore($userId)],
            'role' => ['required', Rule::in(['guru_bk', 'wali_kelas', 'student', 'parent'])],
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string',
        ];

        // Password hanya wajib saat buat baru atau diisi saat update
        $rules['password'] = $userId ? 'nullable|min:8|confirmed' : 'required|min:8|confirmed';

        // Aturan Khusus berdasarkan Role
        if ($request->role == 'student') {
            $rules['absen'] = 'required|integer|min:1';
            $rules['class_id'] = 'required|exists:classes,id';
            $rules['nisn'] = 'nullable|string|size:10';
            $rules['nis'] = 'nullable|string|max:50';
            $rules['nip'] = 'nullable';
        } elseif (in_array($request->role, ['guru_bk', 'wali_kelas'])) {
            $rules['nip'] = ['required', 'string', 'max:50', Rule::unique('users', 'nip')->ignore($userId)];
            $rules['class_id'] = 'nullable';
            

        } elseif ($request->role == 'admin') {
            $rules['nip'] = 'nullable';
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