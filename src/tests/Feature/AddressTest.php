<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Address;
use App\Models\Profile;
use App\Models\Purchase;

class AddressTest extends TestCase
{
    
    public function test_購入した商品に送付先住所が紐づいて保存される()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $user->profile()->create([
            'username' => '松山',
            'postal_code' => '123-4567',
            'address' => '広島県最高',
            'building' => 'アンビエンテ200',
        ]);
        
        $product = Product::factory()->create();

         $response = $this->post(route('purchase.store', ['id' => $product->id]), [
            'payment_method' => 'konbini',
        ]);


        $response = $this->get(route('purchase',['id' => $product->id]));

         $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'payment_method' => 'コンビニ支払い',
         ]);

        $this->assertDatabaseHas('profiles', [
            'user_id' => $user->id,
            'postal_code' => '123-4567',
            'address' => '広島県最高',
            'building' => 'アンビエンテ200',
    ]);

    }
}

