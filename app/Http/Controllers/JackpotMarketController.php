<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatchJackpotMarketRequest;
use App\Http\Requests\StoreJackpotMarketRequest;
use App\Models\JackpotMarketModel;

class JackpotMarketController extends Controller
{
    //
    public function index()
    {
        return JackpotMarketModel::all();
    }

    public function store(StoreJackpotMarketRequest $request, JackpotMarketModel $jackpot)
    {
        return $jackpot->create($request->validated());
    }

    public function update($market_id, PatchJackpotMarketRequest $request) 
    {
        $jp =  JackpotMarketModel::where("market_id", $market_id)->update($request->validated());
        return response()->json($jp);
    }    
}
