<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class FaktorPenyebab extends Model
{
    use HasFactory;

    protected $table = 'faktor_penyebab';
    protected $primaryKey = 'id_faktor';

    protected $fillable = [
        'nama_faktor',
    ];

    /**
     * Get all laporan that have this faktor
     */
    public function laporan(): BelongsToMany
    {
        return $this->belongsToMany(
            Laporan::class,
            'detail_faktor_laporan',
            'id_faktor',
            'id_laporan'
        );
    }
}
