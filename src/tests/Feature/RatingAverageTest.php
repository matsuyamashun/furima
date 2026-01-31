<?php

namespace Tests\Feature;

use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RatingAverageTest extends TestCase
{
    use RefreshDatabase;

    public function test_プロフィール画面で評価平均が表示されれ四捨五入される()
    {
        $user = User::factory()->create();
        $reviewer = User::factory()->create();

        Review::factory()->create([
            'reviewed_id' => $user->id,
            'reviewer_id' => $reviewer->id,
            'rating' => 4,
        ]);

        Review::factory()->create([
            'reviewed_id' => $user->id,
            'reviewer_id' => User::factory()->create()->id,
            'rating' => 5,
        ]);

        $response = $this->actingAs($user)->get(route('mypage'));

        $response->assertSee('5');//4.5->5
    }

    public function test_評価ないときは何も表示されん()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('mypage'));

        $response->assertSee('⭐');
    }
}
