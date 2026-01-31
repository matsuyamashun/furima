<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use App\Mail\TransactionCompletedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RatingMailTest extends TestCase
{
    use RefreshDatabase;

    public function test_取引完了時に出品者へメールが送信される()
    {
        Mail::fake();

        $buyer = User::factory()->create();
        $seller = User::factory()->create();
        $product = Product::factory()->create([
            'user_id' => $seller->id,
        ]);

        $transaction = Transaction::factory()->create([
            'product_id' => $product->id,
            'buyer_id' => $buyer->id,
            'seller_id' => $seller->id,
            'status' => 'processing',
        ]);

        // 購入者として取引完了
        $this->actingAs($buyer)->post(route('transaction.complete', $transaction->id));

        Mail::assertSent(TransactionCompletedMail::class, function ($mail) use ($seller) {
            return $mail->hasTo($seller->email);
        });
    }
}
