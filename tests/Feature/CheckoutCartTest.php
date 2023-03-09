<?php

namespace Tests\Feature;

use App\Models\Balance;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;

class CheckoutCartTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_cannot_post_final_checkout_with_less_balance_or_less_bonus()
    {
        $user = User::create([
            'phone_number' => 700545727,
            'password' => 1234
        ]);

        $user->balance()->increment('amount', 40);

        $stake_amount = $this->faker()->numberBetween(50,10000);

        $response = $this->post('api/checkout', [
            'session_id' => $this->faker()->numberBetween(10000,10000),
            'user_id' => $user->id,
            'stake_amount' => $stake_amount,
            'total_odds' => $this->faker()->numberBetween(10000,10000),
            'final_payout' => $this->faker()->numberBetween(10000,10000)
        ]);

        $response->assertJsonFragment(["message" => "Insufficient balance, please top up to continue."]);
        $response->assertStatus(400);
    }

    public function test_can_post_final_checkout_with_actual_or_greater_balance()
    {
        $user = User::create([
            'phone_number' => 700545727,
            'password' => 1234
        ]);

        $user->balance()->increment('amount', 5000);
        
        $stake_amount = 1000;

        $response = $this->post('api/checkout', [
            'session_id' => $this->faker()->numberBetween(10000,10000),
            'user_id' => $user->id,
            'stake_amount' => $stake_amount,
            'total_odds' => $this->faker()->numberBetween(10000,10000),
            'final_payout' => $this->faker()->numberBetween(10000,10000)
        ]);

        $response->assertStatus(200);
    }

    public function test_user_balance_is_decremented_after_successful_checkout()
    {
        $user = User::create([
            'phone_number' => 700545727,
            'password' => 1234
        ]);

        $user->balance()->increment('amount', 1000);
        $user->balance()->increment('bonus', 2500);
        
        $stake_amount = 1000;

        $balance = $user->balance->amount - $stake_amount;

        $response = $this->post('api/checkout', [
            'session_id' => $this->faker()->numberBetween(10000,10000),
            'user_id' => $user->id,
            'stake_amount' => $stake_amount,
            'total_odds' => $this->faker()->numberBetween(10000,10000),
            'final_payout' => $this->faker()->numberBetween(10000,10000)
        ]);

        $response->assertStatus(200);
        assertEquals($user->balance()->first()->amount, $balance);
    }
}
