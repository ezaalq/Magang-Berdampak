<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    use HasFactory;
    protected $table = 'absens';
    protected $fillable = [
        'id_mahasiswa', 'tanggal', 'waktu', 'status', 'keterangan', 'bukti_absen'
    ];
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'id_mahasiswa');
    }
}