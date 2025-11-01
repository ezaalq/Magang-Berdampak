<?php

namespace Database\Seeders;

use App\Models\NilaiIndex;
use Illuminate\Database\Seeder;

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
