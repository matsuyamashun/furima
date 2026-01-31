<?php

namespace Database\Factories;

use App\Models\Review;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition()
    {
        return [
            'transaction_id' => Transaction::factory(),
            'reviewed_id' => User::factory(),
            'reviewer_id' => User::factory(),
            'rating' => $this->faker->numberBetween(1, 5),
        ];
    }
}
