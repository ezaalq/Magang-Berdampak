<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model for NilaiIndex (Index Score)
 *
 * @property int $id
 * @property int $id_mahasiswa
 * @property float $nilai_index
 * @property string $status
 */
class NilaiIndex extends Model
{
    use HasFactory;

    protected $table = 'nilai_index';

    protected $fillable = [
        'id_mahasiswa', 'nilai_index', 'status',
    ];

    protected $casts = [
        'nilai_index' => 'decimal:2',
    ];

    /**
     * Get the student that owns the index score.
     *
     * @return BelongsTo<Mahasiswa, NilaiIndex>
     */
    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class, 'id_mahasiswa');
    }
}
