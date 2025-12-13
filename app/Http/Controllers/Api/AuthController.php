<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'no_telp' => 'required|string|min:10|max:15|unique:users,no_telp',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'no_telp.unique' => 'Nomor telepon sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'no_telp' => $validated['no_telp'],
            'password' => bcrypt($validated['password']),
            'role' => 'user',
        ]);

        $code = random_int(100000, 999999);

        $user->emailVerification()->create([
            'verification_code' => $code,
            'expires_at' => now()->addMinutes(10),
        ]);

        Mail::send('verify', [
            'user' => $user,
            'code' => $code,
            'verifyUrl' => url('/verify/' . $code),
            'emailMessage' => "Kode verifikasi Anda adalah: ",
            'emailSubject' => "Kode Verifikasi Akun Anda",
        ], function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Kode Verifikasi Akun Anda');
        });

        return response()->json([
            'status' => true,
            'message' => 'Registrasi berhasil. Silakan cek email untuk verifikasi.',
            'data' => $user
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

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Email atau kode verifikasi tidak valid.'
            ], 400);
        }

        if ($user->email_verified_at) {
            return response()->json([
                'status' => false,
                'message' => 'Email sudah terverifikasi.'
            ], 400);
        }

        $verification = $user->emailVerification;
        if (!$verification) {
            return response()->json([
                'status' => false,
                'message' => 'Data verifikasi tidak ditemukan.'
            ], 404);
        }

        if ($verification->verification_code !== $request->code) {
            return response()->json([
                'status' => false,
                'message' => 'Kode verifikasi salah.'
            ], 400);
        }


        if (Carbon::now()->greaterThan($verification->expires_at)) {
            return response()->json([
                'status' => false,
                'message' => 'Kode verifikasi sudah kadaluarsa.'
            ], 400);
        }

        $user->update([
            'email_verified_at' => now(),
        ]);
        $verification->update([
            'verification_code' => null,
            'expires_at' => null,
            'last_sent_at' => null,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Email berhasil diverifikasi!',
            'data' => $user,
        ], 200);
    }

    public function resendCode(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Email tidak ditemukan.'
            ], 404);
        }

        if ($user->email_verified_at) {
            return response()->json([
                'status' => false,
                'message' => 'Email sudah terverifikasi.'
            ], 400);
        }

        $verification = $user->emailVerification;

        if (!$verification) {
            return response()->json([
                'status' => false,
                'message' => 'Data verifikasi tidak ditemukan.'
            ], 404);
        }

        if (
            $verification->last_sent_at &&
            $verification->last_sent_at->diffInSeconds(now()) < 60
        ) {

            $wait = 60 - $verification->last_sent_at->diffInSeconds(now());
            return response()->json([
                'status' => false,
                'message' => "Tunggu $wait detik sebelum mengirim ulang kode."
            ], 429);
        }


        $newCode = random_int(100000, 999999);

        $verification->update([
            'verification_code' => $newCode,
            'expires_at' => now()->addMinutes(10),
            'last_sent_at' => now(),
        ]);

        Mail::send('verify', [
            'user' => $user,
            'code' => $newCode,
            'verifyUrl' => url('/verify/' . $newCode),
            'emailMessage' => 'Kode verifikasi Baru Anda adalah:',
            'emailSubject' => "Kode Verifikasi Baru Akun Anda",
        ], function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Kode Verifikasi Baru Akun Anda');
        });

        return response()->json([
            'status' => true,
            'message' => 'Kode verifikasi baru telah dikirim ke email Anda.'
        ], 200);
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
            return response()->json([
                'status' => false,
                'message' => 'Email atau password salah.'
            ], 401);
        }

        if (is_null($user->email_verified_at)) {
            return response()->json([
                'status' => false,
                'message' => 'Email belum diverifikasi. Silakan verifikasi terlebih dahulu.'
            ], 403);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Login berhasil!',
            'data' => $user,
            'token' => $token,
            'role' => $user->role,
        ], 200);
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
            return response()->json([
                'status' => false,
                'message' => 'Email tidak ditemukan.'
            ], 404);
        }

        $reset = $user->passwordReset;

        if ($reset && $reset->last_sent_at && $reset->last_sent_at->diffInSeconds(now()) < 60) {
            $wait = 60 - $reset->last_sent_at->diffInSeconds(now());
            return response()->json([
                'status' => false,
                'message' => "Tunggu $wait detik sebelum mengirim ulang kode reset."
            ], 429);
        }

        $resetCode = rand(100000, 999999);

        $user->passwordReset()->updateOrCreate(
            ['user_id' => $user->id], // kondisi untuk mencari record
            [
                'reset_code' => $resetCode,
                'expires_at' => now()->addMinutes(10),
                'last_sent_at' => now(),
            ]
        );

        Mail::send('verify', [
            'user' => $user,
            'code' => $resetCode,
            'verifyUrl' => url('/verify/' . $resetCode),
            'emailMessage' => 'Berikut kode reset password Anda: ',
            'emailSubject' => 'Kode Reset Password Anda',
        ], function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Kode Reset Password Anda');
        });


        return response()->json([
            'status' => true,
            'message' => 'Kode reset password telah dikirim ke email Anda.',
            'data' => $user,
        ], 200);
    }

    public function verifyResetCode(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'email' => 'required|string|email',
            'reset_code' => 'required|digits:6',
        ], [
            'email.required' => 'Email wajib diisi.',
            'reset_code.required' => 'Kode reset wajib diisi.',
            'reset_code.digits' => 'Kode reset harus 6 digit angka.',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Kode reset tidak valid. atau email tidak ditemukan.'
            ], 400);
        }

        if (!$user->email_verified_at) {
            return response()->json([
                'status' => false,
                'message' => 'Email belum diverifikasi. Silakan verifikasi terlebih dahulu.'
            ]);
        }

        $resetVerification = $user->passwordReset;
        if (!$resetVerification) {
            return response()->json([
                'status' => false,
                'message' => 'Kode reset tidak ditemukan.'
            ]);
        }
        if (Carbon::now()->greaterThan($resetVerification->expires_at)) {
            return response()->json([
                'status' => false,
                'message' => 'Kode reset telah kadaluarsa.'
            ], 400);
        }
        if ($resetVerification->reset_code != $request->reset_code) {
            return response()->json([
                'status' => false,
                'message' => 'Kode reset tidak valid.'
            ], 400);
        }

        // $resetVerification->update([
        //     'last_sent_at' => null,
        // ]);

        return response()->json([
            'status' => true,
            'message' => 'Kode reset valid.',
            'data' => $user,
        ], 200);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'reset_code' => 'required|digits:6',
            'password' => 'required|string|min:6|confirmed', // harus ada password_confirmation
        ], [
            'email.required' => 'Email wajib diisi.',
            'reset_code.required' => 'Kode reset wajib diisi.',
            'reset_code.digits' => 'Kode reset harus 6 digit angka.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Email tidak ditemukan.'
            ], 404);
        }

        $resetVerification = $user->passwordReset;
        if (!$resetVerification) {
            return response()->json([
                'status' => false,
                'message' => 'Kode reset tidak ditemukan.'
            ], 404);
        }

        if (!$resetVerification->expires_at || now()->greaterThan($resetVerification->expires_at)) {
            return response()->json([
                'status' => false,
                'message' => 'Kode reset telah kadaluarsa.'
            ], 400);
        }

        if ($resetVerification->reset_code != $request->reset_code) {
            return response()->json([
                'status' => false,
                'message' => 'Kode reset tidak valid.'
            ], 400);
        }

        $user->update([
            'password' => bcrypt($request->password),
        ]);

        $resetVerification->update([
            'reset_code' => null,
            'expires_at' => null,
            'last_sent_at' => null,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Password berhasil diubah.',
        ], 200);
    }
}
