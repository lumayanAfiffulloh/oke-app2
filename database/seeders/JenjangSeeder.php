<?php

namespace Database\Seeders;

use App\Models\Jenjang;
use Illuminate\Database\Seeder;

class JenjangSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    // Menambahkan jenjang dalam array
    $jenjangs = ['D1', 'D2', 'D3', 'S1', 'S2', 'S3'];

    // Menyimpan setiap jenjang ke dalam database
    foreach ($jenjangs as $jenjang) {
      Jenjang::create(['jenjang' => $jenjang]);
    }
  }
}
