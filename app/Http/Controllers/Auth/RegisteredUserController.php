<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $classes = \App\Models\SchoolClass::orderBy('name')->get();
        $students = \App\Models\User::where('role', 'student')
            ->withCount('childrenConnections')
            ->orderBy('name')
            ->get();
        return view('auth.register', compact('classes', 'students'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:student,parent,wali_kelas'],
            'phone' => ['required', 'string', 'max:20', 'regex:/^[0-9]+$/'],
            'nip' => ['nullable', 'required_if:role,wali_kelas', 'string', 'max:50'],
            'nisn' => ['nullable', 'required_if:role,student', 'string', 'size:10'],
            'class_id' => ['nullable', 'required_if:role,student', 'exists:classes,id'],
            'absen' => ['nullable', 'required_if:role,student', 'integer', 'min:1'],
            'student_ids' => ['nullable', 'required_if:role,parent', 'array'],
            'student_ids.*' => [
                'exists:users,id,role,student',
                function ($attribute, $value, $fail) {
                    $hasParent = \App\Models\ParentStudent::where('student_id', $value)->exists();
                    if ($hasParent) {
                        $fail('Siswa yang dipilih sudah memiliki orang tua yang terdaftar.');
                    }
                },
            ],
        ]);

        $class = \App\Models\SchoolClass::find($request->class_id);

        // Generate OTP
        $otp = sprintf("%06d", mt_rand(100000, 999999));

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'phone' => $request->phone,
            'nisn' => $request->nisn,
            'nip' => $request->nip,
            'class_id' => $request->class_id,
            'absen' => $request->absen,
            'specialization' => $class ? $class->jurusan : null,
            'is_approved' => !in_array($request->role, ['parent', 'wali_kelas']),
            'otp_code' => $otp,
            'otp_expires_at' => \Carbon\Carbon::now()->addMinutes(10),
        ]);

        if ($request->role === 'parent' && $request->has('student_ids')) {
            foreach($request->student_ids as $sid) {
                \App\Models\ParentStudent::create([
                    'parent_id' => $user->id,
                    'student_id' => $sid,
                ]);
            }
        }

        // Send OTP via Email
        try {
            \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\OtpMail($otp));
            $request->session()->flash('success', 'Registrasi berhasil! Silakan cek email Anda untuk kode OTP.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Registration Mail Error: " . $e->getMessage());
            $request->session()->flash('warning', 'Registrasi berhasil, tetapi gagal mengirim email OTP. Silakan klik kirim ulang di halaman verifikasi.');
        }

        Auth::login($user);

        return redirect()->route('otp.verify');
    }
}
