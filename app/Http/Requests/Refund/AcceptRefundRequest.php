<?php

namespace App\Http\Requests\Refund;

use Illuminate\Foundation\Http\FormRequest;

class AcceptRefundRequest extends FormRequest
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
            'refund_amount' => 'required|integer',
            'proof' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'refund_amount.required' => 'Jumlah refund wajib diisi.',
            'refund_amount.integer' => 'Jumlah refund harus berupa angka.',
            'proof.required' => 'Bukti wajib diisi.',
            'proof.image' => 'Bukti harus berupa gambar.',
            'proof.mimes' => 'Format gambar harus JPG, JPEG, atau PNG.',
            'proof.max' => 'Ukuran gambar maksimal 2MB.',
        ];
    }
}
