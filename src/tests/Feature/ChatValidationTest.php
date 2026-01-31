<?php

namespace Tests\Feature;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChatValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_本文未入力の場合エラーが表示される()
    {
        $user = User::factory()->create();
        $transaction = Transaction::factory()->create();

        $response = $this->actingAs($user)->post(
            route('chat', $transaction->id),
            ['chat' => '']
        );

        $response->assertSessionHasErrors(['chat']);
        $this->assertStringContainsString(
            '本文を入力してください',
            session('errors')->first('chat')
        );
    }

    public function test_本文が401文字以上だとエラーになる()
    {
        $user = User::factory()->create();
        $transaction = Transaction::factory()->create();

        $longText = str_repeat('a', 401);

        $response = $this->actingAs($user)->post(
            route('chat', $transaction->id),
            ['chat' => $longText]
        );

        $response->assertSessionHasErrors(['chat']);
    }

    public function test_png_jpeg以外の画像はエラーになる()
    {

        $user = User::factory()->create();
        $transaction = Transaction::factory()->create();

        $file = UploadedFile::fake()->create('test.pdf', 100);

        $response = $this->actingAs($user)->post(
            route('chat', $transaction->id),
            [
                'chat' => 'テスト',
                'image' => $file,
            ]
        );

        $response->assertSessionHasErrors(['image']);
    }
}
