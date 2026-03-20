<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

class CartFactory extends Factory
{
    public function definition(): array
    {
        return [
            'article_id' => Article::factory(),
            'number'     => $this->faker->numberBetween(1, 20),
        ];
    }
}