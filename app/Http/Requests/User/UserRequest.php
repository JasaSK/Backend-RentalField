<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        $rules = [
            'name' => 'sometimes|nullable|string|max:255',
            'email' => 'sometimes|nullable|email|unique:users,email,' . $this->id,
            'no_telp' => 'sometimes|nullable|string|min:10|max:15|unique:users,no_telp,' . $this->id,
            'password' => 'sometimes|nullable|string|min:6|confirmed',
            'role' => 'required|in:admin,user',
        ];

        if (Auth::user()->role === 'superadmin') {
            $rules['role'] = 'required|in:superadmin,admin,user';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama maksimal 255 karakter.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',

            'no_telp.required' => 'Nomor telepon wajib diisi.',
            'no_telp.string' => 'Nomor telepon harus berupa teks.',
            'no_telp.min' => 'Nomor telepon minimal 10 karakter.',
            'no_telp.max' => 'Nomor telepon maksimal 15 karakter.',
            'no_telp.unique' => 'Nomor telepon sudah terdaftar.',

            'password.required' => 'Password wajib diisi.',
            'password.string' => 'Password harus berupa teks.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',

            'role.required' => 'Role wajib diisi.',
            'role.in' => 'Role harus "admin" atau "user".',
        ];
    }
}
