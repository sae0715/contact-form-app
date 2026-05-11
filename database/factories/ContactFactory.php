<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => Category::inRandomOrder()->first()->id,
            'first_name' => fake()->unique()->firstName(),
            'last_name' => fake()->unique()->lastName(),
            'gender' => fake()->randomElement(['1', '2', '3']),
            'email' => fake()->unique()->safeEmail(),
            'tel' => fake()->numerify(fake()->randomElement(['0#########', '0##########'])),
            'address' => fake()->prefecture() . fake()->city() . fake()->streetAddress(),
            'building' => fake()->optional()->randomElement([
                fake()->word() . 'ビル',
                fake()->word() . 'アパート',
                fake()->word() . 'マンション',
                fake()->word() . '荘',
                null,
            ]),
            'detail' => fake()->sentence(),
        ];
    }
}
