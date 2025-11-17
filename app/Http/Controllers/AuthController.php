<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'no_telp' => 'required|string|min:10|max:15',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:admin,user,superadmin',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'no_telp.required' => 'Nomor telepon wajib diisi.',
            'no_telp.min' => 'Nomor telepon minimal 10 digit.',
            'no_telp.max' => 'Nomor telepon maksimal 15 digit.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'role.required' => 'Role wajib diisi.',
            'role.in' => 'Role hanya boleh admin, user, atau superadmin.',
        ]);

        // Cek apakah sudah ada user dengan email / no_telp ini
        $existingUser = User::where('email', $validated['email'])
            ->orWhere('no_telp', $validated['no_telp'])
            ->first();

        $code = rand(100000, 999999);
        $verifyUrl = url('/verify/' . $code);

        if ($existingUser) {
            // Jika akun sudah diverifikasi
            if ($existingUser->email_verified_at) {
                return response()->json([
                    'message' => 'Email atau nomor telepon sudah terdaftar dan terverifikasi.'
                ], 400);
            }

            // Jika belum diverifikasi, update datanya
            $existingUser->update([
                'name' => $validated['name'],
                'no_telp' => $validated['no_telp'],
                'password' => bcrypt($validated['password']),
                'role' => $validated['role'],
                'verification_code' => $code,
                'verification_code_expires_at' => now()->addMinutes(10),
            ]);

            $user = $existingUser;
        } else {
            // Jika belum ada user sama sekali, buat baru
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'no_telp' => $validated['no_telp'],
                'password' => bcrypt($validated['password']),
                'role' => $validated['role'],
                'verification_code' => $code,
                'verification_code_expires_at' => now()->addMinutes(10),
            ]);
        }

        // Kirim email verifikasi
        Mail::send('verify', [
            'user' => $user,
            'code' => $code,
            'verifyUrl' => $verifyUrl,
        ], function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Kode Verifikasi Akun Anda');
        });

        return response()->json([
            'message' => 'Registrasi berhasil. Silakan periksa email Anda untuk verifikasi akun.'
        ], 201);
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'code' => 'required|digits:6',
        ], [
            'email.required' => 'Email wajib diisi.',
            'code.required' => 'Kode verifikasi wajib diisi.',
            'code.digits' => 'Kode verifikasi harus 6 digit angka.',
        ]);

        $user = User::where('email', $request->email)
            ->where('verification_code', $request->code)
            ->first();

        if (!$user) {
            return response()->json(['message' => 'Kode verifikasi salah atau email tidak ditemukan.'], 400);
        }

        if (Carbon::now()->greaterThan($user->verification_code_expires_at)) {
            return response()->json(['message' => 'Kode verifikasi sudah kadaluarsa.'], 400);
        }
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

    public function resendCode(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
        ], [
            'email.required' => 'Email wajib diisi.',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Email tidak ditemukan.'], 404);
        }

        // Cegah spam: minimal 1 menit antar pengiriman
        if ($user->last_email_sent_at && Carbon::parse($user->last_email_sent_at)->diffInSeconds(now()) < 60) {
            $wait = 60 - Carbon::parse($user->last_email_sent_at)->diffInSeconds(now());
            return response()->json(['message' => "Tunggu $wait detik sebelum mengirim ulang kode."], 429);
        }

        // Buat kode baru
        $verificationCode = random_int(100000, 999999);

        $user->update([
            'verification_code' => $verificationCode,
            'verification_code_expires_at' => now()->addMinutes(10),
            'last_email_sent_at' => now(),
        ]);

        // Kirim email (contoh sederhana)
        Mail::raw("Kode verifikasi Anda adalah: $verificationCode", function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Kode Verifikasi Akun Anda');
        });

        return response()->json(['message' => 'Kode verifikasi baru telah dikirim ke email Anda.']);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:6',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json(['message' => 'Email atau password salah.'], 401);
        }

        if (is_null($user->email_verified_at)) {
            return response()->json(['message' => 'Email belum diverifikasi. Silakan verifikasi terlebih dahulu.'], 403);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil!',
            'user' => $user,
            'token' => $token,
            'role' => $user->role,
        ]);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Email tidak ditemukan.'], 404);
        }

        $resetCode = rand(100000, 999999);
        $user->update([
            'reset_code' => $resetCode,
            'reset_code_expires_at' => Carbon::now()->addMinutes(10),
        ]);

        Mail::raw("Kode reset password Anda adalah: $resetCode (berlaku 10 menit)", function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Kode Reset Password');
        });

        return response()->json(['message' => 'Kode reset password telah dikirim ke email Anda.']);
    }

    public function verifyResetCode(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'reset_code' => 'required|digits:6',
        ], [
            'email.required' => 'Email wajib diisi.',
            'reset_code.required' => 'Kode reset wajib diisi.',
            'reset_code.digits' => 'Kode reset harus 6 digit angka.',
        ]);

        $user = User::where('email', $request->email)
            ->where('reset_code', $request->reset_code)
            ->first();

        if (!$user) {
            return response()->json(['message' => 'Kode reset tidak valid.'], 400);
        }

        if (Carbon::now()->greaterThan($user->reset_code_expires_at)) {
            return response()->json(['message' => 'Kode reset telah kadaluarsa.'], 400);
        }

        return response()->json(['message' => 'Kode reset valid.']);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'reset_code' => 'required|digits:6',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'email.required' => 'Email wajib diisi.',
            'reset_code.required' => 'Kode reset wajib diisi.',
            'reset_code.digits' => 'Kode reset harus 6 digit angka.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::where('email', $request->email)
            ->where('reset_code', $request->reset_code)
            ->first();

        if (!$user) {
            return response()->json(['message' => 'Kode reset tidak valid.'], 400);
        }

        if (Carbon::now()->greaterThan($user->reset_code_expires_at)) {
            return response()->json(['message' => 'Kode reset telah kadaluarsa.'], 400);
        }

        $user->update([
            'password' => Hash::make($request->password),
            'reset_code' => null,
            'reset_code_expires_at' => null,
        ]);

        return response()->json(['message' => 'Password berhasil direset.']);
    }
}
