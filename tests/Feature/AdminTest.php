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

    public function test_can_post_custom_fixture()
    {
        $response = $this->post('api/admin/fixture', [
            'fixture_id' => $this->faker()->numberBetween(1,100000),
            'fixture_date' => $this->faker()->date(),
            'league_name' => $this->faker()->word(),
            'country' => $this->faker()->word(),
            'home_team' => $this->faker()->word(),
            'away_team' => $this->faker()->word(),
            'home_odds' => $this->faker()->numberBetween(1,4),
            'draw_odds' => $this->faker()->numberBetween(2,5),
            'away_odds' => $this->faker()->numberBetween(3,6),
        ]);

        $response->assertOk();
    }
}
