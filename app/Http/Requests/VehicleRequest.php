<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'nopol' => ['required', 'string', 'max:20', Rule::unique('vehicles', 'nopol')->ignore($this->route('vehicle'))],
            'type' => ['required', 'string', 'max:100'],
            'category' => ['required', 'in:Mobil,Truk,Bus,Sepeda Motor'],
            'year' => ['required', 'integer', 'min:1900', 'max:' . now()->year + 1],
            'unit_number' => ['required', 'string', 'max:50'],
            'truck_size' => ['nullable', 'in:20 FEET,40 FEET,40 SLEDING'],
            'stnk_owner' => ['nullable', 'string', 'max:100'],
            'tax_due_date' => ['nullable', 'date'],
            'stnk_due_date' => ['nullable', 'date'],
            'kir_head_number' => ['nullable', 'string', 'max:50'],
            'kir_head_due_date' => ['nullable', 'date'],
            'kir_trailer_number' => ['nullable', 'string', 'max:50'],
            'kir_trailer_due_date' => ['nullable', 'date'],
            'driver_name' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string'],
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
            'truck_size.in' => 'Ukuran Truk harus dipilih dari: 20 Feet atau 40 Feet',
            'stnk_owner.max' => 'Nama Pemilik di STNK maksimal 100 karakter',
            'tax_due_date.date' => 'Format Jatuh Tempo Pajak tidak valid',
            'stnk_due_date.date' => 'Format Jatuh Tempo STNK tidak valid',
            'kir_head_number.max' => 'Nomor KIR Kepala maksimal 50 karakter',
            'kir_head_due_date.date' => 'Format Jatuh Tempo KIR Kepala tidak valid',
            'kir_trailer_number.max' => 'Nomor KIR Kereta maksimal 50 karakter',
            'kir_trailer_due_date.date' => 'Format Jatuh Tempo KIR Kereta tidak valid',
            'driver_name.max' => 'Nama Supir maksimal 100 karakter',
        ];
    }
}
