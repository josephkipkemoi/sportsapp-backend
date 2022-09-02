<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FavoritesTest extends TestCase
{
    // use RefreshDatabase;
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
 
        $response->assertStatus(201);
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

    public function test_can_remove_all_favorites()
    {
        $user = User::factory()->create(); 

        $this->post("api/favorites", [
            'user_id' => $user->id,
            'fixture_id' => 100,
        ]);

        $response = $this->delete("api/users/{$user->id}/favorites/remove");

        $response->assertOk();
    }

    public function test_can_remove_single_favorite_game()
    {
        $user = User::factory()->create(); 

        $fixture = $this->post("api/favorites", [
            'user_id' => $user->id,
            'fixture_id' => 100,
        ]);

        $fixture_id = json_decode($fixture->getContent())->fixture_id;

        $response = $this->delete("api/users/{$user->id}/favorites/{$fixture_id}/remove");

        $response->assertOk();
    }
}
