<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Modalitas;

class ModalitasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modalitasList = [
            'X Ray',
            'CT Scan',
        ];

        foreach ($modalitasList as $nama) {
            Modalitas::firstOrCreate(['nama_modalitas' => $nama]);
        }
    }
}
