<?php

namespace App\Http\Requests\Refund;

use Illuminate\Foundation\Http\FormRequest;

class RefundRequest extends FormRequest
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
            'user_id'       => 'required|integer|exists:users,id',
            'booking_id'    => 'required|integer|exists:bookings,id',
            'amount_paid'   => 'required|integer',
            'reason'        => 'required|string',
            'refund_method' => 'nullable|string',
            'account_number' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'Pengguna wajib diisi.',
            'user_id.integer' => 'Pengguna harus berupa angka.',
            'user_id.exists' => 'Pengguna tidak ditemukan.',

            'booking_id.required' => 'Booking wajib diisi.',
            'booking_id.integer' => 'Booking harus berupa angka.',
            'booking_id.exists' => 'Booking tidak ditemukan.',

            'amount_paid.required' => 'Jumlah yang dibayar wajib diisi.',
            'amount_paid.integer' => 'Jumlah yang dibayar harus berupa angka.',

            'reason.required' => 'Alasan wajib diisi.',
            'reason.string' => 'Alasan harus berupa teks.',

            'refund_method.string' => 'Metode refund harus berupa teks.',

            'account_number.string' => 'Nomor rekening harus berupa teks.',
        ];
    }
}
