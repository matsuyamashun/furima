<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Review;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RatingTest extends TestCase
{
    use RefreshDatabase;

    public function test_購入者は取引後に評価できる()
    {
        $buyer = User::factory()->create();
        $seller = User::factory()->create();
        $product = Product::factory()->create(['user_id' => $seller->id]);

        $transaction = Transaction::factory()->create([
            'product_id' => $product->id,
            'buyer_id' => $buyer->id,
            'seller_id' => $seller->id,
            'status' => 'completed',
        ]);

        $response = $this->actingAs($buyer)->post(route('reviews'), [
            'transaction_id' => $transaction->id,
            'rating' => 5,
        ]);

        $this->assertDatabaseHas('reviews', [
            'transaction_id' => $transaction->id,
            'reviewer_id' => $buyer->id,
            'reviewed_id' => $seller->id,
            'rating' => 5,
        ]);
    }

    public function test_出品者も取引後に評価できる()
    {
        $buyer = User::factory()->create();
        $seller = User::factory()->create();
        $product = Product::factory()->create(['user_id' => $seller->id]);

        $transaction = Transaction::factory()->create([
            'product_id' => $product->id,
            'buyer_id' => $buyer->id,
            'seller_id' => $seller->id,
            'status' => 'completed',
        ]);

        Review::factory()->create([
            'transaction_id' => $transaction->id,
            'reviewer_id' => $buyer->id,
            'reviewed_id' => $seller->id,
        ]);

        $response = $this->actingAs($seller)->post(route('reviews'), [
            'transaction_id' => $transaction->id,
            'rating' => 4,
        ]);

        $this->assertDatabaseHas('reviews', [
            'transaction_id' => $transaction->id,
            'reviewer_id' => $seller->id,
            'reviewed_id' => $buyer->id,
            'rating' => 4,
        ]);
    }

    public function test_出品者が評価後に商品一覧へ遷移する()
    {
        $buyer = User::factory()->create();
        $seller = User::factory()->create();
        $product = Product::factory()->create(['user_id' => $seller->id]);

        $transaction = Transaction::factory()->create([
            'product_id' => $product->id,
            'buyer_id' => $buyer->id,
            'seller_id' => $seller->id,
            'status' => 'completed',
        ]);

        // 購入者の評価を先に作る
        Review::factory()->create([
            'transaction_id' => $transaction->id,
            'reviewer_id' => $buyer->id,
            'reviewed_id' => $seller->id,
        ]);

        $response = $this->actingAs($seller)->post(route('reviews'), [
            'transaction_id' => $transaction->id,
            'rating' => 4,
        ]);

        $response->assertRedirect(route('index'));
    }
}
