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
        return [
            'kode_mapel' => $this->faker->unique()->lexify('MP???'),
            'nama_mapel' => $this->faker->word(),
        ];
    }
}
