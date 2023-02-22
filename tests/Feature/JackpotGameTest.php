<?php

namespace Tests\Feature;

use App\Models\JackpotMarket;
use App\Models\JackpotMarketModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class JackpotGameTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_post_jacpot_game()
    {
        $market = JackpotMarketModel::create([
            'market' => 'Mega Jackpot',
            'market_prize' => 1000,
            'market_id' => 201
        ]);

        $response = $this->post("api/jackpots/markets/{$market->market_id}/games", [
            'jackpot_market_id' => $market->market_id,
            'home_team' => $this->faker()->word(),
            'away_team' => $this->faker()->word(),
            'home_odds' => $this->faker()->numberBetween(1,5),
            'draw_odds' => $this->faker()->numberBetween(1,5),
            'away_odds' => $this->faker()->numberBetween(1,5),
            'kick_off_time' => $this->faker()->date()
        ]);

        $response->assertStatus(201);
    }

    public function test_can_get_jackpot_games()
    {
        $market = JackpotMarketModel::create([
            'market' => 'Mega Jackpot',
            'market_prize' => 1000,
            'market_id' => 201
        ]);

       $market->jackpotgames()->create([
            'jackpot_market_id' => $market->market_id,
            'home_team' => $this->faker()->word(),
            'away_team' => $this->faker()->word(),
            'home_odds' => $this->faker()->numberBetween(1,5),
            'draw_odds' => $this->faker()->numberBetween(1,5),
            'away_odds' => $this->faker()->numberBetween(1,5),
            'kick_off_time' => $this->faker()->date()
        ]);

        $market->jackpotgames()->create([
            'jackpot_market_id' => $market->market_id,
            'home_team' => $this->faker()->word(),
            'away_team' => $this->faker()->word(),
            'home_odds' => $this->faker()->numberBetween(1,5),
            'draw_odds' => $this->faker()->numberBetween(1,5),
            'away_odds' => $this->faker()->numberBetween(1,5),
            'kick_off_time' => $this->faker()->date()
        ]);

        $response = $this->get("api/jackpots/$market->market_id/games");

        $response->assertOk();
    }

    public function test_can_update_jackpot_market_active_after_first_game_has_started()
    {
        $market = JackpotMarketModel::create([
            'market' => 'Mega Jackpot',
            'market_prize' => 1000,
            'market_id' => 201
        ]);

       $market->jackpotgames()->create([
            'jackpot_market_id' => $market->market_id,
            'home_team' => $this->faker()->word(),
            'away_team' => $this->faker()->word(),
            'home_odds' => $this->faker()->numberBetween(1,5),
            'draw_odds' => $this->faker()->numberBetween(1,5),
            'away_odds' => $this->faker()->numberBetween(1,5),
            'kick_off_time' => '2023-02-19 18:58'
        ]);

        $response = $this->patch("api/jackpots/$market->market_id/patch", [
            'market_active' => false
        ]);

        $response->assertOk();
    }
}
