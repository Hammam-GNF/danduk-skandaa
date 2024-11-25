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
        return [
            'jurusan_id' => Jurusan::factory(),
            'kelas_tingkat' => $this->faker->randomElement(['X', 'XI', 'XII']),
            'rombel' => $this->faker->randomNumber(2, true),
        ];
    }
}
