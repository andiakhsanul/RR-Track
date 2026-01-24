<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JenisPemeriksaan;

class JenisPemeriksaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jenisPemeriksaanList = [
            'Thorax AP / PA',
            'Skull AP / LAT',
            'ABDOMEN AP / LLD',
            'PELVIS',
            'CERVICAL AP / LAT',
            'THORACAL AP / LAT',
            'LUMBAL AP / LAT',
            'BRACHII AP / LAT',
            'Antbrachii AP / LAT',
            'MANUS PA / OBL',
            'WRIST AP / LAT',
            'FEMUR AP / LAT',
            'GENU AP / LAT',
            'CRURIS AP / LAT',
            'ANKLE AP / LAT',
            'PEDIS AP / OBL',
            'CT KEPALA POLOS',
            'CT KEPALA KONTRAS',
            'CT ABDOMEN POLOS',
            'CT ABDOMEN KONTRAS',
            'CT THORAX POLOS',
            'CT THORAX KONTRAS',
        ];

        foreach ($jenisPemeriksaanList as $nama) {
            JenisPemeriksaan::firstOrCreate(['nama_jenis_pemeriksaan' => $nama]);
        }
    }
}
