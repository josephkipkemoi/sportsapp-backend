<?php

namespace App\Http\Controllers;

use App\Models\Betslip;
use App\Models\CheckoutCart;
use App\Models\User;
use Illuminate\Http\Request;

class BetslipHistoryController extends Controller
{
    //
    public function show( Betslip $betslip, CheckoutCart $checkout, Request $request)
    {
        $checkout_history = $checkout->where('user_id', $request->user_id)->get();

        $fixtures = [];

        foreach($checkout_history as $history)
        {
            $history->fixtures = $betslip->where('session_id', $history->session_id)->get();
            array_push($fixtures, $history);
        }
        
        return response()->json([
            'data' => $fixtures
        ]);
    }
}
