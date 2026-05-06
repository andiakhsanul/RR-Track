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

    public function getNamaUtamaAttribute(): string
    {
        return $this->splitNamaFaktor()['utama'];
    }

    public function getDetailAttribute(): ?string
    {
        return $this->splitNamaFaktor()['detail'];
    }

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

    /**
     * Split "Nama Utama (detail)" into a short display label and hover detail.
     *
     * @return array{utama: string, detail: string|null}
     */
    private function splitNamaFaktor(): array
    {
        $nama = trim((string) $this->nama_faktor);

        if (preg_match('/^(.*?)\s*\((.*)\)\s*$/', $nama, $matches)) {
            return [
                'utama' => trim($matches[1]),
                'detail' => trim($matches[2]) ?: null,
            ];
        }

        return [
            'utama' => $nama,
            'detail' => null,
        ];
    }
}
