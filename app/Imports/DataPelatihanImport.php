<?php

namespace App\Imports;

use App\Models\Rumpun;
use App\Models\Kategori;
use App\Models\Region;
use App\Models\DataPelatihan;
use App\Models\AnggaranPelatihan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DataPelatihanImport implements ToModel, WithHeadingRow, WithStartRow
{
  public function startRow(): int
  {
    return 2;
  }

  public function model(array $row)
  {
    $rumpun = Rumpun::firstOrCreate(['rumpun' => $row['rumpun']]);
    $pelatihan = DataPelatihan::updateOrCreate(
      ['kode' => $row['kode']],
      [
        'rumpun_id' => $rumpun->id,
        'nama_pelatihan' => $row['nama_pelatihan'],
        'deskripsi' => $row['deskripsi_pelatihan'] ?? null,
        'jp' => $row['jp'],
        'materi' => $row['materi_pelatihan'] ?? null,
      ]
    );

    $this->importEstimasiHarga($pelatihan->id, $row);
    return $pelatihan;
  }

  private function importEstimasiHarga($pelatihanId, $row)
  {
    $categories = [
      'klasikal' => 'klasikal',
      'non_klasikal' => 'non-klasikal',
    ];

    foreach (['nasional', 'internasional'] as $regionName) {
      $region = Region::firstOrCreate(['region' => $regionName]);

      foreach ($categories as $key => $kategoriName) {
        $minKey = "{$regionName}_{$key}_min";
        $maxKey = "{$regionName}_{$key}_max";

        if (isset($row[$minKey], $row[$maxKey])) {
          $kategori = Kategori::firstOrCreate(['kategori' => $kategoriName]);

          AnggaranPelatihan::updateOrCreate(
            [
              'data_pelatihan_id' => $pelatihanId,
              'region_id' => $region->id,
              'kategori_id' => $kategori->id,
            ],
            [
              'anggaran_min' => $this->parseNumber($row[$minKey]),
              'anggaran_maks' => $this->parseNumber($row[$maxKey]),
            ]
          );
        }
      }
    }
  }

  private function parseNumber($value)
  {
    return is_numeric(str_replace('.', '', $value)) ? (int) str_replace('.', '', $value) : 0;
  }
}
