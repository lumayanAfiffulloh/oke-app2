<?php

namespace Database\Seeders;

use App\Models\DataPegawai;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Membuat user terlebih dahulu
        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'akses' => 'admin',
            'password' => Hash::make('password'), // Hashing password untuk keamanan
        ]);

        DataPegawai::create([
            'nama' => 'Achmad Admin',
            'nppu' => '12345678',
            'status' => 'aktif',
            'jabatan' => 'Admin Ahli',
            'unit_kerja' => 'Fakultas Teknik',
            'pendidikan' => 'S1',
            'jurusan_pendidikan' => 'Teknik Elektro',
            'jenis_kelamin' => 'L',
            'nomor_telepon' => '62896012030124',
            'user_id' => $user->id
        ]);
    }
}
