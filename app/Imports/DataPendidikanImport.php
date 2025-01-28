<?php

namespace App\Imports;

use App\Models\Jurusan;
use App\Models\Jenjang;
use App\Models\DataPendidikan;
use App\Models\PendidikanHasJenjang;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DataPendidikanImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Cari atau buat data pendidikan
        $dataPendidikan = DataPendidikan::firstOrCreate([
            'jurusan' => $row['jurusan'], // Kolom JURUSAN
        ]);

        // Array jenjang untuk dipetakan ke kolom Excel
        $jenjangColumns = [
            's1' => 'S1',
            's2' => 'S2',
            's3' => 'S3',
        ];

        // Iterasi setiap jenjang (S1, S2, S3)
        foreach ($jenjangColumns as $jenjangColumn => $jenjangName) {
            // Cek ketersediaan jenjang (√ untuk tersedia, - untuk tidak ada)
            $status = trim($row[$jenjangColumn]);

            if ($status === '√') {
                // Cari atau buat jenjang
                $jenjang = Jenjang::firstOrCreate([
                    'jenjang' => $jenjangName,
                ]);

                // Pastikan tidak ada relasi yang duplikat di pendidikan_has_jenjang
                // Cek apakah relasi sudah ada
                if (!PendidikanHasJenjang::where('data_pendidikan_id', $dataPendidikan->id)
                    ->where('jenjang_id', $jenjang->id)
                    ->exists()) {
                    // Buat relasi ke pendidikan_has_jenjang
                    PendidikanHasJenjang::create([
                        'data_pendidikan_id' => $dataPendidikan->id,
                        'jenjang_id' => $jenjang->id,
                    ]);
                }
            }
        }

        return null; // Tidak perlu mengembalikan model
    }
}