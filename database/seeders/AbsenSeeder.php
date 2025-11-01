<?php

namespace Database\Seeders;

use App\Models\Absen;
use Illuminate\Database\Seeder;

class AbsenSeeder extends Seeder
{
    public function run(): void
    {
        Absen::create([
            'id_mahasiswa' => 2,
            'tanggal' => now()->toDateString(),
            'status' => 'hadir',
            'keterangan' => 'Hadir tepat waktu',
            'bukti_absen' => null,
        ]);
        Absen::create([
            'id_mahasiswa' => 3,
            'tanggal' => now()->toDateString(),
            'status' => 'izin',
            'keterangan' => 'Izin karena sakit',
            'bukti_absen' => null,
        ]);
    }
}
