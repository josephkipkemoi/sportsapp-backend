<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BetslipTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_post_betslip()
    {
        $response = $this->post('api/betslips', [
            'fixture_id' => 2,
            'session_id' => 1,
            'betslip_teams' => 'aa v bb',
            'betslip_market' => 'mm',
            'betslip_odds' => 2,
            'betslip_picked' => 'Home',
        ]);

        $response->assertStatus(200);
    }

    public function test_can_get_betslip()
    {
        $betslip = $this->post('api/betslips', [
            'fixture_id' => 2,
            'session_id' => 1,
            'betslip_teams' => 'aa v bb',
            'betslip_market' => 'mm',
            'betslip_odds' => 2,
            'betslip_picked' => 'Home',
        ]);
        $session_id = json_decode($betslip->getContent())->data->session_id;

        $response = $this->get("api/betslips/${session_id}");
        
        $response->assertOk();
    }

    public function test_can_delete_single_betslip()
    {
        $betslip = $this->post('api/betslips', [
            'fixture_id' => 2,
            'session_id' => 1,
            'betslip_teams' => 'aa v bb',
            'betslip_market' => 'mm',
            'betslip_odds' => 2,
            'betslip_picked' => 'Home',
        ]);

        $fixture_id = json_decode($betslip->getContent())->data->fixture_id;

        $response = $this->delete("api/betslips/fixtures/{$fixture_id}");

        $response->assertOk();
    }

    public function test_can_remove_all_betslip()
    {
        $betslip = $this->post('api/betslips', [
            'fixture_id' => 2,
            'session_id' => 1,
            'betslip_teams' => 'aa v bb',
            'betslip_market' => 'mm',
            'betslip_odds' => 2,
            'betslip_picked' => 'Home',
        ]);

        $session_id = json_decode($betslip->getContent())->data->session_id;

        $response = $this->delete("api/betslips/sessions/{$session_id}");

        $response->assertOk();
    }
}
