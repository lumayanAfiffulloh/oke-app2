<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Role;
use App\Models\Jabatan;
use App\Models\UnitKerja;
use App\Models\DataPegawai;
use App\Models\JenjangTerakhir;
use App\Models\PendidikanTerakhir;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DataPegawaiImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Cari atau buat role "pegawai"
        $rolePegawai = Role::firstOrCreate(['role' => 'pegawai']);

        // Cari atau buat user
        $akun = User::firstOrCreate(
            ['email' => $row['email']],
            [
                'name' => $row['nama_lengkap'],
                'password' => Hash::make('password'), // Password default
            ]
        );

        // Tambahkan role "pegawai" jika belum ada
        if (!$akun->roles->contains($rolePegawai->id)) {
            $akun->roles()->attach($rolePegawai->id);
        }

        // Cari atau buat unit kerja
        $unitKerja = UnitKerja::firstOrCreate([
            'unit_kerja' => $row['unit_es_ii'],
        ]);

        // Cari atau buat jabatan
        $jabatan = Jabatan::firstOrCreate([
            'jabatan' => $row['jabatan'],
        ]);

        // Cari atau buat jenjang pendidikan terakhir
        $jenjangTerakhir = JenjangTerakhir::firstOrCreate([
            'jenjang_terakhir' => $row['pendidikan'],
        ]);

        // Cari atau buat pendidikan terakhir
        $pendidikanTerakhir = PendidikanTerakhir::firstOrCreate([
            'jenjang_terakhir_id' => $jenjangTerakhir->id,
            'jurusan' => $row['jurusan'],
        ]);

        // Update atau buat data pegawai
        return DataPegawai::updateOrCreate(
            ['user_id' => $akun->id],
            [
                'nama' => $row['nama_lengkap'],
                'nppu' => $row['nppu'],
                'status' => 'aktif', // Status default
                'unit_kerja_id' => $unitKerja->id,
                'jabatan_id' => $jabatan->id,
                'pendidikan_terakhir_id' => $pendidikanTerakhir->id,
                'jenis_kelamin' => $row['jns_kel'],
                'nomor_telepon' => $row['nomor_telepon'] ?? null,
            ]
        );
    }
}
