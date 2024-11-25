<?php

namespace Database\Factories\Admin;

use App\Models\Admin\TahunAjaran;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class TahunAjaranFactory extends Factory
{
    protected $model = TahunAjaran::class;

    public function definition()
    {
        return [
            'thajaran' => $this->faker->year() . '/' . ($this->faker->year() + 1), 
            'semester' => $this->faker->randomElement(['Ganjil', 'Genap']),
            'status' => 'nonaktif', 
        ];
    }

    public function aktif()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'aktif',
            ];
        });
    }
}
