<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sertifikat extends Model
{
    use HasFactory;
    protected $table = 'sertifikat';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_mahasiswa', 'file_sertifikat', 'nama_sertifikat', 'tanggal_terbit', 'deskripsi'
    ];
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'id_mahasiswa');
    }
}
