<?php

namespace Tests\Feature;

use App\Models\JackpotMarket;
use App\Models\JackpotMarketModel;
use App\Models\User;
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
    public function test_admin_can_post_jackpot_game()
    {
        $market = JackpotMarketModel::create([
            'market' => 'Mega Jackpot',
            'market_prize' => 1000,
            'market_id' => 201,
            'games_count' => 5
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
            'market_id' => 201,
            'games_count' => 5
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
            'market_id' => 201,
            'games_count' => 5
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

    public function test_can_update_jackpot_game() 
    {
        $market = JackpotMarketModel::create([
            'market' => 'Mega Jackpot',
            'market_prize' => 1000,
            'market_id' => 201,
            'games_count' => 5
        ]);

        $game = $market->jackpotgames()->create([
            'jackpot_market_id' => $market->market_id,
            'home_team' => $this->faker()->word(),
            'away_team' => $this->faker()->word(),
            'home_odds' => $this->faker()->numberBetween(1,5),
            'draw_odds' => $this->faker()->numberBetween(1,5),
            'away_odds' => $this->faker()->numberBetween(1,5),
            'kick_off_time' => '2023-02-19 18:58'
        ]);

        $response = $this->patch("api/jackpots/$market->market_id/games/$game->id", [
            'home_team' => $this->faker()->word(),
            'away_team' => $this->faker()->word(),
            'home_odds' => $this->faker()->numberBetween(1,5),
            'draw_odds' => $this->faker()->numberBetween(1,5),
            'away_odds' => $this->faker()->numberBetween(1,5),
            'kick_off_time' => '2023-02-19 18:58'
        ]);

        $response->assertOk();
    }

    public function test_can_remove_jackpot_game() 
    {
        $market = JackpotMarketModel::create([
            'market' => 'Mega Jackpot',
            'market_prize' => 1000,
            'market_id' => 201,
            'games_count' => 5
        ]);

        $game = $market->jackpotgames()->create([
            'jackpot_market_id' => $market->market_id,
            'home_team' => $this->faker()->word(),
            'away_team' => $this->faker()->word(),
            'home_odds' => $this->faker()->numberBetween(1,5),
            'draw_odds' => $this->faker()->numberBetween(1,5),
            'away_odds' => $this->faker()->numberBetween(1,5),
            'kick_off_time' => '2023-02-19 18:58'
        ]);

        $response = $this->delete("api/jackpots/$market->id/games/$game->id/delete");

        $response->assertOk();
    }

    public function test_can_post_jackpot_game_result() 
    {
        $user = User::factory()->create();

        $market = JackpotMarketModel::create([
            'market' => 'Mega Jackpot',
            'market_prize' => 1000,
            'market_id' => 201,
            'games_count' => 5
        ]);

        $game = $market->jackpotgames()->create([
            'jackpot_market_id' => $market->market_id,
            'home_team' => $this->faker()->word(),
            'away_team' => $this->faker()->word(),
            'home_odds' => $this->faker()->numberBetween(1,5),
            'draw_odds' => $this->faker()->numberBetween(1,5),
            'away_odds' => $this->faker()->numberBetween(1,5),
            'kick_off_time' => '2023-02-19 18:58'
        ]);

        $response = $this->post("api/jackpots/users/{$user->id}/games/$game->id", [
            'user_id' => $user->id,
            'jackpot_market_id' => $game->jackpot_market_id,
            'game_id' => $game->id,
            'picked' => "1",
        ]);

        $response->assertCreated();
    }
}
