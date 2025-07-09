<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Report>
 */
class ReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = $this->faker->randomElement(['daily', 'weekly', 'monthly']);
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'total_income' => $this->faker->numberBetween(1000, 5000),
            'total_expense' => $this->faker->numberBetween(500, 3000),
            'balance' => function (array $attributes) {
                return $attributes['total_income'] - $attributes['total_expense'];
            },
            'type' => $type,
            'start_date' => match ($type) {
                'daily' => $this->faker->dateTimeThisMonth()->format('Y-m-d'),
                'weekly' => $this->faker->dateTimeBetween('-1 month', 'now')->modify('last monday')->format('Y-m-d'),
                'monthly' => $this->faker->dateTimeBetween('-6 months', 'now')->modify('first day of this month')->format('Y-m-d'),
            },
            'end_date' => match ($type) {
                'daily' => function (array $attributes) {
                    return $attributes['start_date'];
                },
                'weekly' => function (array $attributes) {
                    return date('Y-m-d', strtotime($attributes['start_date'] . ' +6 days'));
                },
                'monthly' => function (array $attributes) {
                    return date('Y-m-d', strtotime($attributes['start_date'] . ' +1 month -1 day'));
                },
            },
        ];
    }
}
