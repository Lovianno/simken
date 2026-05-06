<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportRequest extends FormRequest
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
            'vehicle_id' => ['required', 'exists:vehicles,id'],
            'date' => ['required', 'date'],

            'issues' => ['required', 'array', 'min:1'],
            'issues.*.issue_description' => ['required', 'string'],

            'issues.*.items' => ['required', 'array', 'min:1'],
            'issues.*.items.*.part_id' => ['required', 'exists:parts,id'],
            'issues.*.items.*.quantity' => ['required', 'integer', 'min:1'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'vehicle_id.required' => 'Kendaraan harus dipilih.',
            'vehicle_id.exists' => 'Kendaraan yang dipilih tidak valid.',
            'date.required' => 'Tanggal laporan harus diisi.',
            'date.date' => 'Format tanggal tidak valid.',
            
            'issues.required' => 'Minimal harus ada 1 kerusakan.',
            'issues.array' => 'Data kerusakan harus berupa array.',
            'issues.min' => 'Minimal harus ada 1 kerusakan.',
            
            'issues.*.issue_description.required' => 'Deskripsi kerusakan harus diisi.',
            'issues.*.issue_description.string' => 'Deskripsi kerusakan harus berupa teks.',
            
            'issues.*.items.required' => 'Minimal harus ada 1 suku cadang untuk kerusakan ini.',
            'issues.*.items.array' => 'Data suku cadang harus berupa array.',
            'issues.*.items.min' => 'Minimal harus ada 1 suku cadang untuk kerusakan ini.',
            
            'issues.*.items.*.part_id.required' => 'Suku cadang harus dipilih.',
            'issues.*.items.*.part_id.exists' => 'Suku cadang yang dipilih tidak valid.',
            
            'issues.*.items.*.quantity.required' => 'Wajib diisi.',
            'issues.*.items.*.quantity.integer' => 'Jumlah harus angka.',
            'issues.*.items.*.quantity.min' => 'Jumlah min. 1.',
        ];
    }
}
