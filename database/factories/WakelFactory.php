<?php

namespace Database\Factories;

use App\Models\Admin\Kelas;
use App\Models\User;
use App\Models\Wakel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class WakelFactory extends Factory
{
    protected $model = Wakel::class;

    public function definition()
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'kelas_id' => Kelas::inRandomOrder()->first()->id,
        ];
    }
}
