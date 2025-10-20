<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Alasan;

class AlasanSeeder extends Seeder
{
    public function run(): void
    {
        Alasan::create([
            'id_mahasiswa' => 3,
            'tanggal' => now()->toDateString(),
            'alasan' => 'Sakit',
        ]);
    }
}
