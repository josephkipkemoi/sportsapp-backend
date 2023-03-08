<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatchJackpotResultRequest;
use App\Http\Requests\StoreJackpotResultRequest;
use App\Models\JackpotResult;
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
        return $result->create($request->validated());
    }

    public function patch(PatchJackpotResultRequest $request, JackpotResult $result)
    {
        return $result->where("user_id", $request->user_id)
                    ->where("jackpot_market_id", $request->jackpot_market_id)
                    ->where("game_id", $request->game_id)
                    ->update($request->validated());     
    }
}
