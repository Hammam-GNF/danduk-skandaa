<?php

namespace Database\Factories\Admin;

use App\Models\Admin\Mapel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class MapelFactory extends Factory
{
    protected $model = Mapel::class;

    public function definition(): array
    {

        $mataPelajaran = [
            // Mata Pelajaran Umum
            'Matematika' => 'MTK',
            'Bahasa Indonesia' => 'BINDO',
            'Bahasa Inggris' => 'BING',
            'Pendidikan Pancasila' => 'PPKN',
            'Pendidikan Agama' => 'PAI',
            'Sejarah Indonesia' => 'SEJ',
            'PJOK' => 'PJOK',
            'Seni Budaya' => 'SB',
            'Informatika' => 'INF',

            // Mata Pelajaran Kejuruan
            'Gambar Teknik' => 'GT',
            'Teknik Pemesinan Dasar' => 'TPD',
            'Teknik Pengelasan' => 'TP',
            'Dasar Listrik dan Elektronika' => 'DLE',
            'Dasar Desain Pemodelan Bangunan' => 'DDPB',
            'Teknik Kendaraan Ringan' => 'TKR',
            'Nautika Kapal Penangkap Ikan' => 'NKPI',
            'Teknik Instalasi Tenaga Listrik' => 'TITL',
            'Teknik Pembangkit Tenaga Listrik' => 'TPTL',
            'Bisnis Konstruksi dan Properti' => 'BKP'
        ];

        static $index = 0;
        $mapelKeys = array_keys($mataPelajaran);

        if ($index >= count($mapelKeys)) {
            $index = 0;
        }

        $namaMapel = $mapelKeys[$index];
        $kodeMapel = $mataPelajaran[$namaMapel];

        $index++;


        return [
            'kode_mapel' => $kodeMapel,
            'nama_mapel' => $namaMapel,
        ];
    }
}
