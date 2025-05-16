<?php

namespace App\Http\Requests;

use App\Models\DataPegawai;
use Illuminate\Foundation\Http\FormRequest;

class StoreKelompokRequest extends FormRequest
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
            'id_ketua' => 'required|exists:data_pegawais,id',
            'anggota' => 'required|array|max:19',
            'anggota.*' => 'exists:data_pegawais,id|distinct',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $anggota = $this->input('anggota');
            $unitKerjaKetua = DataPegawai::find($this->input('id_ketua'))->unit_kerja_id;
            $unitKerjaAnggota = DataPegawai::whereIn('id', $anggota)->pluck('unit_kerja_id')->unique();

            if ($unitKerjaAnggota->count() > 1 || $unitKerjaAnggota->first() != $unitKerjaKetua) {
                $validator->errors()->add('id_ketua', 'Ketua kelompok dan semua anggota harus memiliki unit kerja yang sama.');
            }

            // Validasi tambahan untuk memastikan ketua tidak ada di dalam anggota
            if (in_array($this->input('id_ketua'), $anggota)) {
                $validator->errors()->add('anggota', 'Ketua kelompok tidak bisa dimasukkan sebagai anggota.');
            }
        });
    }
}
