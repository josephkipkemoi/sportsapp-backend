<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_get_all_registered_users()
    {
        $user = User::factory()->create();
        $user = User::factory()->create();
        $user = User::factory()->create();

        $response = $this->get('api/admin/users');
 
        $response->assertStatus(200);
    }

    public function test_can_get_user_balance()
    {
        $user = User::factory()->create();

        $response = $this->get("api/admin/users/{$user->id}/profile");

        $response->assertOk();
    }

    public function test_can_update_user_bet_history()
    {
        $user = User::factory()->create();

        $checkout = $this->post('api/checkout', [
            'session_id' => $this->faker()->numberBetween(1000,10000),
            'user_id' => $user->id,
            'stake_amount' => $this->faker()->numberBetween(1000,10000),
            'total_odds' => $this->faker()->numberBetween(1000,10000),
            'final_payout' => $this->faker()->numberBetween(1000,10000)
        ]);

        $response = $this->patch("api/admin/users/{$user->id}/bets/{$checkout->getData()->data->session_id}/update", [
            'bet_status' => 'Lost'
        ]);

        $response->assertOk();
    }

    public function test_can_update_user_balance()
    {
        $user = User::factory()->create();

        $response = $this->patch("api/admin/users/{$user->id}/balance/update", [
            'amount' => 250
        ]);

        $response->assertOk();
    }

    public function test_can_update_fixture_team_names()
    {
        $response = $this->patch('api/admin/fixture', [
            'league_name' => $this->faker()->word(),
            'country' => $this->faker()->word(),
            'home' => $this->faker()->word(),
            'away' => $this->faker()->word(),
        ]);

        $response->assertOk();
    }

    public function test_can_get_fixture_ids()
    {
        $response = $this->get('api/admin/fixtures/ids');

        $response->assertOk();
    }

    public function test_can_remove_all_fixture()
    {
        $response = $this->delete('api/admin/fixtures/remove');

        $response->assertOk();
    }

    public function test_can_post_jackpot_games()
    {
        $response = $this->post('api/admin/jackpots', [
            'jp_time' => $this->faker()->time(),
            'jp_home' => $this->faker()->word(6),
            'jp_away' => $this->faker()->word(4),
            'jp_home_odds' => $this->faker()->numberBetween(1,3),
            'jp_draw_odds' => $this->faker()->numberBetween(2,4),
            'jp_away_odds' => $this->faker()->numberBetween(1,3)
        ]);

        $response->assertOk();
    }
}
