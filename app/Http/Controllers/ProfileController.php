<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Show the user profile.
     */
    public function show()
    {
        $user = Auth::user();
        $user->load('schoolClass');
        
        return view('profile.show', compact('user'));
    }

    /**
     * Update the user profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Check if user is admin
        if ($user->role !== 'admin') {
            return back()->with('error', 'Hanya administrator yang memiliki wewenang untuk mengubah informasi profil.');
        }

        $rules = [
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'nisn' => 'nullable|string|size:10',
            'nip' => 'nullable|string|max:50',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|string|min:8|confirmed',
        ];

        $request->validate($rules);

        // Verify current password if changing password (though fields are removed from view)
        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->with('error', 'Kata sandi lama tidak sesuai.')->withInput();
            }
            $user->password = Hash::make($request->new_password);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->nisn = $request->nisn;
        $user->nip = $request->nip;

        $user->save();

        return back()->with('success', 'Profil Anda berhasil diperbarui.');
    }
}
