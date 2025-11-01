<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Model for Mahasiswa (Student)
 *
 * @property int $id
 * @property string $nim
 * @property string $nama
 * @property string $email
 * @property string|null $asal_sekolah
 * @property string|null $jurusan
 * @property string|null $alamat
 * @property string|null $foto
 * @property string $password
 * @property string $role
 */
class Mahasiswa extends Authenticatable
{
    use HasFactory;

    protected $table = 'tabel_mahasiswa';

    protected $fillable = [
        'nim', 'nama', 'email', 'asal_sekolah', 'jurusan', 'alamat', 'foto', 'password', 'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    /**
     * Get the attendance records for the student.
     *
     * @return HasMany<Absen>
     */
    public function absen(): HasMany
    {
        return $this->hasMany(Absen::class, 'id_mahasiswa');
    }

    /**
     * Get the reasons for the student.
     *
     * @return HasMany<Alasan>
     */
    public function alasan(): HasMany
    {
        return $this->hasMany(Alasan::class, 'id_mahasiswa');
    }

    /**
     * Get the activities for the student.
     *
     * @return HasMany<Kegiatan>
     */
    public function kegiatan(): HasMany
    {
        return $this->hasMany(Kegiatan::class, 'id_mahasiswa');
    }

    /**
     * Get the reports for the student.
     *
     * @return HasMany<Laporan>
     */
    public function laporan(): HasMany
    {
        return $this->hasMany(Laporan::class, 'id_mahasiswa');
    }

    /**
     * Get the index score for the student.
     *
     * @return HasOne<NilaiIndex>
     */
    public function nilai_index(): HasOne
    {
        return $this->hasOne(NilaiIndex::class, 'id_mahasiswa');
    }

    /**
     * Get the certificate for the student.
     *
     * @return HasOne<Sertifikat>
     */
    public function sertifikat(): HasOne
    {
        return $this->hasOne(Sertifikat::class, 'id_mahasiswa');
    }
}
