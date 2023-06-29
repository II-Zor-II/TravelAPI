<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'role_id' => fake()->numberBetween(1, 2),
        ];
    }

    public function admin(): Factory 
    {
        return $this->state(function (array $attributes) {
            return [
                'role_id' => 1,
            ];
        });
    }

    public function editor(): Factory 
    {
        return $this->state(function (array $attributes) {
            return [
                'role_id' => 2,
            ];
        });
    }
}
