<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
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
    public function rules()
    {
        return [
            'kode' => 'required|string',
            'rumpun_id' => 'required|exists:rumpuns,id',
            'nama_pelatihan' => 'required|string',
            'deskripsi' => 'nullable|string',
            'jp' => 'required|integer|min:1',
            'materi' => 'nullable|string',
            'anggaran.*.anggaran_min' => 'required|integer|min:0',
            'anggaran.*.anggaran_maks' => 'required|integer|min:0|gte:anggaran.*.anggaran_min',
        ];
    }

    public function messages()
    {
        return [
            'kode.required' => 'Kode pelatihan wajib diisi.',
            'kode.unique' => 'Kode pelatihan harus unik.',
            'rumpun_id.required' => 'Rumpun wajib dipilih.',
            'rumpun_id.exists' => 'Rumpun yang dipilih tidak valid.',
            'nama_pelatihan.required' => 'Nama pelatihan wajib diisi.',
            'jp.required' => 'Jumlah jam pelajaran wajib diisi.',
            'jp.integer' => 'Jumlah jam pelajaran harus berupa angka.',
            'anggaran.*.anggaran_min.required' => 'Anggaran minimum wajib diisi.',
            'anggaran.*.anggaran_max.required' => 'Anggaran maksimum wajib diisi.',
            'anggaran.*.anggaran_maks.gte' => 'Anggaran maksimum harus lebih besar atau sama dengan anggaran minimum.',
        ];
    }
}
