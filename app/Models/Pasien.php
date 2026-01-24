<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pasien extends Model
{
    use HasFactory;

    protected $table = 'pasien';
    protected $primaryKey = 'id_pasien';

    protected $fillable = [
        'no_rm',
        'nama_pasien',
    ];

    /**
     * Get all laporan for this pasien
     */
    public function laporan(): HasMany
    {
        return $this->hasMany(Laporan::class, 'id_pasien', 'id_pasien');
    }
}
