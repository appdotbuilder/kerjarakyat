<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWorkerRequest extends FormRequest
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
            'skill_category_id' => 'required|exists:skill_categories,id',
            'skill_level_id' => 'required|exists:skill_levels,id',
            'bio' => 'nullable|string|max:1000',
            'certification_number' => 'nullable|string|max:50',
            'certification_date' => 'nullable|date',
            'certification_expiry' => 'nullable|date|after:certification_date',
            'certification_status' => 'in:pending,scheduled,certified,expired',
            'is_available' => 'boolean',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'skill_category_id.required' => 'Kategori keahlian harus dipilih.',
            'skill_category_id.exists' => 'Kategori keahlian tidak valid.',
            'skill_level_id.required' => 'Level keahlian harus dipilih.',
            'skill_level_id.exists' => 'Level keahlian tidak valid.',
            'bio.max' => 'Bio tidak boleh lebih dari 1000 karakter.',
            'certification_expiry.after' => 'Tanggal kadaluarsa harus setelah tanggal sertifikasi.',
        ];
    }
}