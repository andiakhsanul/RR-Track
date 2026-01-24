<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisPemeriksaan extends Model
{
    use HasFactory;

    protected $table = 'jenis_pemeriksaan';
    protected $primaryKey = 'id_jenis_pemeriksaan';

    protected $fillable = [
        'nama_jenis_pemeriksaan',
    ];

    /**
     * Get all laporan for this jenis pemeriksaan
     */
    public function laporan(): HasMany
    {
        return $this->hasMany(Laporan::class, 'id_jenis_pemeriksaan', 'id_jenis_pemeriksaan');
    }
}
