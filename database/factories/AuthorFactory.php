<?php

namespace Database\Factories;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Author>
 */
class AuthorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $totalCountries = Country::all()->count();

        return [
            'name' => fake()->firstName(),
            'lastname' => fake()->lastName(),
            'country_id' => fake()->numberBetween(1, $totalCountries)
        ];
    }
}
