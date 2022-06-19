<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BetslipHistoryTest extends TestCase
{
    use WithFaker;
    // use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_get_placed_bets()
    {
        $user = User::factory()->create();

        $betslip = $this->post('api/betslips', [
            'fixture_id' => 2,
            'session_id' => 1,
            'betslip_teams' => 'aa v bb',
            'betslip_market' => 'mm',
            'betslip_odds' => 2,
            'betslip_picked' => 'Home',
        ]);

        $session_id = json_decode($betslip->getContent())->data->session_id;
        
        $response = $this->get("api/users/{$session_id}/betslips");

        $response->assertStatus(200);
    }

   

    public function test_can_get_active_bets()
    {
        $user = User::factory()->create();

        $betslip = $this->post('api/betslips', [
            'fixture_id' => 2,
            'session_id' => 1,
            'betslip_teams' => 'aa v bb',
            'betslip_market' => 'mm',
            'betslip_odds' => 2,
            'betslip_picked' => 'Home',
        ]);
        $session_id = json_decode($betslip->getContent())->data->session_id;

        $this->post('api/checkout', [
            'session_id' => $session_id,
            'user_id' =>  $user->id,
            'stake_amount' => $this->faker()->numberBetween(10000,10000),
            'total_odds' => $this->faker()->numberBetween(10000,10000),
            'final_payout' => $this->faker()->numberBetween(10000,10000)
        ]);
        $this->post('api/checkout', [
            'session_id' => 3,
            'user_id' =>  $user->id,
            'stake_amount' => $this->faker()->numberBetween(10000,10000),
            'total_odds' => $this->faker()->numberBetween(10000,10000),
            'final_payout' => $this->faker()->numberBetween(10000,10000)
        ]);
        $this->patch("api/users/betslips/update?user_id={$user->id}&session_id={$session_id}", [
            'betslip_status' => 'Lost'
        ]);

        $response = $this->get("api/users/{$session_id}/betslips/status?user_id={$user->id}&bet_status=Active");

        $response->assertOk();
    }

    public function test_can_update_history_status()
    {
        $user = User::factory()->create();

        $betslip = $this->post('api/betslips', [
            'fixture_id' => 2,
            'session_id' => 1,
            'betslip_teams' => 'aa v bb',
            'betslip_market' => 'mm',
            'betslip_odds' => 2,
            'betslip_picked' => 'Home',
        ]);

        $session_id = json_decode($betslip->getContent())->data->session_id;

        $checkout_slip = $this->post('api/checkout', [
            'session_id' => $session_id,
            'user_id' =>  $user->id,
            'stake_amount' => $this->faker()->numberBetween(10000,10000),
            'total_odds' => $this->faker()->numberBetween(10000,10000),
            'final_payout' => $this->faker()->numberBetween(10000,10000)
        ]);

        $user_id = json_decode($checkout_slip->getContent())->data->user_id;

        $this->get("api/users/{$session_id}/betslips?user_id={$user_id}");

        $response =  $this->patch("api/users/betslips/update?user_id={$user_id}&session_id={$session_id}", [
            'betslip_status' => 'Lost'
        ]);

        $response->assertOk();         
    }

    public function test_can_remove_single_checkoutcart_betslip()
    {
        $user = User::factory()->create();

        $betslip = $this->post('api/betslips', [
            'fixture_id' => 2,
            'session_id' => 1,
            'betslip_teams' => 'aa v bb',
            'betslip_market' => 'mm',
            'betslip_odds' => 2,
            'betslip_picked' => 'Home',
        ]);

        $session_id = json_decode($betslip->getContent())->data->session_id;

        $this->post('api/checkout', [
            'session_id' => $session_id,
            'user_id' =>  $user->id,
            'stake_amount' => $this->faker()->numberBetween(10000,10000),
            'total_odds' => $this->faker()->numberBetween(10000,10000),
            'final_payout' => $this->faker()->numberBetween(10000,10000)
        ]);

        $response =  $this->delete("api/users/betslips/delete?user_id={$user->id}&session_id={$session_id}");

        $response->assertOk();
    }

    public function test_can_search_by_date_field()
    {
        $user = User::factory()->create();

        $betslip = $this->post('api/betslips', [
            'fixture_id' => 2,
            'session_id' => 1,
            'betslip_teams' => 'aa v bb',
            'betslip_market' => 'mm',
            'betslip_odds' => 2,
            'betslip_picked' => 'Home',
        ]);

        $session_id = json_decode($betslip->getContent())->data->session_id;

        $this->post('api/checkout', [
            'session_id' => $session_id,
            'user_id' =>  $user->id,
            'stake_amount' => $this->faker()->numberBetween(10000,10000),
            'total_odds' => $this->faker()->numberBetween(10000,10000),
            'final_payout' => $this->faker()->numberBetween(10000,10000)
        ]);

        $response =  $this
        ->get("api/users/betslips/search?user_id={$user->id}&session_id={$session_id}&from_date=2022-06-18&to_date=2022-06-19");

        $response->assertOk();
    }   

}
