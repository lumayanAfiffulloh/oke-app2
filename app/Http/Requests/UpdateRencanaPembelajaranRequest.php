<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRencanaPembelajaranRequest extends FormRequest
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
        'tahun' => 'required|integer|min:2024|max:2099',
        'klasifikasi' => 'required|string',
        'kategori_klasifikasi' => 'required|string',
        'kategori' => 'required|string',
        'bentuk_jalur' => 'required|string',
        'nama_pelatihan' => 'required|string|max:255',
        'jam_pelajaran' => 'required|integer|min:1|max:50',
        'regional' => 'required|string',
        'anggaran' => 'required|integer|min:0',
        'prioritas' => 'required|string',
        ];
    }
}
