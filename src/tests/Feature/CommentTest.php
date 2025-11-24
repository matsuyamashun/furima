<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Comment;

class CommentTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_コメントが255字以上の時バリデーションエラーになる()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $this->actingAs($user);

        $longComment = str_repeat('あ', 256);

        $response = $this->post(route('comment.store', ['id' => $product->id]),[
            'content' => $longComment
        ]);

        $response->assertSessionHasErrors(['content']);

        $this->assertDatabaseMissing('comments',[
            'product_id' => $product->id,
            'user_id' => $user->id,
        ]);
    }
}