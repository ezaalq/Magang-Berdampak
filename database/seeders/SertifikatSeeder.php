<?php

namespace Database\Seeders;

use App\Models\Sertifikat;
use Illuminate\Database\Seeder;

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
