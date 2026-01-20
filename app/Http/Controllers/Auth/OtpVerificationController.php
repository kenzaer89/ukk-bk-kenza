<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Carbon\Carbon;

class OtpVerificationController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }
        
        if ($user->email_verified_at) {
            return redirect()->route('home');
        }
        return view('auth.verify-otp');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
        ]);

        $user = Auth::user();

        if ($user->otp_code === $request->otp && $user->otp_expires_at && Carbon::now()->lt($user->otp_expires_at)) {
            $user->email_verified_at = Carbon::now();
            $user->otp_code = null;
            $user->otp_expires_at = null;
            $user->save();

            return redirect()->route('home')->with('success', 'Email berhasil diverifikasi!');
        }

        return back()->withErrors(['otp' => 'Kode OTP tidak valid atau sudah daluarsa.']);
    }

    public function resend()
    {
        $user = Auth::user();
        
        $otp = sprintf("%06d", mt_rand(1, 999999));
        $user->otp_code = $otp;
        $user->otp_expires_at = Carbon::now()->addMinutes(10);
        $user->save();

        try {
            Mail::to($user->email)->send(new OtpMail($otp));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Mail Error: " . $e->getMessage());
            return back()->with('error', 'Gagal mengirim email: ' . $e->getMessage()); // Temporary showing error to user
        }

        return back()->with('success', 'Kode OTP baru telah dikirim ke email Anda.');
    }
}
