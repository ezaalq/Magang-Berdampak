<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model for Sertifikat (Certificate)
 *
 * @property int $id
 * @property int $id_mahasiswa
 * @property string|null $file_sertifikat
 * @property string $nama_sertifikat
 * @property string $tanggal_terbit
 * @property string|null $deskripsi
 */
class Sertifikat extends Model
{
    use HasFactory;

    protected $table = 'sertifikat';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id_mahasiswa', 'file_sertifikat', 'nama_sertifikat', 'tanggal_terbit', 'deskripsi',
    ];

    protected $casts = [
        'tanggal_terbit' => 'date',
    ];

    /**
     * Get the student that owns the certificate.
     *
     * @return BelongsTo<Mahasiswa, Sertifikat>
     */
    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class, 'id_mahasiswa');
    }
}
