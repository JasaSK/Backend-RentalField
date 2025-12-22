<?php

namespace App\Http\Requests\Banner;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:active,non-active',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Judul banner wajib diisi.',
            'name.string' => 'Judul banner harus berupa teks.',
            'name.max' => 'Judul banner maksimal 255 karakter.',

            'description.required' => 'Deskripsi banner wajib diisi.',
            'description.string' => 'Deskripsi banner harus berupa teks.',

            'status.required' => 'Status banner wajib diisi.',
            'status.in' => 'Status banner harus "active" atau "non-active".',

            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpg, jpeg, atau png.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
        ];
    }
}
