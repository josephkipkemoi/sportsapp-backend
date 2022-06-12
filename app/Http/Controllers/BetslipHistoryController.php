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
        $fixtures = $betslip->where('session_id', $request->session_id)->get();

        return response()->json([
            'checkout_history' => $checkout_history,
            'fixtures' => $fixtures
        ]);
    }
}
