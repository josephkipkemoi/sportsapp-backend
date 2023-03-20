<?php

namespace Tests\Feature;

use App\Models\JackpotGame;
use App\Models\JackpotMarketModel;
use App\Models\JackpotResult;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertSame;

class JackpotGameTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_cannot_post_jackpot_games_with_insufficient_balance()
    {
        $user = User::factory()->create();

        $market = JackpotMarketModel::create([
            'market' => 'Mega Jackpot',
            'market_prize' => 1000,
            'market_id' => 201,
            'games_count' => 5,
            'min_stake' => 100
        ]);

        $game_1 = JackpotGame::create([
            'jackpot_market_id' => $market->market_id,
            'home_team' => $this->faker()->word(),
            'away_team' => $this->faker()->word(),
            'home_odds' => $this->faker()->numberBetween(1,5),
            'draw_odds' => $this->faker()->numberBetween(1,5),
            'away_odds' => $this->faker()->numberBetween(1,5),
            'kick_off_time' => $this->faker()->date()
        ]);

        $response = $this->post("api/jackpots/$market->market_id/users/$user->id/games", [
            'user_id' => $user->id,
            'jackpot_market_id' => $market->market_id,
            'game_id' => $game_1->id,
            'picked' => $game_1->home_team,
            'picked_games_count' => 1
        ]);

        $response->assertStatus(400);
    }

    public function test_user_cannot_post_jackpot_games_having_picked_less_games_than_required()
    {
        $user = User::factory()->create();
        $user->balance()->increment("amount", 1000);

        $market = JackpotMarketModel::create([
            'market' => 'Mega Jackpot',
            'market_prize' => 1000,
            'market_id' => 201,
            'games_count' => 5,
            'min_stake' => 100
        ]);

        $game_1 = JackpotGame::create([
            'jackpot_market_id' => $market->market_id,
            'home_team' => $this->faker()->word(),
            'away_team' => $this->faker()->word(),
            'home_odds' => $this->faker()->numberBetween(1,5),
            'draw_odds' => $this->faker()->numberBetween(1,5),
            'away_odds' => $this->faker()->numberBetween(1,5),
            'kick_off_time' => $this->faker()->date()
        ]);
        JackpotGame::create([
            'jackpot_market_id' => $market->market_id,
            'home_team' => $this->faker()->word(),
            'away_team' => $this->faker()->word(),
            'home_odds' => $this->faker()->numberBetween(1,5),
            'draw_odds' => $this->faker()->numberBetween(1,5),
            'away_odds' => $this->faker()->numberBetween(1,5),
            'kick_off_time' => $this->faker()->date()
        ]);

        $response = $this->post("api/jackpots/$market->market_id/users/$user->id/games", [
            'user_id' => $user->id,
            'jackpot_market_id' => $market->market_id,
            'game_id' => $game_1->id,
            'picked' => $game_1->home_team,
            'picked_games_count' => 1
        ]);

        $response->assertStatus(400);
    }

    public function test_user_can_post_jackpot_games_with_sufficient_balance_and_having_picked_required_number_of_games_in_jackpot_market()
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

        $remaining_balance = $user->balance->amount - $market->min_stake;

        $game_1 = JackpotGame::create([
            'jackpot_market_id' => $market->market_id,
            'home_team' => $this->faker()->word(),
            'away_team' => $this->faker()->word(),
            'home_odds' => $this->faker()->numberBetween(1,5),
            'draw_odds' => $this->faker()->numberBetween(1,5),
            'away_odds' => $this->faker()->numberBetween(1,5),
            'kick_off_time' => $this->faker()->date()
        ]);

        $response = $this->post("api/jackpots/$market->market_id/users/$user->id/games", [
            'user_id' => $user->id,
            'jackpot_market_id' => $market->market_id,
            'game_id' => $game_1->id,
            'picked' => $game_1->home_team,
            'picked_games_count' => 1
        ]);

        $response->assertStatus(201);
        assertSame($remaining_balance, $user->balance()->first()->amount);
    }

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
            'kick_off_time' => $this->faker()->date()
        ]);

        $jackpot_res = JackpotResult::create([
            'user_id' => $user->id,
            'jackpot_market_id' => $game_1->jackpot_market_id,
            'game_id' => $game_1->id,
            'picked' => $game_1->home_team
        ]);

        $response = $this->post("api/jackpots/results/validate", [
            'user_id' => $jackpot_res->user_id,
            'market_id' => $jackpot_res->jackpot_market_id,
            'picked_games_count' => 1
        ]);

        $response->assertCreated();
    }


    public function test_admin_can_post_jackpot_game()
    {
        $market = JackpotMarketModel::create([
            'market' => 'Mega Jackpot',
            'market_prize' => 1000,
            'market_id' => 201,
            'games_count' => 5,
            'min_stake' => 100
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

    public function test_admin_cannot_post_game_once_limit_is_reached()
    {
        $market = JackpotMarketModel::create([
            'market' => 'Mega Jackpot',
            'market_prize' => 1000,
            'market_id' => 201,
            'games_count' => 5,
            'min_stake' => 100
        ]);
        JackpotGame::create([
            'jackpot_market_id' => $market->market_id,
            'home_team' => $this->faker()->word(),
            'away_team' => $this->faker()->word(),
            'home_odds' => $this->faker()->numberBetween(1,5),
            'draw_odds' => $this->faker()->numberBetween(1,5),
            'away_odds' => $this->faker()->numberBetween(1,5),
            'kick_off_time' => $this->faker()->date()
        ]);
        JackpotGame::create([
            'jackpot_market_id' => $market->market_id,
            'home_team' => $this->faker()->word(),
            'away_team' => $this->faker()->word(),
            'home_odds' => $this->faker()->numberBetween(1,5),
            'draw_odds' => $this->faker()->numberBetween(1,5),
            'away_odds' => $this->faker()->numberBetween(1,5),
            'kick_off_time' => $this->faker()->date()
        ]);
        JackpotGame::create([
            'jackpot_market_id' => $market->market_id,
            'home_team' => $this->faker()->word(),
            'away_team' => $this->faker()->word(),
            'home_odds' => $this->faker()->numberBetween(1,5),
            'draw_odds' => $this->faker()->numberBetween(1,5),
            'away_odds' => $this->faker()->numberBetween(1,5),
            'kick_off_time' => $this->faker()->date()
        ]);
        JackpotGame::create([
            'jackpot_market_id' => $market->market_id,
            'home_team' => $this->faker()->word(),
            'away_team' => $this->faker()->word(),
            'home_odds' => $this->faker()->numberBetween(1,5),
            'draw_odds' => $this->faker()->numberBetween(1,5),
            'away_odds' => $this->faker()->numberBetween(1,5),
            'kick_off_time' => $this->faker()->date()
        ]);
        JackpotGame::create([
            'jackpot_market_id' => $market->market_id,
            'home_team' => $this->faker()->word(),
            'away_team' => $this->faker()->word(),
            'home_odds' => $this->faker()->numberBetween(1,5),
            'draw_odds' => $this->faker()->numberBetween(1,5),
            'away_odds' => $this->faker()->numberBetween(1,5),
            'kick_off_time' => $this->faker()->date()
        ]);
        JackpotGame::create([
            'jackpot_market_id' => $market->market_id,
            'home_team' => $this->faker()->word(),
            'away_team' => $this->faker()->word(),
            'home_odds' => $this->faker()->numberBetween(1,5),
            'draw_odds' => $this->faker()->numberBetween(1,5),
            'away_odds' => $this->faker()->numberBetween(1,5),
            'kick_off_time' => $this->faker()->date()
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

        $response->assertStatus(400);
    }

    public function test_can_get_jackpot_games()
    {
        $market = JackpotMarketModel::create([
            'market' => 'Mega Jackpot',
            'market_prize' => 1000,
            'market_id' => 201,
            'games_count' => 5,
            'min_stake' => 100
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
            'games_count' => 5,
            'min_stake' => 100
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
            'games_count' => 5,
            'min_stake' => 100
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
            'games_count' => 5,
            'min_stake' => 100
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

  
    public function test_can_update_jackpot_stored_result()
    {
        $user = User::factory()->create();

        $market = JackpotMarketModel::create([
            'market' => 'Mega Jackpot',
            'market_prize' => 1000,
            'market_id' => 201,
            'games_count' => 5,
            'min_stake' => 100
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

        $result = JackpotResult::create([
            'user_id' => $user->id,
            'jackpot_market_id' => $game->jackpot_market_id,
            'picked' => 'x',
            'game_id' => $game->id
        ]);

        $response = $this->patch("api/jackpots/$result->jackpot_market_id/games/$result->game_id/users/{$user->id}/patch", [
            'outcome' => "1",
            "jackpot_market_id" => $result->jackpot_market_id,
            'game_id' => $result->game_id,
            'user_id' => $user->id
        ]);

        $response->assertOk();
        $response->assertJsonFragment([1]);
    }

    public function test_user_can_view_stored_jackpot_result()
    {
        $user = User::factory()->create();

        $market = JackpotMarketModel::create([
            'market' => 'Mega Jackpot',
            'market_prize' => 1000,
            'market_id' => 201,
            'games_count' => 5,
            'min_stake' => 100
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

        $result = JackpotResult::create([
            'user_id' => $user->id,
            'jackpot_market_id' => $game->jackpot_market_id,
            'picked' => 'x',
            'game_id' => $game->id
        ]);

        $response = $this->get("api/jackpots/{$result->jackpot_market_id}/users/$result->user_id/view", [
            'user_id' => $result->user_id,
            'jackpot_market_id' =>  $result->jackpot_market_id
        ]);

        $response->assertOk();
        $response->assertJsonCount(1);
    }
}
