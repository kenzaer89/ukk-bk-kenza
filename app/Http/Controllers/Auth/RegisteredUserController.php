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
        $students = \App\Models\User::where('role', 'student')->orderBy('name')->get();
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
            'class_id' => ['nullable', 'required_if:role,student', 'exists:classes,id'],
            'absen' => ['nullable', 'required_if:role,student', 'string', 'max:10'],
            'student_id' => ['nullable', 'required_if:role,parent', 'exists:users,id'],
        ]);

        $class = \App\Models\SchoolClass::find($request->class_id);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'class_id' => $request->class_id,
            'absen' => $request->absen,
            'specialization' => $class ? $class->jurusan : null,
        ]);

        if ($request->role === 'parent' && $request->student_id) {
            \App\Models\ParentStudent::create([
                'parent_id' => $user->id,
                'student_id' => $request->student_id,
            ]);
        }

        Auth::login($user);

        return redirect(route('home', absolute: false));
    }
}
