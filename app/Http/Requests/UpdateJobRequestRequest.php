<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJobRequestRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'skill_category_id' => 'required|exists:skill_categories,id',
            'location_address' => 'required|string|max:500',
            'location_latitude' => 'nullable|numeric|between:-90,90',
            'location_longitude' => 'nullable|numeric|between:-180,180',
            'preferred_start_date' => 'required|date',
            'estimated_duration_days' => 'required|integer|min:1|max:365',
            'estimated_duration_hours' => 'nullable|integer|min:1|max:24',
            'urgency' => 'required|in:low,medium,high',
            'client_notes' => 'nullable|string|max:1000',
            'status' => 'nullable|in:open,survey_requested,survey_scheduled,estimated,approved,in_progress,completed,cancelled',
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
            'title.required' => 'Judul pekerjaan harus diisi.',
            'description.required' => 'Deskripsi pekerjaan harus diisi.',
            'skill_category_id.required' => 'Kategori keahlian harus dipilih.',
            'skill_category_id.exists' => 'Kategori keahlian tidak valid.',
            'location_address.required' => 'Alamat lengkap harus diisi.',
            'preferred_start_date.required' => 'Tanggal mulai yang diinginkan harus diisi.',
            'estimated_duration_days.required' => 'Estimasi durasi pekerjaan harus diisi.',
            'estimated_duration_days.min' => 'Durasi pekerjaan minimal 1 hari.',
            'urgency.required' => 'Tingkat urgensi harus dipilih.',
        ];
    }
}