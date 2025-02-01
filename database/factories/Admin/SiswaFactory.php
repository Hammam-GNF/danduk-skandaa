<?php

namespace Database\Factories\Admin;

use App\Models\Admin\Kelas;
use App\Models\Admin\Siswa;
use App\Models\Admin\TahunAjaran;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class SiswaFactory extends Factory
{
    protected $model = Siswa::class;

    public function definition(): array
    {
        $tahunAjaranAktif = TahunAjaran::where('status', 'aktif')->inRandomOrder()->first();

        $kelas = Kelas::inRandomOrder()->first();

        return [
            'nis' => $this->faker->unique()->numerify('############'),
            'thajaran_id' => $tahunAjaranAktif->id,
            'kelas_id' => $kelas->id,
            'nama_siswa' => $this->faker->name(),
            'jns_kelamin' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'status' => $this->faker->randomElement(['Aktif', 'Nonaktif']),
            'nama_ortu' => $this->faker->name(),
            'nohp_ortu' => $this->faker->numerify('###########'),
            'alamat' => $this->faker->address(),
        ];
    }
}
