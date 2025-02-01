<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;
    protected $model = User::class;

    public function definition(): array
    {

        $this->faker->locale = 'id_ID';
        $role = Role::whereNotIn('id', [1, 2])->inRandomOrder()->first();
        $username = $this->faker->unique()->userName;

        return [
            'role_id' => $role->id,
            'jns_kelamin' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'nip' => $this->faker->unique()->numberBetween(100000000000, 999999999999),
            'no_hp' => $this->faker->phoneNumber,
            'username' => $this->faker->firstName . ' ' . $this->faker->lastName,
            'password' => bcrypt($username),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
