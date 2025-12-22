<?php

namespace App\Http\Requests\Gallery;

use Illuminate\Foundation\Http\FormRequest;

class GalleryRequest extends FormRequest
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
            'category_gallery_id' => 'required|exists:category_galleries,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Judul gallery wajib diisi.',
            'name.string' => 'Judul gallery harus berupa teks.',
            'name.max' => 'Judul gallery maksimal 255 karakter.',

            'description.required' => 'Deskripsi gallery wajib diisi.',
            'description.string' => 'Deskripsi gallery harus berupa teks.',

            'category_gallery_id.required' => 'Kategori gallery wajib diisi.',
            'category_gallery_id.exists' => 'Kategori gallery tidak ditemukan.',

            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpg, jpeg, atau png.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
        ];
    }
}
