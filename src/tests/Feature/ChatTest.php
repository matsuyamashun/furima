<?php

namespace Tests\Feature;

use App\Models\Message;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

class ChatTest extends TestCase
{
    use RefreshDatabase;

    public function test_投稿済みのメッセージ編集できる()
    {
        $user = User::factory()->create();
        $transaction = Transaction::factory()->create([
            'buyer_id' => $user->id,
        ]);

        $message = Message::factory()->create([
            'transaction_id' => $transaction->id,
            'sender_id' => $user->id,
            'chat' => 'いい商品',
        ]);

        $response = $this->actingAs($user)->put(
            route('chat.update', $message->id),['chat' =>'最高の商品']
        );

        $this->assertDatabaseHas('messages', [
            'id' => $message->id,
            'chat'=>'最高の商品',
        ]);
    }

    public function test_投稿済みのメッセージ削除できる()
    {
        $user = User::factory()->create();
        $transaction = Transaction::factory()->create([
            'buyer_id' => $user->id,
        ]);

        $message = Message::factory()->create([
            'transaction_id' => $transaction->id,
            'sender_id' => $user->id,
            'chat' => 'いい商品',
        ]);

        $response = $this->actingAs($user)->delete(
            route('chat.destroy', $message->id),
        );

        $this->assertDatabaseMissing('messages', [
            'id' => $message->id,
        ]);
    }
}
