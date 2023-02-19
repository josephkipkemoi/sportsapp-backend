<?php

namespace Tests\Feature;

use App\Models\JackpotMarketModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class JackpotMarketGamesTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_post_jackpot_games()
    {
        $mega_jp_market = JackpotMarketModel::create([
            "market" => "Mega Jackpot",
            "market_prize" => 1000000,
            "market_id" => 201        
        ]);

        $response = $this->post("api/jackpots/markets/$mega_jp_market->market_id/games", [

        ]);

        $response->assertStatus(201);
    }
}
