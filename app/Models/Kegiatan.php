<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model for Kegiatan (Activity)
 *
 * @property int $id
 * @property int $id_mahasiswa
 * @property string $judul
 * @property string $kategori
 * @property string|null $file_kegiatan
 * @property string $status
 */
class Kegiatan extends Model
{
    use HasFactory;

    protected $table = 'kegiatan';

    protected $fillable = [
        'id_mahasiswa', 'judul', 'kategori', 'file_kegiatan', 'status',
    ];

    /**
     * Get the student that owns the activity.
     *
     * @return BelongsTo<Mahasiswa, Kegiatan>
     */
    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class, 'id_mahasiswa');
    }
}
