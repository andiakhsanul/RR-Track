<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisLaporan extends Model
{
    use HasFactory;

    protected $table = 'jenis_laporan';
    protected $primaryKey = 'id_jenis_laporan';

    protected $fillable = [
        'id_jenis_laporan',
        'nama_jenis_laporan',
    ];

    // Constants for jenis laporan
    const ULANG = 1;
    const TOLAK = 2;

    /**
     * Get all laporan for this jenis laporan
     */
    public function laporan(): HasMany
    {
        return $this->hasMany(Laporan::class, 'id_jenis_laporan', 'id_jenis_laporan');
    }
}
