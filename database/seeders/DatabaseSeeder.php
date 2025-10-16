<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // Tambahkan UserSeeder::class di sini
            \Database\Seeders\UserSeeder::class, 
            \Database\Seeders\AlatSeeder::class,
            // Tambahkan Seeder lain di sini jika ada...
        ]);
    }
}
