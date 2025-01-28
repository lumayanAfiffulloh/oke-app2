<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;
use App\Models\BentukJalur;

class BentukJalurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data kategori dan bentuk jalur
        $data = [
            [
                'kategori' => 'klasikal',
                'bentuk_jalur' => [
                    'Pelatihan struktural kepemimpinan',
                    'Pelatihan manajerial',
                    'Pelatihan teknis',
                    'Pelatihan fungsional',
                    'Pelatihan social kultural',
                    'Seminar/konferensi/ saresehan/Webinar',
                    'Workshop/lokakarya',
                    'Kursus',
                    'Penataran',
                    'Bimbingan teknis',
                ],
            ],
            [
                'kategori' => 'non-klasikal',
                'bentuk_jalur' => [
                    'Sosialisasi',
                    'Counselling',
                    'Coaching',
                    'Mentoring',
                    'E-Learning',
                    'Pelatihan jarak jauh',
                    'Pembelajaran alam terbuka (outbound)',
                    'Patok Banding (benchmarking)',
                    'Pertukaran antara PNS dg pegawai swasta/ BUMN/BUMD',
                    'Belajar mandiri (self learning)',
                    'Komunitas belajar (community of practices)',
                    'Magang/praktek Kerja',
                    'Datasering (secondment)',
                ],
            ],
        ];

        // Looping data dan insert ke tabel BentukJalur
        foreach ($data as $item) {
            // Mencari atau membuat kategori
            $kategori = Kategori::firstOrCreate(['kategori' => $item['kategori']]);

            // Menambahkan bentuk jalur yang terkait dengan kategori
            foreach ($item['bentuk_jalur'] as $bentukJalur) {
                BentukJalur::create([
                    'kategori_id' => $kategori->id, // Menyimpan ID kategori
                    'bentuk_jalur' => $bentukJalur, // Menyimpan bentuk jalur
                ]);
            }
        }
    }
}

