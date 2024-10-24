<?php

namespace App\Imports;

use App\Models\DataPegawai;
use App\Models\User; 
use Illuminate\Support\Facades\Hash; 
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DataPegawaiImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)

    {
        $akun = User::whereEmail($row['email'])->first();
        if($akun){
            $akun->update([
                'name' => $row['nama'],
                'akses' => 'pegawai',
                // Tidak perlu update password jika tidak ingin mengubahnya
            ]);

            // Update atau buat data pegawai yang terkait
            $dataPegawai = DataPegawai::updateOrCreate(
                ['user_id' => $akun->id], // Cari data pegawai berdasarkan user_id
                [
                    'nama' => $row['nama'],
                    'nip' => $row['nip'],
                    'status' => $row['status'],
                    'jabatan' => $row['jabatan'],
                    'unit_kerja' => $row['unit_kerja'],
                    'pendidikan' => $row['pendidikan'],
                    'jenis_kelamin' => $row['jenis_kelamin'],
                ]);
            return $dataPegawai;
        }

        $user = User::create([
            'name' => $row['nama'],
            'email' => $row['email'],
            'akses' => 'pegawai',
            'password' => Hash::make('password'), // Hash password
        ]);

        return new DataPegawai([
            'nama' => $row['nama'],
            'nip' => $row['nip'],
            'status' => $row['status'],
            'jabatan' => $row['jabatan'],
            'unit_kerja' => $row['jabatan'],
            'pendidikan' => $row['pendidikan'],
            'jenis_kelamin' => $row['jenis_kelamin'],
            'user_id' => $user->id, // Ambil id dari user yang baru dibuat
        ]);
    }
}
