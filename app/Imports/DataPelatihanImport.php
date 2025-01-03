<?php

namespace App\Imports;

use App\Models\DataPelatihan;
use App\Models\EstimasiHarga;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class DataPelatihanImport implements ToModel, WithHeadingRow, WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        // Debug data untuk memastikan file terbaca
        // dd($row);

        $pelatihan = DataPelatihan::updateOrCreate(
            ['kode' => $row['kode']],
            [
                'rumpun' => $row['rumpun'],
                'nama_pelatihan' => $row['nama_pelatihan'],
                'deskripsi' => $row['deskripsi_pelatihan'],
                'jp' => $row['jp'],
                'materi' => $row['materi_pelatihan'],
            ]
        );

        $this->importEstimasiHarga($pelatihan->id, $row);
        return $pelatihan;
    }

    private function importEstimasiHarga($pelatihanId, $row)
    {
        if (isset($row['nasional_non_klasikal_min'], $row['nasional_non_klasikal_max'])) {
            EstimasiHarga::updateOrCreate(
                ['pelatihan_id' => $pelatihanId, 'region' => 'nasional', 'kategori' => 'non-klasikal'],
                [
                    'anggaran_min' => $this->parseNumber($row['nasional_non_klasikal_min']),
                    'anggaran_maks' => $this->parseNumber($row['nasional_non_klasikal_max']),
                ]
            );
        }

        if (isset($row['nasional_klasikal_min'], $row['nasional_klasikal_max'])) {
            EstimasiHarga::updateOrCreate(
                ['pelatihan_id' => $pelatihanId, 'region' => 'nasional', 'kategori' => 'klasikal'],
                [
                    'anggaran_min' => $this->parseNumber($row['nasional_klasikal_min']),
                    'anggaran_maks' => $this->parseNumber($row['nasional_klasikal_max']),
                ]
            );
        }

        if (isset($row['internasional_non_klasikal_min'], $row['internasional_non_klasikal_max'])) {
            EstimasiHarga::updateOrCreate(
                ['pelatihan_id' => $pelatihanId, 'region' => 'internasional', 'kategori' => 'non-klasikal'],
                [
                    'anggaran_min' => $this->parseNumber($row['internasional_non_klasikal_min']),
                    'anggaran_maks' => $this->parseNumber($row['internasional_non_klasikal_max']),
                ]
            );
        }

        if (isset($row['internasional_klasikal_min'], $row['internasional_klasikal_max'])) {
            EstimasiHarga::updateOrCreate(
                ['pelatihan_id' => $pelatihanId, 'region' => 'internasional', 'kategori' => 'klasikal'],
                [
                    'anggaran_min' => $this->parseNumber($row['internasional_klasikal_min']),
                    'anggaran_maks' => $this->parseNumber($row['internasional_klasikal_max']),
                ]
            );
        }
    }


    private function parseNumber($value)
    {
        return is_numeric(str_replace('.', '', $value)) ? (int) str_replace('.', '', $value) : 0;
    }
}
