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
            'id_jurusan' => 'MM',
            'nama_jurusan' => 'Multimedia',
        ]);
        Jurusan::create([
            'id_jurusan' => 'TKP',
            'nama_jurusan' => 'Teknik Perkapalan',
        ]);
    }
}