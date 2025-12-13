<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function PageLogin()
    {
        return view('auth.login');
    }

    // 🔹 LOGIN
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        // dd($request->all());

        $credentials = $request->only('email', 'password');
        if (Auth::guard('web')->attempt($credentials)) {
            $user = Auth::user();
            $request->session()->put('user_name', $user->name);


            return redirect()->route('admin.dashboard')->with('success', 'Login berhasil!');
        }
        return back()->withErrors(['login' => 'Email atau password salah!'])->with('error', 'Login gagal, silakan coba lagi.');
    }
    
    public function logout(Request $request)
    {
        $request->session()->forget(['user_id', 'user_name', 'user_email']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.page.login')->with('success', 'Anda telah logout.');
    }

}
