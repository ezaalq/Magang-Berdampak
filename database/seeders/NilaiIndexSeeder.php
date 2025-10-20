<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NilaiIndex;

class NilaiIndexSeeder extends Seeder
{
    public function run(): void
    {
        NilaiIndex::create([
            'id_mahasiswa' => 2,
            'nilai_index' => 3.75,
            'status' => 'lulus',
        ]);
    }
}
