<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        $num1 = rand(1, 10);
        $num2 = rand(1, 10);
        session(['login_captcha_answer' => $num1 + $num2]);
        $captcha_question = "$num1 + $num2 = ?";
        return view('auth.login', compact('captcha_question'));
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->validate([
            'captcha' => ['required', 'integer', function ($attribute, $value, $fail) {
                if ($value != session('login_captcha_answer')) {
                    $fail('Jawaban Pertanyaan Keamanan salah.');
                }
            }],
        ]);

        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();
        switch ($user->role) {
            case 'admin':
            case 'guru_bk':
                return redirect()->route('admin.dashboard');
            case 'student':
                return redirect()->route('student.dashboard');
            case 'parent':
                return redirect()->route('parent.dashboard');
            case 'wali_kelas':
                return redirect()->route('wali.dashboard');
            default:
                return redirect()->route('home');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
