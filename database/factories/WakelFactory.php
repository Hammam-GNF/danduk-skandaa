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
        $user = User::where('role_id', 3)
        ->whereNotIn('id', Wakel::pluck('user_id')->toArray())
        ->inRandomOrder()
        ->first();


        $kelas = Kelas::whereDoesntHave('wakel')
            ->inRandomOrder()
            ->first();

        return [
            'user_id' => $user?->id,
            'kelas_id' => $kelas->id,
        ];
    }
}
