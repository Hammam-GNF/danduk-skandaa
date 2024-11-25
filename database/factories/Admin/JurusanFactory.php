<?php

namespace Database\Factories\Admin;

use App\Models\Admin\Jurusan;
use Illuminate\Database\Eloquent\Factories\Factory;

class JurusanFactory extends Factory
{
    protected $model = Jurusan::class;

    public function definition(): array
    {
        return [
            'kode_jurusan' => $this->faker->unique()->lexify('JRSN???'),
            'nama_jurusan' => $this->faker->words(3, true),
        ];
    }
}
