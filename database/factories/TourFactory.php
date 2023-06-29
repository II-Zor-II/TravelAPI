<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tour>
 */
class TourFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $startDate = fake()->dateTimeBetween('-1 year', '+1 year'); // Generate a random start date

        $endDate = Carbon::createFromFormat('Y-m-d H:i:s', $startDate)
        ->addWeeks(
            fake()->numberBetween(1,3)
        );

        return [
            'name' => fake()->country() . fake()->word() . ' Tour',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'price' => fake()->numberBetween(1000, 10000),
            'currency' => fake()->randomElement([
                'USD', 'EUR', 'YEN'
            ]),
        ];
    }
}
