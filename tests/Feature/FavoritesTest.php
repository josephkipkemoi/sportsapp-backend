<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FavoritesTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_post_user_favorites()
    {
        $user = User::factory()->create();

        $response = $this->post("api/favorites", [
            'user_id' => $user->id,
            'fixture_id' => 100,
        ]);
        $this->post("api/favorites", [
            'user_id' => $user->id,
            'fixture_id' => 100,
        ]);
        $favorites = $this->get("api/users/{$user->id}/favorites");
        dd($favorites);
        $response->assertStatus(200);
    }

    public function test_can_get_favorites()
    {
        $user = User::factory()->create(); 

        $this->post("api/favorites", [
            'user_id' => $user->id,
            'fixture_id' => 100,
        ]);

        $response = $this->get("api/users/{$user->id}/favorites");

        $response->assertOk();
    }
}
