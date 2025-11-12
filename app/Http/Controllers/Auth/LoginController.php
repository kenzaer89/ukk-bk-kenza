<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        // Kalau user sudah login, langsung arahkan ke dashboard sesuai role
        if (auth()->check()) {
            $user = auth()->user();
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'student':
                    return redirect()->route('student.dashboard');
                case 'parent':
                    return redirect()->route('parent.dashboard');
                case 'wali_kelas':
                    return redirect()->route('wali.dashboard');
            }
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            $user = Auth::user();
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'student':
                    return redirect()->route('student.dashboard');
                case 'parent':
                    return redirect()->route('parent.dashboard');
                case 'wali_kelas':
                    return redirect()->route('wali.dashboard');
            }
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
