<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Favorite;

class FavoriteTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_いいね解除できる()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $this->actingAs($user)
            ->post(route('favorite.store',$product->id));

        $this->actingAs($user)
            ->delete(route('favorite.destroy',$product->id));

        $this->assertDatabaseMissing('favorites',[
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
    }
}
