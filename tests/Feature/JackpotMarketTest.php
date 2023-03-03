<?php

namespace Tests\Feature;

use App\Models\JackpotMarket;
use App\Models\JackpotMarketModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class JackpotMarketTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_post_jackpot_market()
    {
        $response = $this->post('api/jackpots/markets', [
            "market" => "Mega Jackpot",
            "market_prize" => $this->faker()->numberBetween(100000,5000000),
            "market_id" => $this->faker()->numberBetween(100,400),
            "games_count" => $this->faker()->numberBetween(5,17)
        ]);

        $response->assertStatus(201);
    }

    public function test_can_get_jackpot_markets() 
    {
        $response = $this->get('api/jackpots/markets/view');

        $response->assertStatus(200);
    }

    public function test_can_update_jackpot_market_prize() 
    {
        /*
            Mega Jackpot Updated every Monday
            Mid Week Jackpot updated every Sunday
            Daily Jackpot updated daily at midnight (EA Time)
        */
        $mega_jp_market = JackpotMarketModel::create([
            "market" => "Mega Jackpot",
            "market_prize" => 1000000,
            "market_id" => 201,
            "games_count" => $this->faker()->numberBetween(5,17) 
        ]);

        $response = $this->patch("api/jackpots/markets/$mega_jp_market->market_id/patch", [
            "market_prize" => 2000000
        ]);
        
        $response->assertOk();
    }
}
