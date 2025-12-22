<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function PageLogin()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->validated())) {
            $request->session()->regenerate();
            return redirect()
                ->route('admin.dashboard')
                ->with('success', 'Login berhasil!');
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
