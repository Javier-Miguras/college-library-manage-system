<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $totalAuthors = Author::all()->count();
        $totalCategories = Category::all()->count();

        return [
            'isbn' => fake()->numerify('978-#-##-#####-#'),
            'title' => fake()->sentence(fake()->numberBetween(1, 5)),
            'summary' => fake()->text(),
            'publication_year' => fake()->numberBetween(1200, 2020),
            'author_id' => fake()->numberBetween(1, $totalAuthors),
            'category_id' => fake()->numberBetween(1, $totalCategories),
        ];
    }
}
