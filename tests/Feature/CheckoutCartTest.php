<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CheckoutCartTest extends TestCase
{
    use WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_post_final_checkout()
    {
        $response = $this->post('api/checkout', [
            'session_id' => $this->faker()->numberBetween(10000,10000),
            'user_id' => $this->faker()->numberBetween(10000,10000),
            'stake_amount' => $this->faker()->numberBetween(10000,10000),
            'total_odds' => $this->faker()->numberBetween(10000,10000),
            'final_payout' => $this->faker()->numberBetween(10000,10000)
        ]);

        $response->assertStatus(200);
    }

    
}
