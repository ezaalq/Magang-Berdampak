<?php


namespace App\Models;

use App\Models\Absen;
use App\Models\Alasan;
use App\Models\Kegiatan;
use App\Models\Laporan;
use App\Models\NilaiIndex;
use App\Models\Sertifikat;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Mahasiswa extends Authenticatable
{
    use HasFactory;

    protected $table = 'tabel_mahasiswa';
    protected $primaryKey = 'id_mahasiswa';
    protected $fillable = [
        'nim', 'nama', 'email','asal_sekolah', 'jurusan', 'alamat', 'foto', 'password', 'role'
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $guarded = [];

    public function absen()
    {
        return $this->hasMany(Absen::class, 'id_mahasiswa');
    }
    public function alasan()
    {
        return $this->hasMany(Alasan::class, 'id_mahasiswa');
    }
    public function kegiatan()
    {
        return $this->hasMany(Kegiatan::class, 'id_mahasiswa');
    }
    public function laporan()
    {
        return $this->hasMany(Laporan::class, 'id_mahasiswa');
    }
    public function nilai_index()
    {
        return $this->hasOne(NilaiIndex::class, 'id_mahasiswa');
    }
    public function sertifikat()
    {
        return $this->hasOne(Sertifikat::class, 'id_mahasiswa');
    }
}
