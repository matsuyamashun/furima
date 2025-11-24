<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Purchase;

class PurchaseTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_支払い方法選択が小計画面に反映される()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $this->actingAs($user);

    
        $response = $this->get(route('purchase', ['id' => $product->id]));
        $response->assertStatus(200);

    
        $response = $this->post(route('purchase.store', ['id' => $product->id]), [
        'payment_method' => 'konbini',
        ]);

    
        $response->assertRedirect(route('purchase.success', ['id' => $product->id]));

    
        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'payment_method' => 'コンビニ支払い', 
        ]);
    }

}


