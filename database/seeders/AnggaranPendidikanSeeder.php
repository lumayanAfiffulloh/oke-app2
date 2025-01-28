<?php

namespace Database\Seeders;

use App\Models\AnggaranPendidikan;
use App\Models\Region;
use Illuminate\Database\Seeder;

class AnggaranPendidikanSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    // Ambil data region berdasarkan nama
    $nasional = Region::where('region', 'nasional')->firstOrFail();
    $internasional = Region::where('region', 'internasional')->firstOrFail();

    // Seed data anggaran pendidikan
    AnggaranPendidikan::create([
      'jenjang_id' => 4,
      'region_id' => $nasional->id, // Menggunakan region_id dari tabel regions
      'anggaran_min' => 80000000,
      'anggaran_maks' => 251200000
    ]);

    AnggaranPendidikan::create([
      'jenjang_id' => 4,
      'region_id' => $internasional->id, // Menggunakan region_id dari tabel regions
      'anggaran_min' => 100000000,
      'anggaran_maks' => 563150000
    ]);

    AnggaranPendidikan::create([
      'jenjang_id' => 5,
      'region_id' => $nasional->id,
      'anggaran_min' => 200000000,
      'anggaran_maks' => 247000000
    ]);

    AnggaranPendidikan::create([
      'jenjang_id' => 5,
      'region_id' => $internasional->id,
      'anggaran_min' => 10000000,
      'anggaran_maks' => 1217000000
    ]);

    AnggaranPendidikan::create([
      'jenjang_id' => 6,
      'region_id' => $nasional->id,
      'anggaran_min' => 300000000,
      'anggaran_maks' => 581000000
    ]);

    AnggaranPendidikan::create([
      'jenjang_id' => 6,
      'region_id' => $internasional->id,
      'anggaran_min' => 2000000000,
      'anggaran_maks' => 2705000000
    ]);
  }
}
