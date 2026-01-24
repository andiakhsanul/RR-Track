<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Petugas extends Model
{
    use HasFactory;

    protected $table = 'petugas';
    protected $primaryKey = 'id_petugas';

    protected $fillable = [
        'inisial',
        'nama_lengkap',
    ];

    /**
     * Get all laporan for this petugas
     */
    public function laporan(): HasMany
    {
        return $this->hasMany(Laporan::class, 'id_petugas', 'id_petugas');
    }
}
