<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Mahasiswa;

class MahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        Mahasiswa::create([
            'nim' => '12345678',
            'nama' => 'Admin Magang',
            'email' => 'admin@magang.com',
            'password' => Hash::make('admin123'),
            'asal_sekolah' => 'Universitas Magang mataram',
            'jurusan' => 'Teknik Informatika',
            'alamat' => 'Jl. Admin',
            'role' => 'admin',
        ]);
        Mahasiswa::create([
            'nim' => '87654321',
            'nama' => 'Mahasiswa Satu',
            'email' => 'mahasiswa1@magang.com',
            'password' => Hash::make('mahasiswa123'),
            'asal_sekolah' => 'Universitas Magang bima',
            'jurusan' => 'Sistem Informasi',
            'alamat' => 'Jl. Mahasiswa 1',
            'role' => 'mahasiswa',
        ]);
        Mahasiswa::create([
            'nim' => '11223344',
            'nama' => 'Mahasiswa Dua',
            'email' => 'mahasiswa2@magang.com',
            'password' => Hash::make('mahasiswa123'),
            'asal_sekolah' => 'Institut Magang sumbawa',
            'jurusan' => 'Teknik Komputer',
            'alamat' => 'Jl. Mahasiswa 2',
            'role' => 'mahasiswa',
        ]);
    }
}
