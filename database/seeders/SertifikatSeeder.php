<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sertifikat;

class SertifikatSeeder extends Seeder
{
    public function run(): void
    {
        Sertifikat::create([
            'id_mahasiswa' => 2,
            'file_sertifikat' => 'sertifikat_magang.pdf',
        ]);
    }
}
