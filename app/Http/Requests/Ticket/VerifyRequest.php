<?php

namespace App\Http\Requests\Ticket;

use Illuminate\Foundation\Http\FormRequest;

class VerifyRequest extends FormRequest
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
            'ticket_code'  => 'required|string|exists:ticket,ticket_code',
        ];
    }

    public function messages(): array
    {
        return [
            'ticket_code.required' => 'Kode tiket wajib diisi.',
            'ticket_code.string' => 'Format kode tiket tidak valid.',
            'ticket_code.exists' => 'Kode tiket tidak ditemukan.',
        ];
    }
}
