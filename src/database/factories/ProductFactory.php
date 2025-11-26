<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;


class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'price' => $this->faker->numberBetween(1000, 10000),
            'condition' => $this->faker->randomElement([
                '良好',
                '目立った傷や汚れなし',
                'やや傷や汚れあり',
                '状態が悪い',
            ]),
            'user_id' => User::factory(), 
            'image_url' => 'https://placehold.co/250x250?text=' . urlencode($this->faker->word),
            'is_sold' => false,

        ];
    }
}
