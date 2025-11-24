<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Profile;

class ProfileTest extends TestCase
{
    public function test_プロフィール編集ページに初期値が表示される()
{
    $user = User::factory()->create();
    $this->actingAs($user);

    $user->profile()->create([
        'username' => '松山',
        'avatar' => 'test-avatar.png',
        'postal_code' => '123-4567',
        'address' => '広島県さいこう',
        'building' => 'テストマンション101',
    ]);

    $response = $this->get(route('profile.edit'));

    $response->assertSee('松山');
    $response->assertSee('123-4567');
    $response->assertSee('広島県さいこう');
    $response->assertSee('テストマンション101');
    $response->assertSee('test-avatar.png');
}

}