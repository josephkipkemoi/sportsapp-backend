<?php

namespace Tests\Feature;

use App\Models\JackpotGame;
use App\Models\JackpotMarketModel;
use App\Models\JackpotResult;
use App\Models\JackpotValidateResult;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class JackpotValidationTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_validate_user_can_submit_jackpot_result_after_selecting_all_games()
    {
        $user = User::factory()->create();
        $user->balance()->increment("amount", 1000);
        
        $market = JackpotMarketModel::create([
            'market' => 'Mega Jackpot',
            'market_prize' => 1000,
            'market_id' => 201,
            'games_count' => 1,
            'min_stake' => 100
        ]);

        $game_1 = JackpotGame::create([
            'jackpot_market_id' => $market->market_id,
            'home_team' => $this->faker()->word(),
            'away_team' => $this->faker()->word(),
            'home_odds' => $this->faker()->numberBetween(1,5),
            'draw_odds' => $this->faker()->numberBetween(1,5),
            'away_odds' => $this->faker()->numberBetween(1,5),
            'kick_off_time' => $this->faker()->date(),
            'jackpot_bet_id' => $this->faker()->word()
        ]);

        $jackpot_res = JackpotResult::create([
            'user_id' => $user->id,
            'jackpot_market_id' => $game_1->jackpot_market_id,
            'game_id' => $game_1->id,
            'picked' => $game_1->home_team,
            'jackpot_bet_id' => $game_1->jackpot_bet_id
        ]);

        $response = $this->post("api/jackpots/results/validate", [
            'user_id' => $jackpot_res->user_id,
            'market_id' => $jackpot_res->jackpot_market_id,
            'picked_games_count' => 1,
            'jackpot_bet_id' => $jackpot_res->jackpot_bet_id
        ]);

        $response->assertCreated();
    }

    public function test_user_can_get_jackpot_result_history()
    {
        $user = User::factory()->create();
        $user->balance()->increment("amount", 1000);
        
        $market = JackpotMarketModel::create([
            'market' => 'Mega Jackpot',
            'market_prize' => 1000,
            'market_id' => 201,
            'games_count' => 1,
            'min_stake' => 100
        ]);

        $game_1 = JackpotGame::create([
            'jackpot_market_id' => $market->market_id,
            'home_team' => $this->faker()->word(),
            'away_team' => $this->faker()->word(),
            'home_odds' => $this->faker()->numberBetween(1,5),
            'draw_odds' => $this->faker()->numberBetween(1,5),
            'away_odds' => $this->faker()->numberBetween(1,5),
            'kick_off_time' => $this->faker()->date(),
            'jackpot_bet_id' => $this->faker()->word()
        ]);

        $jackpot_res = JackpotResult::create([
            'user_id' => $user->id,
            'jackpot_market_id' => $game_1->jackpot_market_id,
            'game_id' => $game_1->id,
            'picked' => $game_1->home_team,
            'jackpot_bet_id' => $this->faker()->word(),
            'jackpot_bet_id' => $game_1->jackpot_bet_id
        ]);

        $res = JackpotValidateResult::create([
            'user_id' => $jackpot_res->user_id,
            'market_id' => $jackpot_res->jackpot_market_id,
            'picked_games_count' => 1,
            'jackpot_bet_id' => $this->faker()->word()
        ]);

        $response = $this->get("api/jackpots/$res->market_id/users/$res->user_id/results");

        $response->assertOk();
    }

    public function test_user_can_view_all_jackpots_placed()
    {
        $user = User::factory()->create();
        $user->balance()->increment("amount", 1000);
        
        $market = JackpotMarketModel::create([
            'market' => 'Mega Jackpot',
            'market_prize' => 1000,
            'market_id' => 201,
            'games_count' => 1,
            'min_stake' => 100
        ]);

        $game_1 = JackpotGame::create([
            'jackpot_market_id' => $market->market_id,
            'home_team' => $this->faker()->word(),
            'away_team' => $this->faker()->word(),
            'home_odds' => $this->faker()->numberBetween(1,5),
            'draw_odds' => $this->faker()->numberBetween(1,5),
            'away_odds' => $this->faker()->numberBetween(1,5),
            'kick_off_time' => $this->faker()->date(),
            'jackpot_bet_id' => $this->faker()->word()
        ]);

        $jackpot_res = JackpotResult::create([
            'user_id' => $user->id,
            'jackpot_market_id' => $game_1->jackpot_market_id,
            'game_id' => $game_1->id,
            'picked' => $game_1->home_team,
            'jackpot_bet_id' => $game_1->jackpot_bet_id
        ]);

        $res = JackpotValidateResult::create([
            'user_id' => $jackpot_res->user_id,
            'market_id' => $jackpot_res->jackpot_market_id,
            'picked_games_count' => 1,
            'jackpot_bet_id' => $jackpot_res->jackpot_bet_id
        ]);

        $response = $this->get("api/jackpots/users/$res->user_id/results");

        $response->assertOk();
    }
}
