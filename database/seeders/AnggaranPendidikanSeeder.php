<?php

namespace Database\Seeders;

use App\Models\AnggaranPendidikan;
use Illuminate\Database\Seeder;

class AnggaranPendidikanSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    AnggaranPendidikan::create([
      'jenjang_id' => '4',
      'region' => 'nasional',
      'anggaran_min' => '80000000',
      'anggaran_maks' => '251200000'
    ]);
    AnggaranPendidikan::create([
      'jenjang_id' => '4',
      'region' => 'internasional',
      'anggaran_min' => '100000000',
      'anggaran_maks' => '563150000'
    ]);
    AnggaranPendidikan::create([
      'jenjang_id' => '5',
      'region' => 'nasional',
      'anggaran_min' => '200000000',
      'anggaran_maks' => '247000000'
    ]);
    AnggaranPendidikan::create([
      'jenjang_id' => '5',
      'region' => 'internasional',
      'anggaran_min' => '10000000',
      'anggaran_maks' => '1217000000'
    ]);
    AnggaranPendidikan::create([
      'jenjang_id' => '6',
      'region' => 'nasional',
      'anggaran_min' => '300000000',
      'anggaran_maks' => '581000000'
    ]);
    AnggaranPendidikan::create([
      'jenjang_id' => '6',
      'region' => 'internasional',
      'anggaran_min' => '2000000000',
      'anggaran_maks' => '2705000000'
    ]);
  }
}
