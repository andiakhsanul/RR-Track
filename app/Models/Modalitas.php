<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Modalitas extends Model
{
    use HasFactory;

    protected $table = 'modalitas';
    protected $primaryKey = 'id_modalitas';

    protected $fillable = [
        'nama_modalitas',
    ];

    /**
     * Get all laporan for this modalitas
     */
    public function laporan(): HasMany
    {
        return $this->hasMany(Laporan::class, 'id_modalitas', 'id_modalitas');
    }
}
