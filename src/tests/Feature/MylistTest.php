<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;
use App\Models\User;
use App\Models\Favorite;
use App\Models\Purchase;

class MylistTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_未認証の場合はマイリストは表示されずログインへリダイレクトされる()
{
    $response = $this->get('/mylist');

    $response->assertRedirect('/login');
}
}


