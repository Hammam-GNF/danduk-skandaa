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
        return [
            'nis' => $this->faker->unique()->numerify('############'),
            'thajaran_id' => TahunAjaran::all()->random()->id,
            'kelas_id' => Kelas::all()->random()->id,
            'nama_siswa' => $this->faker->name(),
            'jns_kelamin' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'status' => $this->faker->randomElement(['Aktif', 'Tidak Aktif']),
            'nama_ortu' => $this->faker->name(),
            'nohp_ortu' => $this->faker->numerify('###########'),
            'alamat' => $this->faker->address(),
        ];
    }
}
