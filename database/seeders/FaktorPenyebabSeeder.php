<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FaktorPenyebab;

class FaktorPenyebabSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faktorList = [
            'Human Error (Posisi Px, SOP, Kesalahan Teknis, FE ,Artefak)',
            'Tools Error (Alat Rusak, Prosesing, Server down, Aliran Tidak Stabil)',
            'Patient Error (Px tidak kooperatif, Px Moving)',
            'Administratif (Print Double, Double input,, Data Masuk Tidak Sesuai)',
        ];

        foreach ($faktorList as $nama) {
            FaktorPenyebab::firstOrCreate(['nama_faktor' => $nama]);
        }
    }
}
