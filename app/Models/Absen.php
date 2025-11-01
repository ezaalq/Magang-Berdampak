<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model for Absen (Attendance)
 *
 * @property int $id
 * @property int $id_mahasiswa
 * @property string $tanggal
 * @property string $waktu
 * @property string $status
 * @property string|null $keterangan
 * @property string|null $bukti_absen
 */
class Absen extends Model
{
    use HasFactory;

    protected $table = 'absens';

    protected $fillable = [
        'id_mahasiswa', 'tanggal', 'waktu', 'status', 'keterangan', 'bukti_absen',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'waktu' => 'datetime:H:i',
    ];

    /**
     * Get the student that owns the attendance record.
     *
     * @return BelongsTo<Mahasiswa, Absen>
     */
    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class, 'id_mahasiswa');
    }
}
