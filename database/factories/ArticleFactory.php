<?php

namespace Database\Factories;
 
use Illuminate\Database\Eloquent\Factories\Factory;
 
class ArticleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'           => $this->faker->words(3, true),
            'nb_stock'       => $this->faker->numberBetween(0, 200),
            'origin_country' => $this->faker->country(),
            'unit_price'     => $this->faker->randomFloat(2, 0.50, 500),
            'discount'       => $this->faker->randomFloat(2, 0, 30),
            'tva'            => $this->faker->randomElement([5.5, 10, 20]),
        ];
    }
}
 