<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PartRequest extends FormRequest
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
            'name' => 'required|string|max:150',
            'base_price' => 'required|numeric|min:0',
            'stock' => 'integer|min:0',
            'description' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama suku cadang wajib diisi.',
            'name.string' => 'Nama suku cadang harus berupa teks.',
            'name.max' => 'Nama suku cadang maksimal 150 karakter.',
            'base_price.required' => 'Harga dasar wajib diisi.',
            'base_price.numeric' => 'Harga dasar harus berupa angka.',
            'base_price.min' => 'Harga dasar tidak boleh negatif.',
            // 'stock.required' => 'Stok tersedia wajib diisi.',
            'stock.integer' => 'Stok tersedia harus berupa angka bulat.',
            'stock.min' => 'Stok tersedia tidak boleh negatif.',
            'description.string' => 'Deskripsi harus berupa teks.',
        ];
    }
}
