<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Petugas;

class PetugasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $petugasList = [
            ['inisial' => 'FB', 'nama_lengkap' => null],
            ['inisial' => 'FA', 'nama_lengkap' => null],
            ['inisial' => 'IR', 'nama_lengkap' => null],
            ['inisial' => 'RZ', 'nama_lengkap' => null],
            ['inisial' => 'DF', 'nama_lengkap' => null],
            ['inisial' => 'HN', 'nama_lengkap' => null],
            ['inisial' => 'NN', 'nama_lengkap' => null],
            ['inisial' => 'AK', 'nama_lengkap' => null],
            ['inisial' => 'EA', 'nama_lengkap' => null],
        ];

        foreach ($petugasList as $petugas) {
            Petugas::firstOrCreate(
                ['inisial' => $petugas['inisial']],
                $petugas
            );
        }
    }
}
