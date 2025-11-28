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

    public function PageRegister()
    {
        return view('auth.register');
    }

    public function PageVerify(Request $request)
    {
        $email = $request->email ?? session('email');
        return view('auth.verify', compact('email'));
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


    // 🔹 REGISTER
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'no_telp' => 'required|string|min:10|max:15',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'no_telp' => $request->no_telp,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'email_verified_at' => null,
            'verification_code' => rand(100000, 999999), // kode verifikasi 6 digit
        ]);

        session(['email' => $user->email]);

        return redirect()->route('PageVerify', ['email' => $user->email])->with([
            'swal' => [
                'icon' => 'success',
                'title' => 'Registrasi Berhasil!',
                'text' => 'Silakan cek email Anda untuk kode verifikasi.',
                'timer' => 3000
            ]
        ]);
    }

    // 🔹 VERIFY EMAIL
    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'code' => 'required|digits:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && $user->verification_code == $request->code) {
            $user->email_verified_at = now();
            $user->verification_code = null;
            $user->save();

            return back()->with('verified_success', 'Akun Anda telah terverifikasi.');
        }

        return back()->with([
            'swal' => [
                'icon' => 'error',
                'title' => 'Verifikasi Gagal!',
                'text' => 'Kode verifikasi salah atau kadaluarsa.',
            ]
        ]);
    }

    // 🔹 RESEND CODE
    public function resendCode()
    {
        $email = session('email');

        if (!$email) {
            return back()->with('error', 'Email tidak ditemukan di session. Silakan registrasi ulang.');
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()->with('error', 'Pengguna tidak ditemukan.');
        }

        $user->verification_code = rand(100000, 999999);
        $user->save();

        return back()->with([
            'swal' => [
                'icon' => 'success',
                'title' => 'Kode Terkirim!',
                'text' => 'Kode verifikasi telah dikirim ulang ke email Anda.',
                'timer' => 3000
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
