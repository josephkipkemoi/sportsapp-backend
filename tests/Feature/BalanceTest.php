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
            'user_id' => $user->id,
            'amount' =>  100,
            'receipt_no' => 'pinaclebet'
        ], [
            'x-sportsapp-key' => '8afb3240-f39f-4bc6-b697-b2faacea3199'
        ]);
        $this->post("api/users/{$user->id}/balance", [
            'user_id' => $user->id,
            'amount' =>  200,
            'receipt_no' => 'pinaclebet'
        ], [
            'x-sportsapp-key' => '8afb3240-f39f-4bc6-b697-b2faacea3199'
        ]);
      
        $response->assertOk();
    }

    public function test_can_get_user_balance()
    {
        $user = User::factory()->create();
        $this->post("api/users/{$user->id}/balance", [
            'user_id' => $user->id,
            'amount' =>  100
        ], [
            'x-sportsapp-key' => '8afb3240-f39f-4bc6-b697-b2faacea3199'
        ]);
        $response = $this->get("/api/users/balance?user_id={$user->id}", [
            'x-sportsapp-key' => '8afb3240-f39f-4bc6-b697-b2faacea3199'
        ]);

        $response->assertOk();
    }

    public function test_can_get_all_deposit_transactions() 
    {
        $user = User::factory()->create();
        $this->post("api/users/{$user->id}/balance", [
            'user_id' => $user->id,
            'amount' =>  100
        ], [
            'x-sportsapp-key' => '8afb3240-f39f-4bc6-b697-b2faacea3199'
        ]);
        $this->post("api/users/{$user->id}/balance", [
            'user_id' => $user->id,
            'amount' =>  250
        ], [
            'x-sportsapp-key' => '8afb3240-f39f-4bc6-b697-b2faacea3199'
        ]);
        $response = $this->get("/api/users/{$user->id}/balance/deposits", [
            'x-sportsapp-key' => '8afb3240-f39f-4bc6-b697-b2faacea3199'
        ]);
 
        $response->assertOk();
    }
    public function test_cannot_get_user_balance_without_correct_token()
    {
        $user = User::factory()->create();
        $this->post("api/users/{$user->id}/balance", [
            'user_id' => $user->id,
            'amount' =>  250
        ], [
            'x-sportsapp-key' => '8afb3240-f39f-4bc6-b697-b2faacea3199'
        ]);
        $response = $this->get("/api/users/balance?user_id={$user->id}", [
            'x-sportsapp-key' => 'my-keys'
        ]);

        $response->assertStatus(302);
    }

    public function test_can_deduct_balance()
    {
        $user = User::factory()->create();

        $this->post("api/users/{$user->id}/balance", [
            'user_id' => $user->id,
            'amount' =>  250
        ], [
            'x-sportsapp-key' => '8afb3240-f39f-4bc6-b697-b2faacea3199'
        ]);

        $response =  $this->post("api/users/{$user->id}/balance/decrement", [
            'user_id' => $user->id,
            'amount' =>  50
        ], [
            'x-sportsapp-key' => '8afb3240-f39f-4bc6-b697-b2faacea3199'
        ]);

        $response->assertOk();
    }

    public function test_can_post_bet_with_bonus()
    {
        $user = User::factory()->create();

        $this->patch("api/admin/users/{$user->id}/bonus", [
            'bonus' => 50
        ]);

        $response = $this->post("api/users/{$user->id}/bonus", [
            'bonus' => 100
        ]);

        $response->assertOk();
    }
}
