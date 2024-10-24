<?php

namespace Database\Seeders;

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
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // \App\Models\DataPegawai::factory(50)->create();
        User::create([
            'name' => 'Budiono',
            'email' => 'budiono@gmail.com',
            'akses' => 'admin',
            'password' => Hash::make('password'), // Hashing password untuk keamanan
        ]);
    }
}
