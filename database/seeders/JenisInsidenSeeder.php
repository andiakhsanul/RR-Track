<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JenisInsiden;

class JenisInsidenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $insidenList = [
            'Insiden Reaksi Obat Kontras',
            'Kesalahan Pemberian Obat',
        ];

        foreach ($insidenList as $nama) {
            JenisInsiden::firstOrCreate(['nama_insiden' => $nama]);
        }
    }
}
