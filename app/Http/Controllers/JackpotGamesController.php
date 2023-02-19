<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJackpotGamesRequest;
use App\Models\JackpotGame;
use App\Models\JackpotMarketModel;

class JackpotGamesController extends Controller
{
    //
    public function index($market_id)
    {
        $jp_market = JackpotMarketModel::where('market_id', $market_id)->get([
            'market',
            'market_prize',
            'market_id',
            'market_active'
        ]);

        $jp_games = JackpotGame::where('jackpot_market_id', $market_id)->get([
            'id', 'jackpot_market_id', 'home_team', 'away_team', 'home_odds', 'draw_odds', 'away_odds',
            'kick_off_time', 'game_started', 'game_ended'
        ]);

        return response()
                ->json([
                    'jackpot_market' => $jp_market,
                    'jackpot_games' => $jp_games
                ]);
    }

    public function store(JackpotMarketModel $jackpotmarket, StoreJackpotGamesRequest $request) 
    {
        return $jackpotmarket->jackpotgames()->create($request->validated());
    }
}
