<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDataPelatihanRequest extends FormRequest
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
            'kode' => 'required|string|max:255|unique:data_pelatihans,kode',
            'rumpun' => 'required|string|max:255',
            'nama_pelatihan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'jp' => 'required|numeric',
            'materi' => 'nullable|string',
            'nasional_klasikal_min' => 'nullable|string',
            'nasional_klasikal_maks' => 'nullable|string',
            'nasional_non-klasikal_min' => 'nullable|string',
            'nasional_non-klasikal_maks' => 'nullable|string',
            'internasional_klasikal_min' => 'nullable|string',
            'internasional_klasikal_maks' => 'nullable|string',
            'internasional_non-klasikal_min' => 'nullable|string',
            'internasional_non-klasikal_maks' => 'nullable|string',
        ];
    }
}
