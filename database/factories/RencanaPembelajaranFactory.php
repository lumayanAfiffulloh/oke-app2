<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RencanaPembelajaran>
 */
class RencanaPembelajaranFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tahun' => $this->faker->year('+10 years'),
            'klasifikasi' => $this->faker->randomElement(['pelatihan', 'pendidikan']),
            'kategori_klasifikasi' => $this->faker->randomElement(['gelar', 'non-gelar', 'teknis', 'fungsional', 'sosial kultural']),
            'kategori' => $this->faker->randomElement(['klasikal', 'non-klasikal']),
            'bentuk_jalur' => $this->faker->words(2, true),
            'nama_pelatihan' => $this->faker->words(2, true),
            'jam_pelajaran'=> $this->faker->numberBetween(1,50),
            'regional'=> $this->faker->randomElement(['nasional', 'internasional']),
            'anggaran'=> $this->faker->numberBetween(0,100),
            'prioritas'=> $this->faker->randomElement(['rendah', 'sedang', 'tinggi']),
        ];
    }
}
