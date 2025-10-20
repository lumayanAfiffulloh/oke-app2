<?php
namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Menambahkan jenjang dalam array
        $roles = ['admin', 'pegawai', 'ketua_kelompok', 'approver', 'verifikator', 'pimpinan'];

        // Menyimpan setiap role ke dalam database
        foreach ($roles as $role) {
            Role::create(['role' => $role]);
        }
    }
}
