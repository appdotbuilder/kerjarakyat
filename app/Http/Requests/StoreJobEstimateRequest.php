<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJobEstimateRequest extends FormRequest
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
            'job_request_id' => 'required|exists:job_requests,id',
            'estimated_days' => 'required|integer|min:1|max:365',
            'estimated_hours' => 'nullable|integer|min:1|max:24',
            'estimated_start_date' => 'required|date|after:today',
            'estimated_completion_date' => 'required|date|after:estimated_start_date',
            'notes' => 'nullable|string|max:1000',
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
            'job_request_id.required' => 'ID pekerjaan harus ada.',
            'job_request_id.exists' => 'Pekerjaan tidak ditemukan.',
            'estimated_days.required' => 'Estimasi hari kerja harus diisi.',
            'estimated_days.min' => 'Estimasi hari kerja minimal 1 hari.',
            'estimated_start_date.required' => 'Tanggal mulai estimasi harus diisi.',
            'estimated_start_date.after' => 'Tanggal mulai harus setelah hari ini.',
            'estimated_completion_date.required' => 'Tanggal selesai estimasi harus diisi.',
            'estimated_completion_date.after' => 'Tanggal selesai harus setelah tanggal mulai.',
        ];
    }
}