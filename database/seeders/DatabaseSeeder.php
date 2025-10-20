<?php

namespace Database\Seeders;

use App\Models\User;
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
            MahasiswaSeeder::class,
            AbsenSeeder::class,
            AlasanSeeder::class,
            KegiatanSeeder::class,
            LaporanSeeder::class,
            NilaiIndexSeeder::class,
            SertifikatSeeder::class,
        ]);
    }
}
