<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BetslipHistoryTest extends TestCase
{
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
        
        $response = $this->get("api/users/{$user->id}/betslips/{$session_id}");

        $response->assertStatus(200);
    }
}
