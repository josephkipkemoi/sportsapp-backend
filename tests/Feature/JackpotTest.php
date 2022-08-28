<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class JackpotTest extends TestCase
{
    use WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_post_jackpot_cart()
    {
        $user = User::factory()->create();

        $response = $this->post("api/jackpot/{$user->id}/cart", [
            'jp_picked' => '{}',
            'user_id' => $user->id,
            'jp_market' => 'Five Jackpot'
        ]);

        $response->assertStatus(201);
    }

    public function test_can_get_posted_jackpot_cart()
    {
        $user = User::factory()->create();

        $this->post("api/jackpot/{$user->id}/cart", [
            'jp_picked' => '{}',
            'user_id' => $user->id,
            'jp_market' => 'Mega Jackpot'
        ]);

        $response = $this->get("api/users/jackpot/{$user->id}/history?jp=Mega Jackpot");
  
        $response->assertOk();

    }
}
