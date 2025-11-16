<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        $validatedData = $request->validate(
            [
                'name' => 'sometimes|required|string|max:255',
                'email' => 'sometimes|required|email|unique:users,email,' . $id,
                'password' => 'sometimes|required|string|min:6|confirmed',
            ],
            [
                'name.required' => 'Nama Wajib Diisi.',
                'name.string' => 'Nama Harus Berupa Teks.',
                'name.max' => 'Nama Maksimal 255 Karakter.',

                'email.required' => 'Email Wajib Diisi.',
                'email.email' => 'Email Tidak Valid.',
                'email.unique' => 'Email Sudah Digunakan.',

                'password.required' => 'Password Wajib Diisi.',
                'password.string' => 'Password Harus Berupa Teks.',
                'password.min' => 'Password Minimal 6 Karakter.',
                'password.confirmed' => 'Konfirmasi Password Tidak Sesuai.',
            ]
        );

        if ($request->has('password')) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        }
        $user->update($validatedData);

        return response()->json([
            'status' => true,
            'message' => 'User updated successfully',
            'user' => $user
        ], 200);
    }
}
