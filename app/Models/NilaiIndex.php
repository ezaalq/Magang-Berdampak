<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiIndex extends Model
{
    use HasFactory;
    protected $table = 'nilai_index';
    protected $fillable = [
        'id_mahasiswa', 'nilai_index', 'status'
    ];
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'id_mahasiswa');
    }
}
