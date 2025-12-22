<?php

namespace App\Http\Requests\Field;

use Illuminate\Foundation\Http\FormRequest;

class FieldRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'category_field_id' => 'required|integer|exists:category_fields,id',
            'open_time' => 'required|',
            'close_time' => 'required|after:open_time',
            'description' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'price_per_hour' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama maksimal 255 karakter.',

            'category_field_id.required' => 'Kategori lapangan wajib diisi.',
            'category_field_id.exists' => 'Kategori lapangan tidak ditemukan.',

            'open_time.required' => 'Jam buka wajib diisi.',
            'open_time.date_format' => 'Format jam buka harus HH:mm.',

            'close_time.required' => 'Jam tutup wajib diisi.',
            'close_time.date_format' => 'Format jam tutup harus HH:mm.',
            'close_time.after' => 'Jam tutup harus setelah jam buka.',

            'description.required' => 'Deskripsi wajib diisi.',
            'description.string' => 'Deskripsi harus berupa teks.',

            'status.required' => 'Status wajib diisi.',
            'status.in' => 'Status harus "active" atau "non-active".',

            'price_per_hour.required' => 'Harga per jam wajib diisi.',
            'price_per_hour.numeric' => 'Harga per jam harus berupa angka.',
            'price_per_hour.min' => 'Harga per jam minimal 0.',

            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpg, jpeg, atau png.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
        ];
    }
}
