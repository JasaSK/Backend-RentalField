<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Mail\VerifyEmail;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,user,superadmin',
        ]);

        $code = rand(100000, 999999);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => $validated['role'],
            'verification_code' => $code,
            'verification_code_expires_at' => Carbon::now()->addMinutes(10),
        ]);

        // Buat URL verifikasi
        $verifyUrl = url('/verify/' . $user->verification_code);

        // Kirim email dengan view 'verify.blade.php'
        Mail::send('verify', [
            'user' => $user,
            'code' => $code, // ← ini penting
            'verifyUrl' => $verifyUrl,
        ], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Kode Verifikasi Akun Anda');
        });

        return response()->json([
            'message' => 'Registrasi berhasil. Silakan periksa email untuk verifikasi.'
        ]);
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|string',
        ]);

        $user = User::where('email', $request->email)
            ->where('verification_code', $request->code)
            ->first();

        if (!$user) {
            return response()->json([
                'message' => 'Kode verifikasi salah atau email tidak ditemukan.'
            ], 400);
        }

        // Cek apakah kode sudah kadaluarsa
        if (!$user->verification_code_expires_at || Carbon::now()->greaterThan($user->verification_code_expires_at)) {
            return response()->json([
                'message' => 'Kode verifikasi sudah kadaluarsa.'
            ], 400);
        }

        // Update status verifikasi
        $user->update([
            'email_verified_at' => now(),
            'verification_code' => null,
            'verification_code_expires_at' => null,
        ]);

        return response()->json([
            'message' => 'Email berhasil diverifikasi!',
            'user' => $user,
        ]);
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        // Cari user berdasarkan email
        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json(['message' => 'Email atau password salah.'], 401);
        }

        // Cek apakah email sudah diverifikasi
        if (is_null($user->email_verified_at)) {
            return response()->json(['message' => 'Email belum diverifikasi. Silakan verifikasi terlebih dahulu.'], 403);
        }

        // Buat token API (jika pakai sanctum)
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil!',
            'user' => $user,
            'token' => $token,
            'role' => $user->role
        ]);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Email tidak ditemukan.'], 404);
        }

        $resetCode = rand(100000, 999999);
        $user->reset_code = $resetCode;
        $user->reset_code_expires_at = Carbon::now()->addMinutes(10);
        $user->save();

        Mail::raw("Kode reset password kamu adalah: $resetCode (berlaku 10 menit)", function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Kode Reset Password');
        });

        return response()->json(['message' => 'Kode reset password telah dikirim ke email.']);
    }

    // 2️⃣ Verifikasi kode reset
    public function verifyResetCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'reset_code' => 'required|string'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !$user->reset_code || $user->reset_code !== $request->reset_code) {
            return response()->json(['message' => 'Kode reset tidak valid.'], 400);
        }

        if (Carbon::now()->greaterThan($user->reset_code_expires_at)) {
            return response()->json(['message' => 'Kode reset telah kadaluarsa.'], 400);
        }

        return response()->json(['message' => 'Kode reset valid.']);
    }

    // 3️⃣ Ganti password setelah kode valid
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'reset_code' => 'required|string',
            'password' => 'required|string|min:6|confirmed'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || $user->reset_code !== $request->reset_code) {
            return response()->json(['message' => 'Kode reset tidak valid.'], 400);
        }

        if (Carbon::now()->greaterThan($user->reset_code_expires_at)) {
            return response()->json(['message' => 'Kode reset telah kadaluarsa.'], 400);
        }

        $user->password = Hash::make($request->password);
        $user->reset_code = null;
        $user->reset_code_expires_at = null;
        $user->save();

        return response()->json(['message' => 'Password berhasil direset.']);
    }
}
