<?php

namespace Database\Seeders;

use App\Models\Laporan;
use Illuminate\Database\Seeder;

class LaporanSeeder extends Seeder
{
    public function run(): void
    {
        Laporan::create([
            'id_mahasiswa' => 2,
            'tanggal' => now()->toDateString(),
            'judul' => 'Laporan Akhir Magang',
            'isi_laporan' => 'Ini adalah laporan akhir magang.',
            'file_laporan' => 'laporan_akhir.pdf',
        ]);
    }
}
