<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PelaksanaanPembelajaran>
 */
class PelaksanaanPembelajaranFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $idPegawai = \App\Models\Pegawai::pluck('id')->toArray();
        $idPembelajaran = \App\Models\RencanaPembelajaran::pluck('id')->toArray();
        return [
            'pegawai_id' => $this->faker->randomElement($idPegawai),
            'rencana_pembelajaran_id' => $this->faker->randomElement($idPembelajaran),
            'tanggal_pelaksanaan' => $this->faker->date(),
            'status_pembelajaran' => $this->faker->randomElement(['direncanakan', 'berjalan', 'selesai']),
        ];
    }
}
