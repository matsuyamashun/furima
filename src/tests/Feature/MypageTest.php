<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;

class MypageTest extends TestCase
{
    public function test_マイページで出品商品が表示される()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $user->profile()->create([
            'username' => '松山',
            'avatar' => 'test-avatar.png',
            'postal_code' => '123-4567',
            'address' => '広島県さいこう',
        ]);

        $sellProduct = Product::factory()->create([
            'user_id' => $user->id,
            'name' => '出品商品A',
        ]);

        $response = $this->get(route('mypage',['tab' => 'buy']));

        $response->assertSee($user->name);
        $response->assertSee('test-avatar.png');
        $response->assertSee('出品商品A');
    }

    public function test_マイページで購入商品が表示される()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $user->profile()->create([
            'username' => '松山',
            'avatar' => 'test-avatar.png',
            'postal_code' => '123-4567',
            'address' => '広島県さいこう',
        ]);

        $buyProduct = Product::factory()->create([
            'name' => '購入商品B',
        ]);
        $user->purchasedProducts()->attach($buyProduct->id, ['payment_method' => 'コンビニ支払い']);

        $response = $this->get(route('mypage',['tab' => 'sell']));

        $response->assertSee($user->name);
        $response->assertSee('test-avatar.png');
        $response->assertSee('購入商品B');
}
}