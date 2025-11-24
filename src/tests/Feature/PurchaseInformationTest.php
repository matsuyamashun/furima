<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\UploadedFile;


class PurchaseInformationTest extends TestCase
{
    public function test_商品出品情報が保存される()
{
    $user = User::factory()->create();
    $this->actingAs($user);

    $category = Category::factory()->create();

    $file = UploadedFile::fake()->image('test-image.png');

    $response = $this->post(route('sell.store'), [
        'name'        => 'テスト商品',
        'price'       => 5000,
        'brand'       => 'テストブランド',
        'description' => 'これはテスト用の商品説明です。',
        'image'       => $file, 
        'condition'   => '新品',
        'categories'  => [$category->id],
    ]);

    $response->assertRedirect();

    $product = Product::latest()->first();

    $this->assertDatabaseHas('products', [
        'user_id'     => $user->id,
        'name'        => 'テスト商品',
        'price'       => 5000,
        'brand'       => 'テストブランド',
        'description' => 'これはテスト用の商品説明です。',
        'condition'   => '新品',
        'is_sold'     => false,
    ]);

    $this->assertDatabaseHas('category_product', [
        'product_id'  => $product->id,
        'category_id' => $category->id,
    ]);
}

}


