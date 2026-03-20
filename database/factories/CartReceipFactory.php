<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\Receip;
use Illuminate\Database\Eloquent\Factories\Factory;

class CartReceipFactory extends Factory
{
    public function definition(): array
    {
        return [
            'cart_id'   => Cart::factory(),
            'receip_id' => Receip::factory(),
        ];
    }
}