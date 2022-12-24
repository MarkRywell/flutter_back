<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake('en_US')->words(2, true),
            'details'=>fake()->sentence(),
            'userId' => User::inRandomOrder()->first(),
            'sold' => 'Available',
            'picture' => '/assets/pics',
        ];
    }
}
