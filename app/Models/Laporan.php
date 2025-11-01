<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model for Laporan (Report)
 *
 * @property int $id
 * @property int $id_mahasiswa
 * @property string $tanggal
 * @property string $judul
 * @property string $isi_laporan
 * @property string|null $file_laporan
 */
class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporan';

    protected $fillable = [
        'id_mahasiswa',
        'tanggal',
        'judul',
        'isi_laporan',
        'file_laporan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    /**
     * Get the student that owns the report.
     *
     * @return BelongsTo<Mahasiswa, Laporan>
     */
    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class, 'id_mahasiswa');
    }
}
