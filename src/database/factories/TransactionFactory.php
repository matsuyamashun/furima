<?php

namespace Database\Factories;

use App\Models\Transaction;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition()
    {
        return [
            'product_id' => Product::factory(),
            'seller_id'  => User::factory(),
            'buyer_id'   => User::factory(),
            'status'     => 'processing',
        ];
    }
}