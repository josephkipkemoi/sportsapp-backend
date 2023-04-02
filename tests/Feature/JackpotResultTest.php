<?php

namespace Tests\Feature;

use App\Models\JackpotMarketModel;
use App\Models\JackpotValidateResult;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertSame;

class JackpotResultTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_cannot_post_jackpot_game_result_with_insufficient_balance() 
    {
        $user = User::factory()->create();

        $market = JackpotMarketModel::create([
            'market' => 'Mega Jackpot',
            'market_prize' => 1000,
            'market_id' => 201,
            'games_count' => 5,
            "min_stake" => 100,
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
            'picked_games_count' => 1,
            'jackpot_bet_id' => $this->faker()->word()
        ]);

        $response->assertStatus(400);
    }

    public function test_can_post_jackpot_game_result_with_sufficient_balance()
    {
        $user = User::factory()->create();
        $user->balance()->increment('amount', 101);
        $user_balance = $user->balance()->first()->amount;

        $market = JackpotMarketModel::create([
            'market' => 'Mega Jackpot',
            'market_prize' => 1000,
            'market_id' => 201,
            'games_count' => 5,
            "min_stake" => 100,
        ]);

        $remaining_balance = $user_balance - $market->min_stake;
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
            'picked_games_count' => 1,
            'jackpot_bet_id' => $this->faker()->word()
        ]);

        $response->assertStatus(201);
        assertSame($remaining_balance, $user->balance()->first()->amount);
    }

    public function test_user_can_delete_jackpot_history()
    {
        $user = User::factory()->create();
        $user->balance()->increment('amount', 101);

        $market = JackpotMarketModel::create([
            'market' => 'Mega Jackpot',
            'market_prize' => 1000,
            'market_id' => 201,
            'games_count' => 5,
            "min_stake" => 100,
        ]);

        $game = $market->jackpotgames()->create([
            'jackpot_market_id' => $market->market_id,
            'home_team' => $this->faker()->word(),
            'away_team' => $this->faker()->word(),
            'home_odds' => $this->faker()->numberBetween(1,5),
            'draw_odds' => $this->faker()->numberBetween(1,5),
            'away_odds' => $this->faker()->numberBetween(1,5),
            'kick_off_time' => '2023-02-19 18:58',
            'jackpot_bet_id' => $this->faker()->word(),
        ]);

        $history = JackpotValidateResult::create([
            'market_id' => $game->jackpot_market_id,
            'user_id' => $user->id,
            'picked_games_count' => 1,
            'jackpot_bet_id' => $this->faker()->word(),
            'jackpot_games' => 1,
        ]);

        $response = $this->delete("api/jackpots/$history->id/users/$history->user_id/delete");

        $response->assertStatus(200);
    }
}
