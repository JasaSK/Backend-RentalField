<?php

namespace App\Http\Requests\Maintence;

use Illuminate\Foundation\Http\FormRequest;

class MaintenceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        if ($this->start_time) {
            $this->merge([
                'start_time' => substr($this->start_time, 0, 5),
            ]);
        }

        if ($this->end_time) {
            $this->merge([
                'end_time' => substr($this->end_time, 0, 5),
            ]);
        }
    }
    public function rules(): array
    {
        return [
            'field_id' => 'required|exists:fields,id',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'reason' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'field_id.required' => 'Field wajib diisi.',
            'field_id.exists' => 'Field tidak ditemukan.',
            'date.required' => 'Tanggal wajib diisi.',
            'date.date' => 'Format tanggal tidak valid.',
            'start_time.required' => 'Waktu mulai wajib diisi.',
            'start_time.date_format' => 'Format waktu mulai tidak valid. Gunakan format HH:MM.',
            'end_time.required' => 'Waktu selesai wajib diisi.',
            'end_time.date_format' => 'Format waktu selesai tidak valid. Gunakan format HH:MM.',
            'end_time.after' => 'Waktu selesai harus setelah waktu mulai.',
            'reason.string' => 'Alasan harus berupa teks.',
        ];
    }
}
