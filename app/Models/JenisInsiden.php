<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class JenisInsiden extends Model
{
    use HasFactory;

    protected $table = 'jenis_insiden';
    protected $primaryKey = 'id_insiden';

    protected $fillable = [
        'nama_insiden',
    ];

    /**
     * Get all laporan that have this insiden
     */
    public function laporan(): BelongsToMany
    {
        return $this->belongsToMany(
            Laporan::class,
            'detail_insiden_laporan',
            'id_insiden',
            'id_laporan'
        );
    }
}
