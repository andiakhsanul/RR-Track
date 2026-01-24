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
            'Human Error',
            'Tools Error',
            'Patient Error',
            'Administratif',
        ];

        foreach ($faktorList as $nama) {
            FaktorPenyebab::firstOrCreate(['nama_faktor' => $nama]);
        }
    }
}
