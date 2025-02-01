<?php

namespace Database\Factories\Admin;

use App\Models\Admin\Jurusan;
use App\Models\Admin\Kelas;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin\Kelas>
 */
class KelasFactory extends Factory
{
    protected $model = Kelas::class;

    public function definition(): array
    {

        $jurusanIds = Jurusan::pluck('id')->toArray();
        $kelasTingkat = ['X', 'XI', 'XII'];
        $rombelMax = 4;

        $jurusanId = $this->faker->randomElement($jurusanIds);
        $tingkatKelas = $this->faker->randomElement($kelasTingkat);
        $rombel = $this->faker->numberBetween(1, $rombelMax);

        $tingkatKelas = $this->faker->randomElement($kelasTingkat);
        $rombel = $this->faker->numberBetween(1, $rombelMax);

        while (Kelas::where('jurusan_id', $jurusanId)
            ->where('kelas_tingkat', $tingkatKelas)
            ->where('rombel', $rombel)
            ->exists()
        ) {
            // Jika kombinasi sudah ada, pilih ulang jurusan, tingkat kelas, dan rombel
            $jurusanId = $this->faker->randomElement($jurusanIds);
            $tingkatKelas = $this->faker->randomElement($kelasTingkat);
            $rombel = $this->faker->numberBetween(1, $rombelMax);
        }

        return [
            'jurusan_id' => $jurusanId,
            'kelas_tingkat' => $tingkatKelas,
            'rombel' => $rombel,
        ];
    }
}
