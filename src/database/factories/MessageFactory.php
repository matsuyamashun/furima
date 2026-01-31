<?php

namespace Database\Factories;

use App\Models\Message;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    protected $model = Message::class;

    public function definition()
    {
        return [
            'transaction_id' => Transaction::factory(),
            'sender_id' => User::factory(),
            'chat' => $this->faker->sentence(),
            'is_read' => false,
        ];
    }
}
