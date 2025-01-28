<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Jabatan;
use App\Models\UnitKerja;
use App\Models\DataPegawai;
use App\Models\JenjangTerakhir;
use App\Models\PendidikanTerakhir;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            // Membuat user
            $user = User::create([
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'),
            ]);

            // Membuat unit kerja, jabatan, jenjang terakhir, dan pendidikan terakhir
            $unitKerja = UnitKerja::create(['unit_kerja' => 'Fakultas Teknik']);
            $jabatan = Jabatan::create(['jabatan' => 'administrasi website']);
            $jenjangTerakhir = JenjangTerakhir::create(['jenjang_terakhir' => 'S1']);
            $pendidikanTerakhir = PendidikanTerakhir::create([
                'jenjang_terakhir_id' => $jenjangTerakhir->id,
                'jurusan' => 'Teknik Elektro'
            ]);

            // Menambahkan role 'admin'
            $roleAdmin = Role::where('role', 'admin')->first();
            if ($roleAdmin) {
                $user->roles()->attach($roleAdmin);
            }

            // Membuat data pegawai
            DataPegawai::create([
                'nama' => 'Achmad Admin',
                'nppu' => '12345678',
                'status' => 'aktif',
                'pendidikan_terakhir_id' => $pendidikanTerakhir->id,
                'jenis_kelamin' => 'L',
                'nomor_telepon' => '62896012030124',
                'unit_kerja_id' => $unitKerja->id,
                'jabatan_id' => $jabatan->id,
                'user_id' => $user->id
            ]);
        });
    }
}