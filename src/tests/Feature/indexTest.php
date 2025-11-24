<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product; 
use App\Models\User;



class indexTest extends TestCase
{
     use RefreshDatabase;


public function test_自分が出品した商品は一覧に表示されない()
{
    $user = User::factory()->create();
    $otherUser = User::factory()->create();

    Product::factory()->create([
        'user_id' => $user->id,
        'name' => '自分の商品',
        'is_sold' => false,
    ]);

    Product::factory()->create([
        'user_id' => $otherUser->id,
        'name' => '他人の商品',
        'is_sold' => false,
    ]);

    $response = $this->actingAs($user,'web')->get('/');


    $response->assertStatus(200);
    $response->assertSee('他人の商品');
    $response->assertDontSee('自分の商品');
}


}
