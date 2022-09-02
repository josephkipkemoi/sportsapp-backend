<?php

namespace App\Http\Controllers;

use App\Http\Requests\JackpotRequest;
use App\Http\Requests\StoreJackpotMarketRequest;
use App\Models\Jackpot;
use App\Models\JackpotCart;
use App\Models\JackpotMarket;
use Illuminate\Http\Request;

class JackpotController extends Controller
{
    //
    public function store(Jackpot $jackpot, JackpotRequest $request)
    {
       return $jackpot->create($request->validated());
    }

    public function index(Jackpot $jackpot, Request $request)
    {
        return $jackpot->where('jp_market', $request->query('jp_market'))->orderBy('created_at', 'DESC')->get();
    }

    public function delete(Jackpot $jackpot, $id, Request $request)
    {
        return $jackpot->where('id', $id)->where('jp_market', $request->query('jp_market'))->delete();
    }

    public function remove(Jackpot $jackpot)
    {
        return $jackpot->whereNotNull('id')->delete();
    }

    public function store_cart(JackpotCart $jp_cart, Request $request ,$id) 
    {
       return $jp_cart->create([
            'user_id' => $id,
            'jp_picked' => $request->input('jp_picked'),
            'jp_market' => $request->input('jp_market')
       ]);
    }

    public function user_index(JackpotCart $jp_cart, $id, Request $request)
    {
        if($request->query('jp') == 'All') {
            return $jp_cart->where('user_id', $id)->orderBy('created_at', 'DESC')->paginate(8);
        }

        return $jp_cart->where('user_id', $id)->where('jp_market', $request->query('jp'))->orderBy('created_at', 'DESC')->paginate(8);
    }

    public function patch(Jackpot $jackpot, $id, JackpotRequest $request) 
    {
        return $jackpot->where('id', $id)->update($request->validated());
    }

    public function status(Jackpot $jackpot, $jp_market, Request $request) 
    {
        return $jackpot->where('jp_market', $jp_market)->update(['jp_active' => $request->input('jp_active')]);
    }
    
    public function jackpot_prize(JackpotMarket $jackpot_market, StoreJackpotMarketRequest $request) 
    {
        $mega_jackpot = $jackpot_market->where('market', 'Mega Jackpot')->get()->count();
        $five_jackpot = $jackpot_market->where('market', 'Five Jackpot')->get()->count();
       
        if($mega_jackpot == 0 || $five_jackpot == 0) 
        {
            return $jackpot_market->create($request->validated());
        }

        return $jackpot_market->where('market', $request->input('market'))->update($request->validated());
    }

    public function jackpot_index(JackpotMarket $jackpot_market)
    {
        $jackpot_prizes = $jackpot_market->get(['market', 'jackpot_prize']);
        
        return response()->json([
            'data' => $jackpot_prizes,
            'MegaCount' => 10,
            'FiveCount' => 5
        ]);
    }
}
