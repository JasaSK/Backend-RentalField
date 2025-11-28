<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && password_verify($request->password, $user->password)) { // password harus hash
            // Simpan session manual
            session([
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
                'role' => $user->role, 
            ]);

            return redirect()->route('admin.dashboard')->with([
                'swal' => [
                    'icon' => 'success',
                    'title' => 'Login Berhasil!',
                    'text' => 'Selamat datang, ' . $user->name . '!',
                    'timer' => 2000
                ]
            ]);
        }

        return back()->withErrors(['login' => 'Email atau password salah!'])->with([
            'swal' => [
                'icon' => 'error',
                'title' => 'Login Gagal!',
                'text' => 'Email atau password salah!',
            ]
        ]);
    }


    public function logout(Request $request)
    {
        $request->session()->forget(['user_id', 'user_name', 'user_email']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with([
            'swal' => [
                'icon' => 'success',
                'title' => 'Logout Berhasil!',
                'text' => 'Anda telah berhasil logout.',
                'timer' => 3000
            ]
        ]);
    }
}
