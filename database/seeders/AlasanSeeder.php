<?php

namespace Database\Seeders;

use App\Models\Alasan;
use Illuminate\Database\Seeder;

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
