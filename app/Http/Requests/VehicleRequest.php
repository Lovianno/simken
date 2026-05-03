<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VehicleRequest extends FormRequest
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
            'nopol' => ['required', 'string', 'max:20', 'unique:vehicles,nopol'],
            'type' => ['required', 'string', 'max:100'],
            'category' => ['required', 'in:Mobil,Truk,Bus,Sepeda Motor'],
            'year' => ['required', 'integer', 'min:1900', 'max:' . now()->year + 1],
            'unit_number' => ['required', 'string', 'max:50'],
        ];
    }

    public function messages(): array
    {
        return [
            'nopol.required' => 'Nomor Polisi harus diisi',
            'nopol.unique' => 'Nomor Polisi sudah terdaftar',
            'type.required' => 'Jenis/Tipe Kendaraan harus diisi',
            'category.required' => 'Kategori Kendaraan harus diisi',
            'category.enum' => 'Kategori Kendaraan tidak valid',
            'year.required' => 'Tahun Kendaraan harus diisi',
            'unit_number.required' => 'Nomor Unit harus diisi',
            // 'unit_number.unique' => 'Nomor Unit sudah terdaftar',
        ];
    }
}
