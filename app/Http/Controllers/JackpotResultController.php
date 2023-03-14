<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatchJackpotResultRequest;
use App\Http\Requests\StoreJackpotResultRequest;
use App\Models\JackpotGame;
use App\Models\JackpotMarketModel;
use App\Models\JackpotResult;
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
}
