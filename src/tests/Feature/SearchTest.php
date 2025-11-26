<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Favorite;

class SearchTest extends TestCase
{
    public function test_検索状態がマイリストでも保持される()
{
    $user = User::factory()->create();

    $p1 = Product::factory()->create(['name' => 'りんごジュース']);
    $p2 = Product::factory()->create(['name' => 'みかんジュース']);

    $user->favoriteProducts()->attach($p1->id);

    $this->actingAs($user)->get('/?search=りん');

    $response = $this->get('/mylist');

    $response->assertStatus(200);

    $response->assertSee('りんごジュース');
    $response->assertDontSee('みかんジュース');
}

}
