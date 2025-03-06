<?php

namespace App\Http\Requests;

use App\Models\Jenjang;
use App\Models\AnggaranPelatihan;
use App\Models\AnggaranPendidikan;
use Illuminate\Foundation\Http\FormRequest;

class StoreRencanaPembelajaranRequest extends FormRequest
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
            'tahun' => 'required|integer|max:2099',
            'klasifikasi' => 'required|in:pendidikan,pelatihan',
            'kategori' => 'required_if:klasifikasi,pelatihan|exists:kategoris,id',
            'bentuk_jalur' => 'required_if:klasifikasi,pelatihan|exists:bentuk_jalurs,id',
            'jenjang' => 'required_if:klasifikasi,pendidikan|exists:jenjangs,id',
            'rumpun' => 'required_if:klasifikasi,pelatihan|exists:rumpuns,id',
            'jurusan' => 'required_if:klasifikasi,pendidikan',
            'jenis_pendidikan' => 'required_if:klasifikasi,pendidikan|exists:jenis_pendidikans,id',
            'nama_pelatihan' => 'required_if:klasifikasi,pelatihan|exists:data_pelatihans,id',
            'tahun' => 'required|digits:4',
            'jam_pelajaran' => 'required',
            'anggaran_rencana' => ['required', 'integer', $this->validateAnggaran()],
            'regional' => 'required|exists:regions,id',
            'prioritas' => 'required|in:rendah,sedang,tinggi',
            ];
            // Validasi anggaran_rencana untuk pelatihan

        return $rules;
    }

    protected function validateAnggaran()
    {
        return function ($attribute, $value, $fail) {
            if ($this->klasifikasi == 'pelatihan') {
                // Validasi untuk pelatihan
                $anggaran = AnggaranPelatihan::where('data_pelatihan_id', $this->nama_pelatihan)
                    ->where('kategori_id', $this->kategori)
                    ->where('region_id', $this->regional)
                    ->first();
    
                if ($anggaran) {
                    if ($value < $anggaran->anggaran_min || $value > $anggaran->anggaran_maks) {
                        $fail("Anggaran harus berada di antara Rp " . number_format($anggaran->anggaran_min, 0, ',', '.') . " dan Rp " . number_format($anggaran->anggaran_maks, 0, ',', '.') . ".");
                    }
                } else {
                    $fail('Anggaran untuk pelatihan dengan kategori dan region yang dipilih tidak ditemukan.');
                }
            }
    
            if ($this->klasifikasi == 'pendidikan') {
                // Validasi untuk pendidikan
                $jenjang = Jenjang::find($this->jenjang);
                if (in_array($jenjang->jenjang, ['D1', 'D2', 'D3'])) {
                    // Jika jenjang D1, D2, atau D3, abaikan validasi anggaran
                    return;
                }
    
                $anggaran = AnggaranPendidikan::where('jenjang_id', $this->jenjang)
                    ->where('region_id', $this->regional)
                    ->first();
    
                if ($anggaran) {
                    if ($value < $anggaran->anggaran_min || $value > $anggaran->anggaran_maks) {
                        $fail("Anggaran harus berada di antara Rp" . number_format($anggaran->anggaran_min, 0, ',', '.') . " dan Rp" . number_format($anggaran->anggaran_maks, 0, ',', '.') . ".");
                    }
                } else {
                    $fail('Anggaran untuk pendidikan dengan jenjang dan region yang dipilih tidak ditemukan.');
                }
            }
        };
    }

    

    public function messages()
    {
        return [
            'anggaran_rencana.required' => 'Anggaran rencana harus diisi.',
            'anggaran_rencana.integer' => 'Anggaran rencana harus berupa angka.',
            'prioritas.required' => 'Prioritas harus diisi.',
            'prioritas.in' => 'Prioritas harus salah satu dari rendah, sedang, atau tinggi.',
            // Tambahkan pesan lainnya sesuai kebutuhan
        ];
    }

}
