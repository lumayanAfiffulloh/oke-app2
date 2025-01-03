<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDataPelatihanRequest extends FormRequest
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
            'kode' => 'nullable|string|max:255',
            'rumpun' => 'nullable|string|max:255',
            'nama_pelatihan' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'jp' => 'nullable|numeric',
            'materi' => 'nullable|string',
            'estimasi.*.anggaran_min' => 'nullable|numeric|min:0',
            'estimasi.*.anggaran_maks' => 'nullable|numeric|min:0',
        ];
    }
}
