<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BalanceTest extends TestCase
{
    // use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_account_balance_is_initialized()
    {
        $user = User::factory()->create();

        $response = $this->post("api/users/{$user->id}/balance", [
            'amount' =>  0
        ]);

        $response->assertOk();
    }

    public function test_can_get_user_balance()
    {
        $user = User::factory()->create();

        $response = $this->get("/api/users/{$user->id}/balance", [
            'x-sportsapp-key' => '8afb3240-f39f-4bc6-b697-b2faacea3199'
        ]);

        $response->assertOk();
    }

    public function test_cannot_get_user_balance_without_correct_token()
    {
        $user = User::factory()->create();

        $response = $this->get("/api/users/{$user->id}/balance", [
            'x-sportsapp-key' => 'my-keys'
        ]);

        $response->assertStatus(302);
    }
}
