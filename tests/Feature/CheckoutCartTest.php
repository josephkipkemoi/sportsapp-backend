<?php

namespace Tests\Feature;

use App\Models\User;
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

    public function test_can_get_checkout_bets()
    {
        $user = User::factory()->create();

        $betslip = $this->post('api/checkout', [
            'session_id' => $this->faker()->numberBetween(10000,10000),
            'user_id' =>  $user->id,
            'stake_amount' => $this->faker()->numberBetween(10000,10000),
            'total_odds' => $this->faker()->numberBetween(10000,10000),
            'final_payout' => $this->faker()->numberBetween(10000,10000)
        ]);
        $session_id = json_decode($betslip->getContent())->data->session_id;

        $response = $this->get("api/checkouts/users/{$user->id}/sessions/{$session_id}");
        dd($response);
        $response->assertOk();
    }

    // public function test_can_update_active_bets()
    // {
    //     $betslip = $this->post('api/checkout', [
    //         'session_id' => $this->faker()->numberBetween(10000,10000),
    //         'user_id' => $this->faker()->numberBetween(10000,10000),
    //         'stake_amount' => $this->faker()->numberBetween(10000,10000),
    //         'total_odds' => $this->faker()->numberBetween(10000,10000),
    //         'final_payout' => $this->faker()->numberBetween(10000,10000)
    //     ]);
    //     // $this->get('');
    //     $user_id = json_decode($betslip->getContent())->data->user_id;
    //     $session_id = json_decode($betslip->getContent())->data->session_id;
   

    //     // $user_id = json_decode($betslip->getContent())->data->user_id;
    //     // $session_id = json_decode($betslip->getContent())->data->session_id;

    //     // $this->patch("api/betslips/${user_id}/fixtures/${session_id}", [
    //     //     'bet_status' => 'Lost'
    //     // ]);
    // }
}
