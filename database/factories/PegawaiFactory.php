<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pegawai>
 */
class PegawaiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => $this->faker->name(),
            'status' => $this->faker->randomElement(['aktif', 'non-aktif']),
            'tanggal_lahir' => $this->faker->date(),
            'jabatan' => $this->faker->jobTitle(),
            'departemen' => $this->faker->company(),
            'pendidikan' => $this->faker->randomElement(['SMA', 'S1', 'S2', 'S3']),
            'role'=> $this->faker->randomElement(['user', 'ketua kelompok', 'admin', 'approval', 'verifikator']),
            'jenis_kelamin'=> $this->faker->randomElement(['laki-laki', 'perempuan']),
        ];
    }
}
