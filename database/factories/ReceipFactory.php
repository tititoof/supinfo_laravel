<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReceipFactory extends Factory
{
    public function definition(): array
    {
        return [
            'users_id' => User::factory(),
        ];
    }
}