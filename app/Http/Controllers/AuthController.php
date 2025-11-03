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
}
