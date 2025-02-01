<?php

namespace Database\Factories\Admin;

use App\Models\Admin\Jurusan;
use Illuminate\Database\Eloquent\Factories\Factory;

class JurusanFactory extends Factory
{
    protected $model = Jurusan::class;

    public function definition(): array
    {

        $jurusanList = [
            'Teknik Komputer dan Jaringan' => 'TKJ',
            'Rekayasa Perangkat Lunak' => 'RPL',
            'Multimedia' => 'MM',
            'Akuntansi' => 'AK',
            'Bisnis Daring dan Pemasaran' => 'BDP',
        ];

        $namaJurusan = $this->faker->randomElement(array_keys($jurusanList));
        $kodeJurusan = $jurusanList[$namaJurusan];

        return [
            'kode_jurusan' => $kodeJurusan,
            'nama_jurusan' => $namaJurusan,
        ];
    }
}
