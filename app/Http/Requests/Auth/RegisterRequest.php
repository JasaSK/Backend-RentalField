<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'no_telp'  => 'required|string|min:10|max:15|unique:users',
            'password' => 'required|min:6|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
          'name.required' => 'Nama wajib diisi.',
          'name.max' => 'Nama maksimal 255 karakter.',
          'email.required' => 'Email wajib diisi.',
          'email.email' => 'Format email tidak valid.',
          'email.unique' => 'Email sudah terdaftar.',
          'no_telp.unique' => 'Nomor telepon sudah terdaftar.',
          'no_telp.required' => 'Nomor telepon wajib diisi.',
          'no_telp.min' => 'Nomor telepon minimal 10 karakter.',
          'no_telp.max' => 'Nomor telepon maksimal 15 karakter.',
          'password.required' => 'Password wajib diisi.',
          'password.min' => 'Password minimal 6 karakter.',
          'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ];
    }
}
