<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisLaporanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id_jenis_laporan' => 1, 'nama_jenis_laporan' => 'ulang'],
            ['id_jenis_laporan' => 2, 'nama_jenis_laporan' => 'tolak'],
        ];

        foreach ($data as $item) {
            DB::table('jenis_laporan')->updateOrInsert(
                ['id_jenis_laporan' => $item['id_jenis_laporan']],
                $item
            );
        }
    }
}
