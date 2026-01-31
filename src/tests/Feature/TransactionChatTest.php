<?php

namespace Tests\Feature;

use App\Models\Message;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionChatTest extends TestCase
{
    use RefreshDatabase;

    public function test_マイページから取引中の商品を確認できる()
    {
        $user = User::factory()->create();

        $product = Product::factory()->create([
            'user_id' => $user->id,
        ]);

        Transaction::factory()->create([
            'product_id' => $product->id,
            'seller_id' => $user->id,
            'buyer_id' => User::factory()->create()->id,
            'status' => 'processing',
        ]);

        $response = $this->actingAs($user)->get(route('mypage', ['tab'=> 'processing']));

        $response->assertStatus(200);
    }

    public function test_マイページで取引メッセージの未読件数が確認できる()
    {
        $user = User::factory()->create();
        $partner = User::factory()->create();

        $transaction = Transaction::factory()->create([
            'buyer_id' => $user->id,
            'seller_id' => $partner->id,
            'status' => 'processing',
        ]);

        Message::factory()->create([
            'transaction_id' => $transaction->id,
            'sender_id' => $partner->id,
            'is_read' => false,
        ]);

        Message::factory()->create([
            'transaction_id' => $transaction->id,
            'sender_id' => $user->id,
            'is_read' => true,
        ]);

        $this->actingAs($user)
            ->get(route('mypage', ['tab' => 'processing']))
            ->assertSee('1'); // 未読は1件
    }

    public function test_マイページの取引中の商品を押下すると取引チャット画面へ遷移できる()
    {
        $user = User::factory()->create();
        $partner = User::factory()->create();

        $product = Product::factory()->create([
            'user_id' => $partner->id,
        ]);

        $transaction = Transaction::factory()->create([
            'product_id' => $product->id,
            'seller_id' => $partner->id,
            'buyer_id' => $user->id,
            'status' => 'processing',
        ]);

        // マイページ表示
        $response = $this->actingAs($user)->get(route('mypage', ['tab' => 'processing']));

        $response->assertSee(route('chat', $transaction->id));

        $this->actingAs($user)
            ->get(route('chat', $transaction->id))
            ->assertStatus(200)
            ->assertSee($product->name);
    }

    public function test_取引チャット画面のサイドバーから別取引へ遷移できる()
    {
        $user = User::factory()->create();
        $partner = User::factory()->create();

        $product1 = Product::factory()->create([
            'user_id' => $partner->id,
            'name' => '商品A',
        ]);

        $product2 = Product::factory()->create([
            'user_id' => $partner->id,
            'name' => '商品B',
        ]);

        $transaction1 = Transaction::factory()->create([
            'product_id' => $product1->id,
            'seller_id' => $partner->id,
            'buyer_id' => $user->id,
            'status' => 'processing',
        ]);

        $transaction2 = Transaction::factory()->create([
            'product_id' => $product2->id,
            'seller_id' => $partner->id,
            'buyer_id' => $user->id,
            'status' => 'processing',
        ]);

        $response = $this->actingAs($user)->get(route('chat', $transaction1->id));

        $response->assertSee($product2->name);

        $response->assertSee(route('chat', $transaction2->id));
    }

    public function test_取引中の商品は新規メッセージ順に並ぶ()
    {
        $user = User::factory()->create();
        $partner = User::factory()->create();

        $productA = Product::factory()->create(['user_id' => $partner->id]);

        $productB = Product::factory()->create(['user_id' => $partner->id]);

        $transactionA = Transaction::factory()->create([
            'product_id' => $productA->id,
            'seller_id' => $partner->id,
            'buyer_id' => $user->id,
            'status' => 'processing',
        ]);

        $transactionB = Transaction::factory()->create([
            'product_id' => $productB->id,
            'seller_id' => $partner->id,
            'buyer_id' => $user->id,
            'status' => 'processing',
        ]);

        Message::factory()->create([
            'transaction_id' => $transactionA->id,
            'sender_id' => $partner->id,
            'created_at' => now()->subMinutes(10),
        ]);

        Message::factory()->create([
            'transaction_id' => $transactionB->id,
            'sender_id' => $partner->id,
            'created_at' => now(),
        ]);

        $response = $this->actingAs($user)->get(route('mypage', ['tab' => 'processing']));

        $response->assertSeeInOrder([
            $productA->name,
            $productB->name,
        ]);
    }

    public function test_取引中の商品に未読メッセージ数が表示される()
    {
        $user = User::factory()->create();
        $partner = User::factory()->create();

        $product = Product::factory()->create([
            'user_id' => $partner->id
        ]);

        $transaction = Transaction::factory()->create([
            'product_id' => $product->id,
            'seller_id' => $partner->id,
            'buyer_id' => $user->id,
            'status' => 'processing',
        ]);

        Message::factory()->count(2)->create([
            'transaction_id' => $transaction->id,
            'sender_id' => $partner->id,
            'is_read' => false,
        ]);

        Message::factory()->create([
            'transaction_id' => $transaction->id,
            'sender_id' => $partner->id,
            'is_read' => true,
        ]);

        $response = $this->actingAs($user)->get(route('mypage', ['tab' => 'processing']));

        $response->assertSee('2');
    }
}

