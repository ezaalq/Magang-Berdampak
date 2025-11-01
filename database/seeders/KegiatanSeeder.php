<?php

namespace Database\Seeders;

use App\Models\Kegiatan;
use Illuminate\Database\Seeder;

class KegiatanSeeder extends Seeder
{
    public function run(): void
    {
        Kegiatan::create([
            'id_mahasiswa' => 2,
            'judul' => 'Upload Foto Kegiatan',
            'kategori' => 'foto',
            'file_kegiatan' => 'foto1.jpg',
            'status' => 'Disetujui',
        ]);
        Kegiatan::create([
            'id_mahasiswa' => 3,
            'judul' => 'Upload Reels',
            'kategori' => 'reels',
            'file_kegiatan' => 'reels1.mp4',
            'status' => 'Menunggu',
        ]);
    }
}
