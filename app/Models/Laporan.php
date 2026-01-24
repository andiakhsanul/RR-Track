<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporan';
    protected $primaryKey = 'id_laporan';

    protected $fillable = [
        'id_jenis_laporan',
        'tanggal_pemeriksaan',
        'id_pasien',
        'id_jenis_pemeriksaan',
        'id_modalitas',
        'id_petugas',
        'keterangan',
        'kesalahan_label',
        'insiden_reaksi_obat_kontras',
    ];

    protected $casts = [
        'tanggal_pemeriksaan' => 'date',
        'kesalahan_label' => 'boolean',
        'insiden_reaksi_obat_kontras' => 'boolean',
    ];

    /**
     * Get the jenis laporan
     */
    public function jenisLaporan(): BelongsTo
    {
        return $this->belongsTo(JenisLaporan::class, 'id_jenis_laporan', 'id_jenis_laporan');
    }

    /**
     * Get the pasien
     */
    public function pasien(): BelongsTo
    {
        return $this->belongsTo(Pasien::class, 'id_pasien', 'id_pasien');
    }

    /**
     * Get the jenis pemeriksaan
     */
    public function jenisPemeriksaan(): BelongsTo
    {
        return $this->belongsTo(JenisPemeriksaan::class, 'id_jenis_pemeriksaan', 'id_jenis_pemeriksaan');
    }

    /**
     * Get the modalitas
     */
    public function modalitas(): BelongsTo
    {
        return $this->belongsTo(Modalitas::class, 'id_modalitas', 'id_modalitas');
    }

    /**
     * Get the petugas
     */
    public function petugas(): BelongsTo
    {
        return $this->belongsTo(Petugas::class, 'id_petugas', 'id_petugas');
    }

    /**
     * Get all faktor penyebab for this laporan
     */
    public function faktorPenyebab(): BelongsToMany
    {
        return $this->belongsToMany(
            FaktorPenyebab::class,
            'detail_faktor_laporan',
            'id_laporan',
            'id_faktor'
        );
    }

    /**
     * Get all jenis insiden for this laporan
     */
    public function jenisInsiden(): BelongsToMany
    {
        return $this->belongsToMany(
            JenisInsiden::class,
            'detail_insiden_laporan',
            'id_laporan',
            'id_insiden'
        );
    }

    /**
     * Check if this is a repeat (ulang) report
     */
    public function isRepeat(): bool
    {
        return $this->id_jenis_laporan === JenisLaporan::ULANG;
    }

    /**
     * Check if this is a reject (tolak) report
     */
    public function isReject(): bool
    {
        return $this->id_jenis_laporan === JenisLaporan::TOLAK;
    }

    /**
     * Scope for repeat reports
     */
    public function scopeRepeat($query)
    {
        return $query->where('id_jenis_laporan', JenisLaporan::ULANG);
    }

    /**
     * Scope for reject reports
     */
    public function scopeReject($query)
    {
        return $query->where('id_jenis_laporan', JenisLaporan::TOLAK);
    }
}
