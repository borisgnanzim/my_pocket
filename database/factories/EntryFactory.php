<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Entry>
 */
class EntryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = $this->faker->randomElement(['income', 'expense']);
        return [
            'type' => $type,
            'amount' => $this->faker->numberBetween(1, 1000),
            'description' => $this->faker->sentence(),
            'date' => $this->faker->date(),
            'user_id' => User::inRandomOrder()->first()->id,
            'origin' => $this->faker->randomElement(['bank', 'cash', 'card']),
            'category' => $this->faker->randomElement(['salary', 'food', 'transport', 'entertainment', 'bills', 'health', 'clothing', 'education', 'other']),
           // 'currency' => $this->faker->randomElement(['USD', 'EUR', 'GBP', 'JPY', 'AUD', 'CAD', 'CHF', 'CNY', 'SEK', 'NZD'])
        ];
    }

    /**
     * State for income entries.
     */
    public function income()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'income',
                'origin' => $this->faker->randomElement(['salary', 'investment', 'gift', 'other']),
                'category' => null,
            ];
        });
    }

     /**
     * State for expense entries.
     */
    public function expense()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'expense',
                'origin' => null,
                'category' => $this->faker->randomElement(['food', 'transport', 'entertainment', 'bills', 'health', 'clothing', 'education', 'other']),
            ];
        });
    }
}
