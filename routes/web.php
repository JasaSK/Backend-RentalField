<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use Carbon\Carbon;

Route::get('/verify/{code}', function ($code) {
    $user = User::where('verification_code', $code)->first();

    if (!$user) {
        return response()->json(['message' => 'Kode verifikasi tidak valid.'], 404);
    }

    if (Carbon::now()->greaterThan($user->verification_code_expires_at)) {
        return response()->json(['message' => 'Kode sudah kedaluwarsa.'], 400);
    }

    $user->update([
        'email_verified_at' => now(),
        'verification_code' => null,
        'verification_code_expires_at' => null,
    ]);

    return response()->json(['message' => 'Email berhasil diverifikasi!']);
});
