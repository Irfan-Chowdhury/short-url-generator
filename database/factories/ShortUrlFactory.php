<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


class ShortUrlFactory extends Factory
{
    public function definition(): array
    {
        return [
            'original_url' => fake()->url,
            'short_code' => Str::random(6),
            'click_count' => fake()->numberBetween($min = 5, $max = 100),
        ];
    }
}
