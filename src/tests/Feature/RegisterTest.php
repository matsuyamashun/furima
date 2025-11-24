<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
   use RefreshDatabase;

    public function test_全て正しく入力すれば登録されプロフィール設定画面に遷移する()

    {
        $response = $this->post('/register', [
            'name' => '松山',
            'email' => 'test@icloud.com',
            'password' => 'saiko777',
            'password_confirmation' => 'saiko777',
        ]);

        $response->assertRedirect(route('profile.edit'));
        $this->assertDatabaseHas('users',[
            'email' => 'test@icloud.com',
            'name' => '松山',
        ]);
    }
}
