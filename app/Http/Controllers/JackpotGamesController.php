<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJackpotGamesRequest;
use App\Http\Requests\StoreJackpotResultRequest;
use App\Http\Requests\UpdateJackpotGameRequest;
use App\Models\JackpotGame;
use App\Models\JackpotMarketModel;
use App\Models\JackpotResult;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class JackpotGamesController extends Controller
{
    //
    public function index($market_id)
    {
        $jp_market = JackpotMarketModel::where('market_id', $market_id)->get([
            'market', 'market_prize', 'market_id', 'market_active'
        ]);

        $jp_games = JackpotGame::where('jackpot_market_id', $market_id)->get([
            'id', 'jackpot_market_id', 'home_team', 'away_team', 'home_odds', 'draw_odds', 'away_odds',
            'kick_off_time', 'game_started', 'game_ended','jackpot_bet_id'
        ]);

        return response()
                ->json([
                    'jackpot_market' => $jp_market,
                    'jackpot_games' => $jp_games
                ]);
    }

    public function store_games(Request $request, JackpotResult $result)
    {       
        // $bet_id = $request->validated()['jackpot_bet_id'];
        // $game = $result->where('jackpot_bet_id', $bet_id)->first();

        // if($game == null) {
        //     return $result->create($request->validated());
        // }
        // $result->create($request->validated());
        // // return $game->update([
        // //     'picked' => $req->picked
        // // ]); 
        return "feature dropped";
    }

    public function store(JackpotGame $jackpotmarket, StoreJackpotGamesRequest $request) 
    {
        $jp = JackpotMarketModel::where('market_id', $request->jackpot_market_id);
        $jp_market_limit = $jp->first()->games_count;
        $jp_market_count = $jackpotmarket->where('jackpot_market_id', $request->jackpot_market_id)->count();

        if($jp_market_count >= $jp_market_limit) {
            return response()
                        ->json([
                            'message' => "{$jp->first()->market} Limit reached!"
                        ], 400);
        }

        return $jackpotmarket->create($request->validated());
    }

    public function patch(JackpotMarketModel $jackpotmarket)
    {
        $market = JackpotGame::where('kick_off_time', '<=' ,Carbon::now('Africa/Nairobi'))->first();
        if ($market == null) {
            return $jackpotmarket->where('market_id', $market->market_id)->update([
                'market_active' => false,
            ]);
        }

        if(
            $market->kick_off_time->format('H:i:s') <= Carbon::now('Africa/Nairobi')->format('H:i:s') == true
        ) {
            return $jackpotmarket->where('market_id', $market->market_id)->update([
                'market_active' => false,
            ]);
        };

    }

    public function update(UpdateJackpotGameRequest $request, $market_id, $game_id, JackpotGame $jp_game)
    {
      return $jp_game->where('jackpot_market_id',$market_id)->where('id', $game_id)->update($request->validated());
    }

    public function delete(JackpotGame $jp_game, $market_id, $game_id)
    {
        return $jp_game->where("jackpot_market_id", $market_id)->where("id", $game_id)->delete();
    }
}
