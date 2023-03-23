<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatchJackpotResultRequest;
use App\Http\Requests\StoreJackpotResultRequest;
use App\Http\Requests\ValidateJackpotResultRequest;
use App\Models\JackpotGame;
use App\Models\JackpotMarketModel;
use App\Models\JackpotResult;
use App\Models\JackpotValidateResult;
use App\Models\User;
use Illuminate\Http\Request;

class JackpotResultController extends Controller
{
    //
    public function index(Request $request)
    {
        return JackpotResult::where('user_id', $request->user_id)
                            ->where('jackpot_market_id', $request->jackpot_market_id)
                            ->get();
    }

    public function store(StoreJackpotResultRequest $request, JackpotResult $result)
    {
        $user = User::find($request->user_id);
        $balance = $user->balance()->first()->amount;
        $jackpot_market = JackpotMarketModel::where("market_id",$request->jackpot_market_id)->first();
        $min_stake = $jackpot_market->min_stake;
        
        if($balance >= $min_stake) {
            $user->balance()->first()->decrement('amount', $min_stake);

            return $result->create($request->validated());
        }

        return response()
        ->json([
            'message' => 'Insufficient Balance. Top up to continue.'
        ], 400);
      
    }

    public function patch(PatchJackpotResultRequest $request, JackpotResult $result)
    {
        return $result->where("user_id", $request->user_id)
                    ->where("jackpot_market_id", $request->jackpot_market_id)
                    ->where("game_id", $request->game_id)
                    ->update($request->validated());     
    }

    public function validate_jackpot(ValidateJackpotResultRequest $request, JackpotValidateResult $result)
    {
        $user_id = $request->validated()['user_id'];
        $market_id = $request->validated()['market_id'];

        $user = User::find($user_id);
        $user_balance = $user->balance->amount;
        $user_picked_games_count = $request->validated()['picked_games_count'];

        $market = JackpotMarketModel::where('market_id', $market_id)->first();
        $market_games_count = $market->games_count;
        $market_min_stake = $market->min_stake;

        if($user_balance < $market_min_stake) {
            return response()
                        ->json([
                            "message" => "Insufficient balance, Please top up to place $market->market"
                        ], 400);
        }

        if($user_picked_games_count != $market_games_count) {
            return response()
                        ->json([
                                "message" => "You need to pick all games in this Jackpot market to submit"
                        ], 400);
        }

        $user->balance()->decrement("amount", $market_min_stake);
        $result->create($request->validated()); 

        return response()
                ->json([
                    'message' => "Congratulations! $market->market placed succesfully."
                ], 201);
    }

    public function show($user_id, $market_id)
    {
        $pick = JackpotResult::where("user_id", $user_id)->where("jackpot_market_id", $market_id)->get(['picked', 'outcome']);
        $res = JackpotResult::where("user_id", $user_id)->get(['game_id']);
        $games = JackpotGame::whereIn('id', $res)->get();

        return response()
                ->json([
                    "games" => $games,
                    "pick" => $pick
                ],200);
    }

    public function show_jackpot($user_id)
    {
        $games = JackpotResult::where("user_id", $user_id)->get();
    
        return response()
                ->json([
                    "games" => $games
                ],200);
    }
}
