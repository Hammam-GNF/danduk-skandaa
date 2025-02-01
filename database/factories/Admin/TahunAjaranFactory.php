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
        $startYear = 2020;
        $currentYear = now()->year;

        $thajaran = $startYear . '/' . ($startYear + 1);
        
        return [
            'thajaran' => $thajaran,
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
