<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;
use App\Models\JenisPendidikan;

class JenisPendidikanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data kategori dan bentuk jalur
        $data = [
            [
                'jenis_pendidikan' => 'tb+',
                'keterangan' => 'meninggalkan tugas jabatan + dengan jaminan pembiayaan/beasiswa'
            ],
            [
                'jenis_pendidikan' => 'tb',
                'keterangan' => 'tidak meninggalkan tugas jabatan + dengan jaminan pembiayaan/beasiswa'
            ],
            [
                'jenis_pendidikan' => 'tbbm+',
                'keterangan' => 'meninggalkan tugas jabatan + dengan biaya mandiri'
            ],
            [
                'jenis_pendidikan' => 'tbbm',
                'keterangan' => 'tidak meninggalkan tugas jabatan + dengan biaya mandiri'
            ],
        ];

        // Looping data dan insert ke tabel JenisPendidikan
        foreach ($data as $item) {
            // Mencari atau membuat jenis_pendidikan
            JenisPendidikan::firstOrCreate(['jenis_pendidikan' => $item['jenis_pendidikan']], ['keterangan' => $item['keterangan']] );
        }
    }
}

