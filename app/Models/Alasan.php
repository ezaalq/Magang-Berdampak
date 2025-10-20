<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alasan extends Model
{
    use HasFactory;
    protected $table = 'alasan';
    protected $fillable = [
        'id_mahasiswa', 'tanggal', 'alasan'
    ];
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'id_mahasiswa');
    }
}
