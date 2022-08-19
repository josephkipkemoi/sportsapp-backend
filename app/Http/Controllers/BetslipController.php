<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBetslipRequest;
use App\Models\Betslip;
use Illuminate\Http\Request;

class BetslipController extends Controller
{
    //
    public function store(StoreBetslipRequest $request)
    {
        $slip = Betslip::where('fixture_id', $request->validated()['fixture_id'])->first();   
        
        if($slip == null ) {
            $slip = Betslip::create([
                'fixture_id' => $request->validated()['fixture_id'],
                'session_id' => $request->validated()['session_id'],
                'betslip_teams' => $request->validated()['betslip_teams'],
                'betslip_market' => $request->validated()['betslip_market'],
                'betslip_picked' => $request->validated()['betslip_picked'],
                'betslip_odds' =>  $request->validated()['betslip_odds'],
               ]);           
        } else {
            $slip->update([
                'betslip_teams' => $request->validated()['betslip_teams'],
                'betslip_market' => $request->validated()['betslip_market'],
                'betslip_picked' => $request->validated()['betslip_picked'],
                'betslip_odds' =>  $request->validated()['betslip_odds'],
           ]);
        }

        return response()->json([
            'data' => $slip
        ]);
    }

    public function index($session_id)
    {
        $betslip = Betslip::where('session_id', $session_id)->get();

        return response()->json([
            'data' => $betslip
        ]);
    }

    public function destroy($fixture_id)
    {
        $betslip = Betslip::where('fixture_id', $fixture_id)->delete();
 
        return response()->json([
            'data' => $betslip
        ]);
    }

    public function remove($session_id)
    {
        $betslip = Betslip::where('session_id', $session_id)->delete();

        return response()->json([
            'data' => $betslip
        ]);
    }
}
