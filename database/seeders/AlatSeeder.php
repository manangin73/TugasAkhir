<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DataAlat; // PASTIKAN NAMA MODEL SUDAH BENAR
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AlatSeeder extends Seeder
{
    /**
     * Jalankan seeder database.
     */
    public function run(): void
    {
        $alats = [
            [
                'nama_alat' => 'Gitar Akustik Yamaha',
                'tipe_alat' => 'Senar',
                'jumlah_alat' => 4,
                'foto_alat' => 'yamaha_akustik.jpg', // Contoh nama file foto
                'biaya_perawatan' => 50000,
                'status' => 'Tersedia'
            ],
            [
                'nama_alat' => 'Drum Set Mapex',
                'tipe_alat' => 'Perkusi',
                'jumlah_alat' => 1,
                'foto_alat' => 'drum_set_mapex.png',
                'biaya_perawatan' => 500000,
                'status' => 'Tersedia'
            ],
            [
                'nama_alat' => 'Keyboard Roland RD-2000',
                'tipe_alat' => 'Keyboard',
                'jumlah_alat' => 2,
                'foto_alat' => 'roland_rd2000.jpg',
                'biaya_perawatan' => 250000,
                'status' => 'Dipinjam' // Contoh status "Dipinjam"
            ],
            [
                'nama_alat' => 'Bass Elektrik Ibanez',
                'tipe_alat' => 'Senar',
                'jumlah_alat' => 3,
                'foto_alat' => 'ibanez_bass.png',
                'biaya_perawatan' => 75000,
                'status' => 'Rusak' // Contoh status "Rusak"
            ],
            [
                'nama_alat' => 'Microphone Condenser AKG',
                'tipe_alat' => 'Audio',
                'jumlah_alat' => 5,
                'foto_alat' => 'mic_akg.jpg',
                'biaya_perawatan' => 100000,
                // Status dikosongkan, akan menggunakan default 'Tersedia'
            ]
        ];

        foreach ($alats as $alat) {
            DataAlat::create($alat);
        }
    }
}