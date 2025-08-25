<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWorkerRequest extends FormRequest
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
        ];
    }
}