<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\Comment;

class ItemTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_商品詳細ページに複数カテゴリが表示される()
    {
        $user = User::factory()->create();

        $product = Product::factory()->create();

        $cat1 = Category::factory()->create(['name' => 'メンズ']);
        $cat2 = Category::factory()->create(['name' => 'ファッション']);
        $product->categories()->attach([$cat1->id,$cat2->id]); 

        $response = $this->actingAs($user)->get(route('item',$product->id));

        $response->assertStatus(200);

    
        $response->assertSee('メンズ');
        $response->assertSee('ファッション');
    }
}
