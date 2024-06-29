<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Jurusan::create([
            'id_jurusan' => 'TKR',
            'nama_jurusan' => 'Teknik Kendaraan Ringan',
        ]);
        Jurusan::create([
            'id_jurusan' => 'DPIB',
            'nama_jurusan' => 'Desain Pemodelan dan Informasi Bangunan',
        ]);
        Jurusan::create([
            'id_jurusan' => 'TKL',
            'nama_jurusan' => 'Teknik Ketenagalistrikan',
        ]);
    }
}